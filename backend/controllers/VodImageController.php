<?php

class VodImageController extends RController
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
				'rights',
// 				'accessControl', // perform access control for CRUD operations
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
						'actions'=>array('index','view', 'upload', 'getSize'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('create','update'),
						'users'=>array('@'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('admin','delete', 'listImages'),
						'users'=>array('admin'),
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
	public function actionCreate() //neu dung CUploadedFile thi save model thuc hien trong actionUpload. Hien tai actionCreate ko dung den
	{
		$model=new VodImage;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VodImage']))
		{
			$model->attributes=$_POST['VodImage'];
			$model->picture = CUploadedFile::getInstance($model,'picture');
			$model->url = $_POST['VodImage']['picture'];
			if($model->save()) {
				$model->picture->saveAs(Yii::app()->baseUrl."backend/www/files");
				$imageSize = $model->getImageSize();
				if(count($imageSize) > 0) {
					$model->width = $imageSize[0];
					$model->height = $imageSize[1];
					if($imageSize[0] > $imageSize[1]) { //neu width > height
						$model->orientation = VodImage::ORIENTATION_LANDSCAPE;
					}
					else {
						$model->orientation = VodImage::ORIENTATION_PORTRAIT;
					}
				}
				$this->redirect(array('view','id'=>$model->id));
				return;
			}
			else {
				$this->redirect(array('view','id'=>1));
			}
		}

		$this->render('create',array(
				'model'=>$model,
		));
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

		if(isset($_POST['VodImage']))
		{
			$model->attributes=$_POST['VodImage'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('VodImage');
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VodImage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VodImage']))
			$model->attributes=$_GET['VodImage'];

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
		$model=VodImage::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='image-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Handles resource upload
	 * @throws CHttpException
	 */
	public function actionUpload()
	{
		header('Vary: Accept');
		if (isset($_SERVER['HTTP_ACCEPT']) &&
		(strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false))
		{
			header('Content-type: application/json');
		} else {
			header('Content-type: text/plain');
		}
		$data = array();

		$model = new VodImage('upload');
		$model->picture = CUploadedFile::getInstance($model, 'picture');
		$model->url = $model->picture;
		$model->vod_asset_id = isset($_REQUEST['vod_asset_id'])?$_REQUEST['vod_asset_id']:NULL;
		if ($model->picture !== null  && $model->validate(array('picture')))
		{
			$model->picture->saveAs(
			// 					Yii::getPathOfAlias('./').'/'.$model->picture->name);
// 					Yii::getPathOfAlias('backend.www.files').'/'.$model->picture->name);
					'/var/www/html/vfilmbackend/backend/www/files'.'/'.$model->picture->name);
			// 			$model->file_name = $model->picture->name;
			// save picture name
			$imageSize = $model->getImageSize();
			if(count($imageSize) > 0) {
				$model->width = $imageSize[0];
				$model->height = $imageSize[1];
				if($imageSize[0] > $imageSize[1]) { //neu width > height
					$model->orientation = VodImage::ORIENTATION_LANDSCAPE;
				}
				else {
					$model->orientation = VodImage::ORIENTATION_PORTRAIT;
				}
			}
			if( $model->save())
			{
				// return data to the fileuploader
				$data[] = array(
						'name' => $model->picture->name,
						'type' => $model->picture->type,
						'size' => $model->picture->size,
						// we need to return the place where our image has been saved
						'url' => $model->url, // Should we add a helper method?
						// we need to provide a thumbnail url to display on the list
						// after upload. Again, the helper method now getting thumbnail.
				// 						'thumbnail_url' => $model->getImageUrl(Image::IMG_THUMBNAIL),
						// we need to include the action that is going to delete the picture
						// if we want to after loading
						'delete_url' => $this->createUrl('vodImage/delete',
								array('id' => $model->id, 'method' => 'uploader')),
						'delete_type' => 'POST');
			} else {
				// 				Yii::log($model->getErrors());
				$data[] = array('error' => 'Unable to save model after saving picture');
			}
		} else {
			if ($model->hasErrors('picture'))
			{
				$data[] = array('error', $model->getErrors('picture'));
			} else {
				throw new CHttpException(500, "Could not upload file ".     CHtml::errorSummary($model));
			}
		}
		// JQuery File Upload expects JSON data
		echo json_encode($data);
	}
	
	public function actionListImages() {
		$car_id = isset($_REQUEST['car_id'])?$_REQUEST['car_id']:NULL;
		$car_news_id = isset($_REQUEST['car_news_id'])?$_REQUEST['car_news_id']:NULL;
		$car_brand_id = isset($_REQUEST['car_brand_id'])?$_REQUEST['car_brand_id']:NULL;
		$car_dealer_id = isset($_REQUEST['car_dealer_id'])?$_REQUEST['car_dealer_id']:NULL;
		$accessory_id = isset($_REQUEST['accessory_id'])?$_REQUEST['accessory_id']:NULL;
		$vod_asset_id = isset($_REQUEST['vod_asset_id'])?$_REQUEST['vod_asset_id']:NULL;
		
		$model=new VodImage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VodImage']))
			$model->attributes=$_GET['VodImage'];
		
		$this->render('listImages',array(
				'model'=>$model,
				'car_id'=>$car_id,
				'car_news_id'=>$car_news_id,
				'car_brand_id'=>$car_brand_id,
				'car_dealer_id'=>$car_dealer_id,
				'accessory_id'=>$accessory_id,
				'vod_asset_id'=>$vod_asset_id,
		));
	}
	
// 	public function actionGetSize($id) {
// 		$image = VodImage::model()->findByPk($id);
// 		/* @var $image VodImage */
// 		if($image != NULL) {
// 			echo $image->getImageSize()[0].' - '.$image->getImageSize()[1];
// 		}
// 	}
}
