<?php

class VodAssetController extends RController
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
						'actions'=>array('index','view', 'addStream','getListStream'),
						'users'=>array('*'),
				),
				array('allow', // allow authenticated user to perform 'create' and 'update' actions
						'actions'=>array('create','createYoutubeAsset','update','viewFeedback','viewYoutubeAsset',
								'updateShortDescription','updateDescription','updateBasicInfo','updateTags','updateCategoryInfo','updateDisplayName',
								'updateSeriesInfo','changeActive','updateFeedbackInfo','updateCommentInfo','changeCommentStatus',
								'addStream','updateStream','getListAsset','getListStream','updateAttributeValue',
								'paging','getListComment','getListImages','saveImage','deleteImage','uploadImage',
								'loadseries','loadseriesforupdate','loadstreamforupdate','deleteStream','deleteAsset',
								'sort','moveup','movedown','getcodename','addIntoCategory','addIntoPackage'),
						'users'=>array('admin'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('admin','delete','deleteAssets'),
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
	public function actionCreate()
	{
		$model=new VodAsset;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VodAsset']))
		{
			$model->attributes=$_POST['VodAsset'];
			$model->code_name = CVietnameseTools::makeCodeName($model->display_name).time();
			$model->display_name_ascii = CVietnameseTools::makeSearchableStr($model->display_name);
			$model->create_date = new CDbExpression("NOW()");
			$model->is_free = 0;
			$model->price = 2000;
			if($model->save()) {
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['VodAsset']))
		{
			$model->attributes=$_POST['VodAsset'];
			$model->modify_date = date('Y-m-d H:i:s', time());
			$model->display_name_ascii = CVietnameseTools::makeSearchableStr($model->display_name);
// 			echo $_POST['VodAsset']['actors']." ************ ";
// 			echo $model->actors; exit;
// 			$model->actors = $_POST['VodAsset']['actors'];
// 			$model->director = $_POST['VodAsset']['director'];
			if($model->save()) {
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
		$dataProvider=new CActiveDataProvider('VodAsset');
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new VodAsset('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['VodAsset']))
			$model->attributes=$_GET['VodAsset'];

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
		$model=VodAsset::model()->findByPk($id);
		$listCategory='';
		if($model!=null) {
			foreach ($model->vodCategoryAssetMappings AS $vodCategoryAssetMapping) {
				$listCategory .= ' '.$vodCategoryAssetMapping->vod_category_id.', ';
			}
			$model->categories=$listCategory;
			//                    if ($model->is_series)
			//                        $model->seriesName=$model->display_name;
		}
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='vod-asset-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionSort()
	{
		if (isset($_POST['items']) && is_array($_POST['items'])) {
			$i = 1;
			$order = VodAsset::model()->findByPk($_POST['items'][0])->order_in_series;
			if ($order%20!=0) {
				$page =  floor($order/20);
			} else {
				$page = $order/20 - 1;
			}
			//                foreach ($_POST['items'] as $item) {
			//                    $vodAsset = VodAsset::model()->findByPk($item);
			//                    $oldOrder = $vodAsset->order_in_series;
			//                    $newOrder = $i + $page*20;
			//                    if ($oldOrder < $newOrder){
			//                        $vodAsset1 = $vodAsset;
			//                    }
			//                    if ($oldOrder > $newOrder) {
			//                        $vodAsset2 = $vodAsset;
			//                    }
			//                    $i++;
			//                }
			//
			//                if ($vodAsset2->nextInSeries!=NULL) {
			//                     $nextVodAsset = $vodAsset2->nextInSeries;
			//                     $nextVodAsset->previous_in_series_id = $vodAsset1->id;
			//                     $nextVodAsset->save();
			//                     }
			//                if ($vodAsset1->previousInSeries!=NULL) {
			//                     $previousVodAsset = $vodAsset1->previousInSeries;
			//                     $previousVodAsset->next_in_series_id = $vodAsset2->id;
			//                     $previousVodAsset->save();
			//                     }
			//
			//
			//                if ($vodAsset2->order_in_series != $vodAsset1->order_in_series + 1) {
			//                    $vodAsset1->previous_in_series_id ^= $vodAsset2->previous_in_series_id ^= $vodAsset1->previous_in_series_id ^= $vodAsset2->previous_in_series_id;
				//                    $vodAsset1->next_in_series_id ^= $vodAsset2->next_in_series_id ^= $vodAsset1->next_in_series_id ^= $vodAsset2->next_in_series_id;
				//                    if ($vodAsset2->previousInSeries!=NULL) {
				//                         $previousVodAsset = $vodAsset2->previousInSeries;
				//                         $previousVodAsset->previous_in_series_id = $vodAsset1->id;
				//                         $previousVodAsset->save();
				//                     }
				//                    if ($vodAsset1->nextInSeries!=NULL) {
				//                         $nextVodAsset = $vodAsset1->nextInSeries;
				//                         $nextVodAsset->next_in_series_id = $vodAsset2->id;
				//                         $nextVodAsset->save();
				//                     }
				//                } else {
				//                    $vodAsset2->previous_in_series_id = $vodAsset1->previous_in_series_id;
				//                    $vodAsset1->next_in_series_id = $vodAsset2->next_in_series_id;
				//                    $vodAsset2->next_in_series_id = $vodAsset1->id;
				//                    $vodAsset1->previous_in_series_id = $vodAsset2->id;
				//
				//                }
				//                $vodAsset1->order_in_series ^= $vodAsset2->order_in_series ^= $vodAsset1->order_in_series ^= $vodAsset2->order_in_series;
				//                $vodAsset1->save();
				//                $vodAsset2->save();
				$items = array();
				$previousOrder = (int)$page*20;
				$nextOrder = (int)($page+1)*20+1;
				foreach ($_POST['items'] as $item) {
					$vodAsset = VodAsset::model()->findByPk($item);
					$vodAsset->order_in_series = $i + $page*20;
					$items = array_merge($items,array($vodAsset));
					$i++;
				}

				for ($j=0;$j<count($items);$j++) {
					$vodAsset = $items[$j];
					if ($j==0) {


						$previousAsset = VodAsset::model()->findByAttributes(array('order_in_series'=>$previousOrder,'vod_series_id'=>$vodAsset->vod_series_id));
						if ($previousAsset!=NULL) {
							$vodAsset->previous_in_series_id = $previousAsset->id;
						} else $vodAsset->previous_in_series_id = NULL;
					} else $vodAsset->previous_in_series_id = $items[$j-1]->id;

					if ($j==(count($items)-1)) {
						$nextAsset = VodAsset::model()->findByAttributes(array('order_in_series'=>$nextOrder,'vod_series_id'=>$vodAsset->vod_series_id));
						if ($nextAsset!=NULL) {
							$vodAsset->next_in_series_id = $nextAsset->id;
						} else $vodAsset->next_in_series_id = NULL;
					} else $vodAsset->next_in_series_id = $items[$j+1]->id;
					$vodAsset->save();

				}
			}
		}

		public function actionMoveUp() {
			$id = $_POST['VodAsset']['id'];
			$pageSize = $_POST['VodAsset']['pageSize'];
			$vodAsset1 = VodAsset::model()->findByPk($id);
			$vodAsset2 = $vodAsset1->previousInSeries;

			if ($vodAsset1->nextInSeries!=NULL) {
				$nextVodAsset = $vodAsset1->nextInSeries;
				$nextVodAsset->previous_in_series_id = $vodAsset2->id;
				$nextVodAsset->save();
			}
			if ($vodAsset2->previousInSeries!=NULL) {
				$previousVodAsset = $vodAsset2->previousInSeries;
				$previousVodAsset->next_in_series_id = $vodAsset1->id;
				$previousVodAsset->save();
			}
			$vodAsset1->previous_in_series_id = $vodAsset2->previous_in_series_id;
			$vodAsset2->next_in_series_id = $vodAsset1->next_in_series_id;
			$vodAsset1->next_in_series_id = $vodAsset2->id;
			$vodAsset2->previous_in_series_id = $vodAsset1->id;
			$vodAsset1->order_in_series ^= $vodAsset2->order_in_series ^= $vodAsset1->order_in_series ^= $vodAsset2->order_in_series;
			$vodAsset1->save();
			$vodAsset2->save();

			if ($vodAsset1->order_in_series%$pageSize==0)
				$page = ($vodAsset1->order_in_series/$pageSize)-1;
			else $page = ceil($vodAsset1->order_in_series/$pageSize);
			echo $page;
		}

		public function actionMoveDown() {
			$id = $_POST['VodAsset']['id'];
			$pageSize = $_POST['VodAsset']['pageSize'];
			$vodAsset1 = VodAsset::model()->findByPk($id);
			$vodAsset2 = $vodAsset1->nextInSeries;

			if ($vodAsset2->nextInSeries!=NULL) {
				$nextVodAsset = $vodAsset2->nextInSeries;
				$nextVodAsset->previous_in_series_id = $vodAsset1->id;
				$nextVodAsset->save();
			}
			if ($vodAsset1->previousInSeries!=NULL) {
				$previousVodAsset = $vodAsset1->previousInSeries;
				$previousVodAsset->next_in_series_id = $vodAsset2->id;
				$previousVodAsset->save();
			}
			$vodAsset2->previous_in_series_id = $vodAsset1->previous_in_series_id;
			$vodAsset1->next_in_series_id = $vodAsset2->next_in_series_id;
			$vodAsset2->next_in_series_id = $vodAsset1->id;
			$vodAsset1->previous_in_series_id = $vodAsset2->id;
			$vodAsset1->order_in_series ^= $vodAsset2->order_in_series ^= $vodAsset1->order_in_series ^= $vodAsset2->order_in_series;
			$vodAsset1->save();
			$vodAsset2->save();

			if ($vodAsset1->order_in_series%$pageSize==0)
				$page = ($vodAsset1->order_in_series/$pageSize)-1;
			else $page = ceil($vodAsset1->order_in_series/$pageSize);
			echo $page;
		}

		public function actionGetcodename() {
			if ($_GET['new']) {
				$displayName = $_POST['VodAsset']['display_name'];
				$codeName = CVietnameseTools::makeCodeName($displayName);
				echo CHtml::tag('input',array('type'=>'text', 'value'=>$codeName,'size'=>60,'maxlength'=>200, 'id'=>'VodAsset_code_name' , 'name'=>'VodAsset[code_name]'));
			}
		}

		public function actionAddIntoCategory() {
			$listAsset = explode(",", $_POST['assets']);
			$listCategories = explode(",", $_POST['categories']);
			foreach ($listAsset as $assetId) {
				if ($assetId!=NULL) {
					$vodAsset = VodAsset::model()->findByPk($assetId);
					if ($vodAsset!=NULL) {
						foreach ($listCategories as $categoryId) {
							if ($categoryId!=NULL) {
								if (VodCategoryAssetMapping::model()->find('vod_asset_id=:vod_asset_id AND vod_category_id=:vod_category_id',array(':vod_asset_id'=>$assetId,':vod_category_id'=>$categoryId))==null) {
									$vodCategoryAssetMapping = new VodCategoryAssetMapping;
									$vodCategoryAssetMapping->vod_asset_id = $assetId;
									$vodCategoryAssetMapping->vod_category_id = $categoryId;
									$vodCategoryAssetMapping->create_date = new CDbExpression('NOW()');
									$vodCategoryAssetMapping->save();
								}
							}
						}
					}
				}
			}
		}
		public function actionUpdateCategoryInfo() {

			$id = $_POST['id'];
			$model=VodAsset::model()->findByPk($id);
			if($model!=null) {
				//                $model->modify_date = new CDbExpression('NOW()');
				VodCategoryAssetMapping::model()->deleteAllByAttributes(array('vod_asset_id'=>$id));
				$listCat = explode(",", $_POST['categories']);

				foreach ($listCat AS $category) {
					if ($category!=NULL) {
						$categoryAssetMapping = new VodCategoryAssetMapping;
						$categoryAssetMapping->vod_asset_id = $model->id;
						$categoryAssetMapping->vod_category_id = $category;
						$categoryAssetMapping->create_date = new CDbExpression('NOW()');
						$categoryAssetMapping->save();
					}
				}
				$model->update();
			}
		}

		public function getProtocolType($url) {
			$protocol = 4; //mms
			if(strpos($url,'Manifest') !== false) {
				$protocol = 4; //hls
			}
			elseif(strpos($url,'playlist.m3u8') !== false) {
				$protocol = 2; //hls
			}
			else if(strpos($url,'http') === 0) {
				$protocol = 0; //http
			}
			else if(strpos($url,'rtsp') === 0) {
				$protocol = 1; //rtsp
			}
			else if(strpos($url,'rtmp') === 0) {
				$protocol = 3; //rtmp
			}
			return $protocol;
		}

		public function actionAddStream() {
			if(isset($_POST['streamQuality'])){
				if($_POST['streamQuality'] == 1){
					$vodStream_low = new VodStream;
					$vodStream_low->stream_url = $_POST['url']."_low.mp4";
					$vodStream_low->vod_asset_id = $_GET['vod_asset_id'];
					$vodStream_low->stream_type = $_POST['streamType'];
					
					$vodStream_normal = new VodStream;
					$vodStream_normal->stream_url = $_POST['url']."_normal.mp4";
					$vodStream_normal->vod_asset_id = $_GET['vod_asset_id'];
					$vodStream_normal->stream_type = $_POST['streamType'];
					
					if ($vodStream_low->save() && $vodStream_normal->save()) {
						echo 'success';
					}
					else {
						print_r ($vodStream_low->getErrors());
					}
				}
				else {
					$vodStream_hd = new VodStream;
					$vodStream_hd->stream_url = $_POST['url']."_hd.mp4";
					$vodStream_hd->vod_asset_id = $_GET['vod_asset_id'];
					$vodStream_hd->stream_type = $_POST['streamType'];
					
					if ($vodStream_hd->save()) {
						echo 'success';
					}
					else {
						print_r ($vodStream_hd->getErrors());
					}
				}
			} else {
				
			}
			
		}

		public function actionUpdateStream() {
			$vodStream = VodStream::model()->findByPk($_POST['id']);

			if (isset ($_POST['url'])) {
				$vodStream->stream_url = $_POST['url'];
			}
			
			if (isset ($_POST['status'])) {
				$vodStream->status = 1 - $vodStream->status; //(!$vodStream->status);
			}
			
			if (isset ($_POST['streamType'])) {
				$vodStream->stream_type = (!$vodStream->stream_type);
			}
			
// 			if (!isset ($_POST['url'])&&!isset ($_POST['width'])&&!isset ($_POST['height'])&&!isset ($_POST['bitrate'])) {
// 			}
			
			$vodStream->protocol = $this->getProtocolType($vodStream->stream_url);

			if(!$vodStream->update()) {
			}
			
			if (isset ($_POST['status'])) {
				echo $vodStream->status;
			} else if(isset ($_POST['streamType'])) echo $vodStream->stream_type;
		}

		public function actionDeleteStream() {
			$listStream = explode(",", $_POST['id']);
// 			$vodAsset = VodAsset::model()->findByPk($_GET['vod_asset_id']);
			foreach ($listStream as $stream) {
				$vodStream = VodStream::model ()->findByPk ($stream);
// 				if ($vodStream->stream_type == 1) $vodAsset->vod_stream_count--;
				$vodStream->delete();
			}
		}

		public function actionGetListAsset()
		{
			$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
			$sord = $_GET['sord']; // get the direction asc or desc
			if($sidx == "keyword") $sidx = "code_name";
			$db_order = "$sidx $sord";
			//                $order = isset($_REQUEST['order'])?$_REQUEST['order']:"";
			$cat_id = isset($_REQUEST['category'])?$_REQUEST['category']:null;
			$categories = isset($_REQUEST['categories'])?$_REQUEST['categories']:null;
			$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;

			$page_size = isset($_REQUEST['rows'])?$_REQUEST['rows']:10;
			$image_width = isset($_REQUEST['image_width'])?$_REQUEST['image_width']:null;
			$keyword = isset($_REQUEST['keyword'])?$_REQUEST['keyword']:"";
			$actors = isset($_REQUEST['actors'])?$_REQUEST['actors']:"";
			$director = isset($_REQUEST['director'])?$_REQUEST['director']:"";
			$original_title = isset($_REQUEST['original_title'])?$_REQUEST['original_title']:"";
			$id = isset($_REQUEST['id'])?$_REQUEST['id']:-1;
			$status = isset($_REQUEST['status'])?$_REQUEST['status']:-1;
			$content_provider_id = isset($_REQUEST['content_provider_id'])?$_REQUEST['content_provider_id']:0;

			if ($cat_id!=null && VodCategory::model()->findByPk($cat_id) == null) {
				$this->responseError(1,"ERROR_","VOD Category #$cat_id does note exist!");
			}

			if($categories == null) {
				$res = VodAsset::findVODs($cat_id, $db_order, $page-1, $page_size, $keyword,$actors, $director,$original_title, $id, $status,$content_provider_id); // tu giao dien goi sang day page duoc tinh tu 1 nen phai -1
			}
			else {
				$arrCat = explode(',', $categories);
				$res = VodAsset::findVOD1s($arrCat, $db_order, $page-1, $page_size, $keyword,$actors, $director,$original_title, $id, $status,$content_provider_id);
			}
			if ($page > $res['total_page']) $page = $res['total_page'];
			$responce = new MObject();
			$responce->page = $page;
			$responce->total = $res['total_page'];
			$responce->records = $res['total_result'];

			$i=0;
			$name_cate = '';
			foreach ($res['data'] as $item) {
				$kaka = VodAsset::getVODCategories($item['id']);
				foreach ($kaka as $key_cate => $value_cate) {
					$name_cate .= $value_cate->display_name . " - ";
				}
				$user = AppUser::model()->findByPk($item['modify_user_id']);
				$provider = ContentProvider::model()->findByPk($item['content_provider_id']);
				$item['display_name'] = '<a href="'.Yii::app()->createUrl("vodAsset/view",array("id"=>$item['id'])).'">'.$item['display_name'].'</a>';
				$activeImage = CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'activeImage','id'=>'active_'.$item['id'],'onclick'=>'js: changeActive('.$item['id'].');'));
				$inactiveImage = CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'inactiveImage','id'=>'active_'.$item['id'],'onclick'=>'js: changeActive('.$item['id'].');'));
				$responce->rows[$i]['id']=$item['id'];
				$responce->rows[$i]['cell']=array($item['id'],$item['display_name'],$item['create_date'],$item['view_count'],($item['status']) == 2? $inactiveImage:$activeImage,$item['actors'],$item['director'],$item['original_title'],$user['username'],$item['modify_date'],$name_cate,$provider['display_name'],'');
				$i++;
				$name_cate = '';
			}

			echo json_encode($responce);
		}

		public function actionChangeActive() {
			$vodAsset = VodAsset::model()->findByPk($_POST['id']);
			$vodAsset->status = ($vodAsset->status == 1)?2:1;
			if ($vodAsset->update()) {
				echo $vodAsset->status;
			}
		}

		public function actionchangeMultiveActive() {
			$array_id = isset($_REQUEST['array_id'])?$_REQUEST['array_id']:"";
			$data_id = explode(",",$array_id);

			foreach ($data_id as $value) {
				$vodAsset = VodAsset::model()->findByPk($value);
				$vodAsset->status = 1;
				if ($vodAsset->update()) {
					echo $vodAsset->status;
				}
			}
		}


		public function actionchangeMultiveInactive() {
			$array_id = isset($_REQUEST['array_id'])?$_REQUEST['array_id']:"";
			$data_id = explode(",",$array_id);

			foreach ($data_id as $value) {
				$vodAsset = VodAsset::model()->findByPk($value);
				$vodAsset->status = 2;
				if ($vodAsset->update()) {
					echo $vodAsset->status;
				}
			}
		}

		/**
		 * return data for jqgrid (vodAsset/_lisStream)
		 */
		public function actionGetListStream()
		{
			$items = VodStream::model()->findAllByAttributes(array('vod_asset_id'=>$_GET['id']), array('order'=>'protocol DESC'));

			$responce = new MObject();
			$responce->records = count($items);
			$i=0;
			foreach ($items AS $item) {
				$activeImage = CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'activeImage','id'=>'active_'.$item->id,'onclick'=>'js: changeStreamActive('.$item->id.');'));
				$inactiveImage = CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'inactiveImage','id'=>'active_'.$item->id,'onclick'=>'js: changeStreamActive('.$item->id.');'));
				$trailerImage = CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'activeImage','id'=>'trailer_'.$item->id,'onclick'=>'js: changeStreamTrailer('.$item->id.');'));
				$notTrailerImage = CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'inactiveImage','id'=>'trailer_'.$item->id,'onclick'=>'js: changeStreamTrailer('.$item->id.');'));
				$responce->rows[$i]['id']=$item->id;
				
				$vodStream = VodStream::model()->findByPk($item->id);
				/* @var $vodStream VodStream */
				$streams = array();
				$streams = array_merge($streams, $vodStream->generateStreams(-1));
				foreach($streams as $stream) {
					$protocol = $this->getProtocolType($stream);
					$show_protocol = ($protocol==1?"rtsp":($protocol==2?"hls":($protocol==3?"rtmp":($protocol==4?"mms":"http"))));
					$responce->rows[$i]['cell']=array($stream,$item->resolution_w,$item->resolution_h,$item->bitrate, ($item->status)? $activeImage:$inactiveImage,'',($item->stream_type==1)? 'video':'trailer','','',$show_protocol);
					$i++;
				}
			}
			//
			echo json_encode($responce);
		}

		public function actionUpdateAttributeValue(){

			if (isset ($_GET['vod_asset_id']) && isset ($_POST['value']) && isset($_POST['id'])) {
				$vodAttributeValue = VodAttributeValue::model()->findByAttributes(array('vod_asset_id'=>$_GET['vod_asset_id'],'vod_attribute_id'=>$_POST['id']));
				if ($vodAttributeValue==null) {
					$vodAttributeValue = new VodAttributeValue;
					$vodAttributeValue->vod_asset_id = $_GET['vod_asset_id'];
					$vodAttributeValue->vod_attribute_id = $_POST['id'];
					$vodAttributeValue->create_date = new CDbExpression('NOW()');
				}
				$vodAttribute = VodAttribute::model()->findByPk($_POST['id']);
				if ($vodAttribute!=null){
					switch ($vodAttribute->data_type) {
						case 'int':
							$vodAttributeValue->value_int = $_POST['value'];
							break;
						case 'datetime':
							$vodAttributeValue->value_datetime = $_POST['value'];
							break;
						case 'double':
							$vodAttributeValue->value_double = $_POST['value'];
							break;
						case 'varchar':
							$vodAttributeValue->value_varchar = $_POST['value'];
							break;
					}
					$vodAttributeValue->save();
				}

			}
		}
		public function actionViewFeedBack($id) {
			$this->render('viewFeedback',array(
					'model'=>$this->loadModel($id),
			));
		}

		public function actionChangeCommentStatus() {
			$model = VodComment::model()->findByPk($_POST['id']);
			if ($model!=null) {
				$model->status = (!$model->status);
				if ($model->update()) {
					echo $model->status;
				}
			}
		}
		public function actionGetListComment(){

			$dataProvider = new CActiveDataProvider('vodComment', array(
					'criteria'=>array(
							'order'=>'create_date DESC',
					),
					'pagination'=>array(
							'pageSize'=>1,
					),
			));
			return $dataProvider;
		}

		public function actionGetListImages() {
			$vodImages = VodImage::model()->findAllByAttributes(array('vod_asset_id'=>$_GET['id']));
			foreach ($vodImages as $vodImage){

				if ($vodImage->width!=Null) $width = $vodImage->width; else $width = 'NA ';
				if ($vodImage->height!=Null) $height = $vodImage->height; else $height = ' NA';
				$image = '<li>'.'<a href="'.$vodImage->url.'" id="'.$vodImage->id.'" width="'.$vodImage->width.'" height="'.$vodImage->height.
				'"file_size="'.$vodImage->file_size.'" format="'.$vodImage->format.'" status="'.$vodImage->status.
				'" image_type="'.$vodImage->image_type.'" title="'.$vodImage->title.'">';
				$image .= '<img title="'.$vodImage->title.' ['.$width.'x'.$height.'] - '.$vodImage->create_date. '" src="'.$vodImage->url.'" style="width:40px"></a><li>';
				echo $image;
			}
		}

		public function actionSaveImage(){
			$vodAssetId = $_GET['vod_asset_id'];
			$vodImageId = $_POST['id'];
			$vodImage = NULL;
			if ($vodImageId==null) {
				$vodImage = new VodImage;
				$vodImage->vod_asset_id = $vodAssetId;
			} else $vodImage = VodImage::model ()->findByPk ($vodImageId);
			if ($vodImage!=NULL) {
				$vodImage->url = $_POST['url'];
				$vodImage->title = $_POST['title'];
				$vodImage->width = $_POST['width'];
				$vodImage->height = $_POST['height'];
				//                $vodImage->file_size = $_POST['file_size'];
				$vodImage->format = $_POST['format'];
				$vodImage->status = $_POST['status'];
				//                $vodImage->image_type = $_POST['image_type'];
				$vodImage->create_date = new CDbExpression('NOW()');
				if ($vodImage->save())
				if ($vodImageId==null) {
					$vodAsset = VodAsset::model()->findByPk($vodAssetId);
					$vodAsset->image_count +=1;
					$vodAsset->update();
				}
			}
		}

		public function actionDeleteImage(){
			VodImage::model()->deleteByPk($_POST['id']);

		}

		public function actionUploadImage(){

			//            $path = YiiBase::getPathOfAlias('webroot').'/images/poster'.$_GET['qqfile'];
			$path = '/var/www/html/vfilmbackend/backend/www/files/'.$_GET['qqfile'];
			//            $path = '/var/www/tvplusApi/tvplus/images/poster'.$_GET['qqfile'];
			$input = fopen("php://input", "r");
			$temp = tmpfile();
			$realSize = stream_copy_to_stream($input, $temp);
			fclose($input);

			if ($realSize != (int)$_SERVER["CONTENT_LENGTH"]){
				return false;
			}

			$target = fopen($path, "w");
			fseek($temp, 0, SEEK_SET);
			stream_copy_to_stream($temp, $target);
			fclose($target);
			$vodImage = new VodImage;
			$vodImage->vod_asset_id = $_GET['vod_asset_id'];
			//            $vodImage->url = Yii::app()->request->baseUrl.'/images/'.$_GET['qqfile'];
			$vodImage->url = 'http://backend.vfilm.vn/files/'.$_GET['qqfile'];
			$vodImage->create_date = new CDbExpression('NOW()');
			$vodImage->save();
			echo json_encode(array('success'=>true));
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
		
		public function actionUpdateBasicInfo() {
			$id = $_POST['id'];
			$model=VodAsset::model()->findByPk($id);
			if($model!=null) {
				$model->is_free = ($_POST['isFree']=="true");
				$model->is_series = ($_POST['is_series']=="true")?1:0;
				$model->status = ($_POST['status']=="true")?1:2;
				if (!$model->is_free) {
					$model->price = $_POST['price'];
				}
				$model->modify_date = new CDbExpression('NOW()');
				if ($model->update()) {
					$this->renderPartial('_basic_info',array('model'=>$model));
// 					$this->actionView($model->id);
				}
			}
		}
    public function actionChangeStatus($id, $vodId){

        $model = VodEpisode::model()->findByPk($id);
        if($model != null){
            $model->status = $model->status ? 0 : 1;
            $model->save();
        }
        $this->redirect(array('view','id'=>$vodId));
    }
		
	public function actionViewContent(){
		$model=new VodAsset('search');
		$startDate = '';
		$endDate = '';
		$type = true;
		if(isset($_GET["startDate"])){
			$startDate = CUtils::getStartDate($_GET["startDate"]);
		}
		if(isset($_GET["endDate"])){
			$endDate = CUtils::getEndDate($_GET["endDate"]);
		}
		$type = $_GET["upload"];
		if($type){
			echo "select * from vod_asset where create_date between '$startDate' AND '$endDate' ";
			$model = VodAsset::model()->findAllBySql("select * from vod_asset where create_date between '$startDate' AND '$endDate' ");
		} else {
			echo "select * from vod_asset where approve_date between '$startDate' AND '$endDate' ";
			$model = VodAsset::model()->findAllBySql("select * from vod_asset where approve_date between '$startDate' AND '$endDate' ");
		}
		$this->render('content',array(
				'model'=>$model,
		));
	}
}
