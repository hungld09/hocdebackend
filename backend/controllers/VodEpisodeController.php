<?php

class VodEpisodeController extends RController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
//  				'accessControl', // perform access control for CRUD operations
			'rights',
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
				array('allow',  // allow all users to perform 'index' and 'view' actions
						'actions'=>array('index','view'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('create','update'),
						'users'=>array('@'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('admin','delete'),
						'users'=>array('admin','anhchien', 'hung'),
				),
				array('deny',  // deny all users
						'users'=>array('*'),
				),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
				'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new VodEpisode;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VodEpisode']))
		{
			$model->attributes=$_POST['VodEpisode'];
			$fromOrder = $_POST['VodEpisode']['episodeFrom'];
			$toOrder = $_POST['VodEpisode']['episodeTo'];

			$token = "<i>";
			$fileName_low = $_POST['VodEpisode']['episodeFileName_low'];
			$fileName_normal = $_POST['VodEpisode']['episodeFileName_normal'];
			$fileName_high = $_POST['VodEpisode']['episodeFileName_high'];

			$displayName = $_POST['VodEpisode']['display_name'];
			$vodAssetId = $_POST['VodEpisode']['vod_asset_id'];
			$vodAsset = VodAsset::model()->findByPk($vodAssetId);
			if($vodAsset == NULL) {
				$this->responseError(1,1, "vod asset id ".$vodAssetId." is not valid");
			}
			else {
				if($vodAsset->is_series == 0) {
					$this->responseError(1,1, "vod with id ".$vodAssetId." is not a serie");
				}
			}
			for($i = $fromOrder; $i <= $toOrder; $i++) {
				$episode = new VodEpisode;
				$episode->episode_order = $i;
				$episode->display_name = $displayName." ".$i;
				$episode->code_name = CVietnameseTools::makeCodeName($episode->display_name);
				$episodeTmp = VodEpisode::model()->findByAttributes(array('code_name' => $episode->code_name));
				if($episodeTmp != NULL) {
					$this->responseError(1,1, "Episode name ".$episode->code_name." is existed. Please choose another name");
				}
				$episode->is_multibitrate = 1;
				$episode->vod_asset_id = $vodAssetId;
				$episode->create_date = new CDbExpression('NOW()');
				//                            $episode->status = VodEpisode::EPISODE_STATUS_PENDING;
				if(!$episode->save()) {
					print_r($episode->getErrors()); exit;
					$this->responseError(1,1, "Cannot save episode name ".$episode->code_name." - order ".$episode->episode_order." of vod ".$episode->vod_asset_id);
				}
				/*$episodeStream_low = new VodStream();
				$episodeStream_low->vod_episode_id = $episode->id;
				$episodeFileName_low = str_replace($token, $i, $fileName_low);
				$episodeStream_low->stream_url = $episodeFileName_low;

				$episodeStream_normal = new VodStream();
				$episodeStream_normal->vod_episode_id = $episode->id;
				$episodeFileName_normal = str_replace($token, $i, $fileName_normal);
				$episodeStream_normal->stream_url = $episodeFileName_normal;

				$episodeStream_high = new VodStream();
				$episodeStream_high->vod_episode_id = $episode->id;
				$episodeFileName_high = str_replace($token, $i, $fileName_high);
				$episodeStream_high->stream_url = $episodeFileName_high;*/

                if($i < 10){
                    $oi = 0;
                }else{
                    $oi = '';
                }

                $episodeStream_low = new VodStream();
                $episodeStream_low->vod_episode_id = $episode->id;
                //$episodeFileName_low = str_replace($token, $i, $fileName_low);
                $episodeStream_low->stream_url = $fileName_low."_".$oi.$i."_low.mp4";

                $episodeStream_normal = new VodStream();
                $episodeStream_normal->vod_episode_id = $episode->id;
                //$episodeFileName_normal = str_replace($token, $i, $fileName_normal);
                $episodeStream_normal->stream_url = $fileName_normal."_".$oi.$i."_normal.mp4";

                $episodeStream_high = new VodStream();
                $episodeStream_high->vod_episode_id = $episode->id;
                //$episodeFileName_high = str_replace($token, $i, $fileName_high);
                $episodeStream_high->stream_url = $fileName_high."_".$oi.$i."_high.mp4";

				if(!$episodeStream_low->save() || !$episodeStream_normal->save() || !$episodeStream_high->save()) {
					$this->responseError(1,1, "Cannot save episodeStream ".$episodeStream_low->stream_url);
				}
			}

			$episodeCount = 0;
			foreach($vodAsset->vodEpisodes as $episodeObj) {
				$episodeCount++;
			}
			$vodAsset->episode_count = $episodeCount; //tam thoi dung order_in_series de tin so episode
			$vodAsset->update();
			$this->redirect(array('vodAsset/'.$episode->vod_asset_id));
		}

		$this->render('create',array(
				'model'=>$model,
		));
	}

	private function makeStreamUrl($serverIP, $fileName, $protocol) {
		$url = "";
		switch ($protocol) {
			case VodStream::STREAM_PROTOCOL_RTSP:
				$url = "rtsp://" . $serverIP . "/vod/" .  $fileName;
				break;
			case VodStream::STREAM_PROTOCOL_HLS:
				$url = "http://" . $serverIP . ":1935/vod/" .  $fileName . "/playlist.m3u8";
				break;
		}
		return $url;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VodEpisode']))
		{
			$model->attributes=$_POST['VodEpisode'];
			$episodeStreamUrl_low = $_POST['VodStream']['stream_low'];
			$episodeStreamId_low = $_POST['VodStream']['id_low'];
			$episodeStream_low = VodStream::model()->findByPk($episodeStreamId_low);
			if($episodeStream_low->stream_url != $episodeStreamUrl_low) {
				$episodeStream_low->stream_url = $episodeStreamUrl_low;
				$episodeStream_low->update();
			}

			$episodeStreamUrl_normal = $_POST['VodStream']['stream_normal'];
			$episodeStreamId_normal = $_POST['VodStream']['id_normal'];
			$episodeStream_normal = VodStream::model()->findByPk($episodeStreamId_normal);
			if($episodeStream_normal->stream_url != $episodeStreamUrl_normal) {
				$episodeStream_normal->stream_url = $episodeStreamUrl_normal;
				$episodeStream_normal->update();
			}
				
			$episodeStreamUrl_high = $_POST['VodStream']['stream_high'];
			$episodeStreamId_high = $_POST['VodStream']['id_high'];
			$episodeStream_high = VodStream::model()->findByPk($episodeStreamId_high);
			if($episodeStream_high->stream_url != $episodeStreamUrl_high) {
				$episodeStream_high->stream_url = $episodeStreamUrl_high;
				$episodeStream_high->update();
			}
			
			if($model->save()){
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
				'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('VodEpisode');
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VodEpisode('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VodEpisode']))
			$model->attributes=$_GET['VodEpisode'];

		$this->render('admin',array(
				'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=VodEpisode::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vod-episode-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


	/**
	 *
	 * @param type $error_no
	 * @param type $error_code
	 * @param type $message
	 */
	public function responseError($error_no, $error_code, $message) {
		header("Content-type: text/xml; charset=utf-8");
		$xmlDoc = new DOMDocument();
		$xmlDoc->encoding = "UTF-8";
		$xmlDoc->version = "1.0";

		//TODO: authen, session, error handle
		$root = $xmlDoc->appendChild($xmlDoc->createElement("response"));
		$root->appendChild($xmlDoc->createElement("action", $this->action->id));
		$root->appendChild($xmlDoc->createElement("error_no", $error_no));
		$root->appendChild($xmlDoc->createElement("error_code", $error_code));
		$root->appendChild($xmlDoc->createElement("error_message", CHtml::encode($message)));

		echo $xmlDoc->saveXML();
		Yii::app()->end();
	}
}
