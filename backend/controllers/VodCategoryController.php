<?php

class VodCategoryController extends RController
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
// 				'accessControl', // perform access control for CRUD operations
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
						'actions'=>array('create','update','moveup','movedown','moveback','moveforward','getcodename','updateDisplayName',
								'getListCategories','changeStatus','updateDescription','updateTags','updateBasicInfo','updateParent'),
								//				'users'=>array('@'),
						'users'=>array('admin'),
				),
				array('allow', // allow admin user to perform 'admin' and 'delete' actions
						'actions'=>array('admin','delete','removeAssets'),
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
		$model=new VodCategory;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['VodCategory']))
		{
			$model->attributes=$_POST['VodCategory'];
			//$model->create_date=date('Y-m-d H:i:s');
			$model->create_date = new CDbExpression('NOW()');
			$model->child_count=0;
			$model->code_name = CVietnameseTools::makeCodeName($model->display_name).time();
			if($model->save()) {
				if ($model->parent_id!=NULL) {
					$parent_model = $model->parent;
					$parent_model->child_count += 1;
					$parent_model->update();
					$model->order_number = $parent_model->child_count;
					$model->path = $parent_model->path."/".$model->id;
					$model->level = $parent_model->level + 1;
				} else {
					$model->path = $model->id;
					$model->level = 0;
					$model->order_number = VodCategory::model()->countByAttributes(array("level"=>0)) + 1;
				}
				//                            $listPackage = explode(", ", $_POST['VodCategory']['packages']);
				//
				//                            foreach ($listPackage AS $package) if ($package!=NULL) {
				//                            $vodPackageDetail = new VodPackageDetail;
				//                            $vodPackageDetail->vod_category_id = $model->id;
				//                            $vodPackageDetail->vod_package_id = $package;
				//                            //$vodPackageDetail->create_date=date('Y-m-d H:i:s');
				//                            $vodPackageDetail->create_date = new CDbExpression('NOW()');
				//                            $vodPackageDetail->save();
				//                            }

				$model->update();
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

			if(isset($_POST['VodCategory']))
			{
				$model->attributes=$_POST['VodCategory'];
				$model->display_name_ascii = CVietnameseTools::makeSearchableStr($model->display_name);
				$model->description_ascii = CVietnameseTools::makeSearchableStr($model->description);
				//$model->modify_date=date('Y-m-d H:i:s');
				//                        $model->modify_date = new CDbExpression('NOW()');
				$oldParent = $model->parent;
				if ($oldParent!=NULL) {
					$oldParent->child_count -= 1;
				}
				if($model->update()) {
					if ($model->parent_id!=NULL) {
						$criteria = new CDbCriteria;
						if ($oldParent!=NULL) {
							$criteria->condition='order_number>:order_number AND parent_id=:parent_id';
							$criteria->params=array(':order_number'=>$model->order_number, ':parent_id'=>$oldParent->id);

						} else {
							$criteria->condition='order_number>:order_number AND parent_id IS NULL';
							$criteria->params=array(':order_number'=>$model->order_number);
						}
						$models = VodCategory::model()->findAll($criteria);
						foreach ($models as $model3) {
							$model3->order_number -= 1;
							$model3->update();
						}
						$oldParent->update();
						$parent_model = VodCategory::model()->findbyPk($model->parent_id);
						$parent_model->child_count += 1;
						$parent_model->update();
						$model->order_number = $parent_model->child_count;
						$model->path = $parent_model->path."/".$model->id;
						$model->level = $parent_model->level + 1;
					} else {
						$model->path = $model->id;
						$model->level = 0;
						$model->order_number = VodCategory::model()->countByAttributes(array("level"=>0)) + 1;
					}

					//                            VodPackageDetail::model()->deleteAllByAttributes(array('vod_category_id'=>$model->id));
					//                            $listPackage = explode(", ", $_POST['VodCategory']['packages']);
					//
					//                            foreach ($listPackage AS $package) if ($package!=NULL) {
					//                            $vodPackageDetail = new VodPackageDetail;
					//                            $vodPackageDetail->vod_category_id = $model->id;
					//                            $vodPackageDetail->vod_package_id = $package;
					//                            //$vodPackageDetail->create_date=date('Y-m-d H:i:s');
					//                            $vodPackageDetail->create_date = new CDbExpression('NOW()');
					//                            $vodPackageDetail->save();
					//                            }
					$model->update();
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
			public function actionDelete()
			{
				$vodCategory = VodCategory::model()->findByPk($_POST['id']);
				$vodCategory->status = 2;
				$vodCategory->update();
				$criteria = new CDbCriteria;
				if ($vodCategory->parent_id==NULL) {
					$criteria->condition='order_number>:order_number AND parent_id IS NULL';
					$criteria->params=array(':order_number'=>$vodCategory->order_number);
				} else {
					$parent = VodCategory::model()->findByPk($vodCategory->parent_id);
					if ($parent!=NULL) {
						$parent->child_count -=1;
						$parent->update();
					}
					$criteria->condition='order_number>:order_number AND parent_id=:parent_id';

					$criteria->params=array(':order_number'=>$vodCategory->order_number, ':parent_id'=>$vodCategory->parent_id);
				}
				$models = VodCategory::model()->findAll($criteria);
				foreach ($models as $model) {
					$model->order_number -=1;
					$model->update();
				}
			}

			/**
			 * Lists all models.
			 */
			public function actionIndex()
			{
				$dataProvider=new CActiveDataProvider('VodCategory');
				$model = VodCategory::model()->findAllByAttributes(array("level"=>0));
				$items = array();
				foreach ($model as $model2) {
					$model2->path_name = $model2->display_name;
					$items = array_merge($items,$model2->getListed());
				}
				$dataProvider->setData($items);

				$this->render('index',array(
						'dataProvider'=>$dataProvider,
				));
			}

			/**
			 * Manages all models.
			 */
			public function actionAdmin()
			{

				$model=new VodCategory('search');
				$model->unsetAttributes();  // clear any default values
				if(isset($_GET['VodCategory']))
					$model->attributes=$_GET['VodCategory'];

				$this->render('admin',array(
						'model'=>$model,
				));
				 
			}

			/**
			 * Returns the data model based on the primary key given in the GET variable.
			 * If the data model is not found, an HTTP exception will be raised.
			 * @param integer the ID of the model to be loaded
			 * @return VodCategory
			 */
			public function loadModel($id)
			{
				$model=VodCategory::model()->findByPk($id);
				$parent_model = $model;
				$model->path_name = $model->display_name;
				while ($parent_model->parent_id!=NULL) {
					$parent_model = $parent_model->parent;
					$model->path_name = $parent_model->display_name."/".$model->path_name;
				}
				$listPackage='';
				 
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
				if(isset($_POST['ajax']) && $_POST['ajax']==='vod-category-form')
				{
					echo CActiveForm::validate($model);
					Yii::app()->end();
				}
			}

			public function actionMoveup() {
				$id = $_GET['id'];
				$model = VodCategory::model()->findByPk($id);
				//            if($model == NULL) {
				//                $this->responseError(1,1,"category id ".$id." is NULL");
				//            }
				//            else {
				//                $this->responseError(0,0,"category id ".$id." is not NULL");
				//            }
					$newOrder = $model->order_number - 1;
					if($model->parent_id == NULL) {
						$model2 = VodCategory::model()->findByAttributes(array("order_number"=>$newOrder,"parent_id"=>NULL));

					}
					else {
						$model2 = VodCategory::model()->findByAttributes(array("order_number"=>$newOrder,"parent_id"=>$model->parent_id));
					}

					//            if($model2 == NULL) {
					//                $this->responseError(1,1,"category order ".$newOrder." is NULL");
					//            }
					//            else {
					//                $this->responseError(0,0,"category order ".$newOrder." is not NULL");
					//            }
					//            $criteria = new CDbCriteria;
					//             if ($model->parent_id==NULL) {
					//               $criteria->condition='order_number=:order_number AND parent_id IS NULL';
					//               $criteria->params=array(':order_number'=>$model->order_number-1);
					//            } else {
					//                $criteria->condition='order_number=:order_number AND parent_id=:parent_id';
					//                $criteria->params=array(':order_number'=>$model->order_number-1, ':parent_id'=>$model->parent_id);
					//            }
					//            $model2 = VodCategory::model()->find($criteria);
					if ($model2!=NULL) {
						$model->order_number--;
						$model2->order_number++;
						if(!$model->update()) {
							//                    $this->responseError(1,1,"cannot save category id ".$id);
						}
						if(!$model2->update()) {
							//                    $this->responseError(1,1,"cannot save category id ".$model2->id);
						}
						//                $this->responseError(1,1,"successfully");
					}


			}

			public function actionMovedown() {
				$id = $_GET['id'];
				/* @var $model VodCategory */
				$model = VodCategory::model()->findByPk($id);
				//            $nextOrderNumber = $model->order_number + 1;
				//            $arrCats = array();
				//            if ($model->parent_id!=NULL) {
				//                $arrCats = VodCategory::model()->findByAttributes(array('parent_id'=>$model->parent_id, 'order_number'=>$nextOrderNumber));
				//            }
				//            else {
				//                $arrCats = VodCategory::model()->findByAttributes(array('parent_id'=>NULL, 'order_number'=>$nextOrderNumber));
				//            }
				//            $model2 = $arrCats[0];
				//
				$criteria = new CDbCriteria;
				if ($model->parent_id==NULL) {
					$criteria->condition='order_number=:order_number AND parent_id IS NULL';
					$criteria->params=array(':order_number'=>$model->order_number+1);
				} else {
					$criteria->condition='order_number=:order_number AND parent_id=:parent_id';

					$criteria->params=array(':order_number'=>$model->order_number+1, ':parent_id'=>$model->parent_id);
				}
				$model2 = VodCategory::model()->find($criteria);
				if ($model2!=NULL) {
					$model->order_number +=1;
					$model2->order_number -=1;
					$model->update();
					$model2->update();
				}

			}

			public function actionMoveforward() {
				$id = $_GET['id'];
				$model = VodCategory::model()->findByPk($id);
				$criteria = new CDbCriteria;
				if ($model->parent_id!=NULL) {
					$criteria->condition='order_number=:order_number AND parent_id=:parent_id';

					$criteria->params=array(':order_number'=>$model->order_number-1, ':parent_id'=>$model->parent_id);
				} else {
					$criteria->condition='order_number=:order_number AND parent_id IS NULL';

					$criteria->params=array(':order_number'=>$model->order_number-1);
				}
				$model2 = VodCategory::model()->find($criteria);
				if ($model2!=NULL) {
					$model->parent_id=$model2->id;
					$model->path = $model2->path.'/'.$model->id;
					$model->level += 1;
					$model->order_number =  $model2->child_count + 1;
					$model->update();
					$model2->child_count +=1;
					$model2->update();
					$parentModel = $model2->parent;
					if ($parentModel!=Null) {
						$parentModel->child_count -=1;
						$parentModel->update();
					}
					if ($model2->parent_id!=NULL) {
						$criteria->condition='order_number>:order_number AND parent_id=:parent_id';

						$criteria->params=array(':order_number'=>$model2->order_number, ':parent_id'=>$model2->parent_id);
					} else {
						$criteria->condition='order_number>:order_number AND parent_id IS NULL';

						$criteria->params=array(':order_number'=>$model2->order_number);
					}

					$models = VodCategory::model()->findAll($criteria);
					foreach ($models as $model3) {
						$model3->order_number -= 1;
						$model3->update();
					}

					$items = $model->getListed();
					foreach ($items as $item) if($item->id!=$id) {
						$item->path = $item->parent->path.'/'.$item->id;
						$item->level += 1;
						$item->update();
					}
					 
				}



			}

			public function actionMoveback() {
				$id = $_GET['id'];
				$model = VodCategory::model()->findByPk($id);
				$criteria = new CDbCriteria;
				if ($model->parent_id!=NULL) {
					$model2 = $model->parent;
					$model->level -= 1;
					 
					$criteria->condition='order_number>:order_number AND parent_id=:parent_id';
					$criteria->params=array(':order_number'=>$model->order_number, ':parent_id'=>$model->parent_id);
					$models = VodCategory::model()->findAll($criteria);
					foreach ($models as $model3) {
						$model3->order_number -=1;
						$model3->update();
					}
					 
					$model->order_number = $model2->order_number + 1;
					$model2->child_count -=1;
					$model2->update();
					if ($model2->parent!=NULL) {
						$model->parent_id = $model2->parent->id;
						$model->path = $model2->parent->path.'/'.$id;
						$parentModel = $model2->parent;
						$parentModel->child_count +=1;
						$parentModel->update();
						$criteria->condition='order_number>:order_number AND parent_id=:parent_id';
						$criteria->params=array(':order_number'=>$model2->order_number, ':parent_id'=>$model2->parent_id);
					} else {
						$model->parent_id = NULL;
						$model->path = $id;
						 
						$criteria->condition='order_number>:order_number AND parent_id IS NULL';
						$criteria->params=array(':order_number'=>$model2->order_number);
						 
					}
					 


					$models = VodCategory::model()->findAll($criteria);
					foreach ($models as $model3) {
						$model3->order_number +=1;
						$model3->update();
					}
					 
					 
					 
					$model->update();
					$items = $model->getListed();
					foreach ($items as $item) if($item->id!=$id) {
						$item->path = $item->parent->path.'/'.$item->id;
						$item->level -= 1;
						$item->update();
					}
				}
				 

				//            $models = VodCategory::model()->findAllByAttributes(array("level"=>"0"),array("order"=>"order_number ASC"));
				//                $items = array();
				//                      foreach ($models as $model2) {
				//                          $model2->path_name = $model2->display_name;
				//                          $items = array_merge($items,$model2->getListed());
				//                      }
				//                         while ($modelSelect = current($items)) {
				//                            if ($modelSelect->id == $id) {
				//                               $page = floor(key($items)/3) + 1;
				//                               echo $page;
				//
				//
				//                               break;
				//                            }
				//                            next($items);
				//                        }

			}

			public function actionGetcodename() {
				if ($_GET['new']) {
					$displayName = $_POST['VodCategory']['display_name'];
					$codeName = CVietnameseTools::makeCodeName($displayName);
					echo CHtml::tag('input',array('type'=>'text', 'value'=>$codeName,'size'=>60,'maxlength'=>200, 'id'=>'VodCategory_code_name', 'name'=>'VodCategory[code_name]'));
				}
			}

			public function actionRemoveAssets() {
				$listAssets = explode(",", $_POST['ids']);
				foreach ($listAssets as $assetId)
				{
					$vodCategory = VodCategory::model()->findByPk($_POST['id']);
					$items = $vodCategory->getListed();
					foreach ($items as $item) {
						VodCategoryAssetMapping::model()->deleteAllByAttributes(array('vod_asset_id'=>$assetId,'vod_category_id'=>$item->id));
					}
				}

			}

			public function actionGetListCategories() {
				$models = VodCategory::model()->findAllByAttributes(array("level"=>"0"),array("order"=>"order_number ASC"));
				$items = array();

				foreach ($models as $model2) {
					$model2->path_name = $model2->display_name;
					$subItems = array();
					//              $items = array_merge($items,$model2->getListed());  // lay categories o level 0 & 1
					$subItems = array_merge($subItems,$model2->getListSub()); // lay categories o level 0 & 1
					$n = count($subItems);
					//              $this->responseError(1,1, "count = ".$n." subItems[0] = ".$subItems[0]->order_number);
					for($j = 0; $j < $n-2;$j++) {
						for($i=$n-1; $i > $j; $i--) {
							//                  if($subItems[$i]['order_number'] > $subItems[$i+1]['order_number']) {
							if($subItems[$i]->order_number < $subItems[$i-1]->order_number) {
								//                      $this->responseError(1,1, "count = ".$n." subItems[0] = ".$subItems[0]->order_number);
								$tmpItem = $subItems[$i];
								$subItems[$i] = $subItems[$i-1];
								$subItems[$i-1] = $tmpItem;
							}
						}
					}
					$itemRoot = array($model2);
					$subItems = array_merge($itemRoot, $subItems);
					$items = array_merge($items, $subItems);
				}

				$responce = array();

				$i=0;

				foreach ($items as $item) {
					if ($item->parent!=Null) $childCount = $item->parent->child_count; else $childCount = count(VodCategory::model()->findAllByAttributes(array('level'=>0)));
					$activeImage = CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'activeImage','id'=>'active_'.$item->id,'onclick'=>'js: changeActive('.$item->id.');'));
					$inactiveImage = CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'inactiveImage','id'=>'active_'.$item->id,'onclick'=>'js: changeActive('.$item->id.');'));
					$category = array('id'=>$item->id,'move'=>$item->level,'childCount'=>$childCount,'sort'=>$item->order_number,'category'=>$item->display_name,'level'=>$item->level,'parent'=>$item->parent_id,'isLeaf'=>($item->child_count==0),'expanded'=>true,'loaded'=>true,'status'=>$item->status,'child_count'=>$item->child_count);
					array_push($responce, $category);

				}
				$responce = array('response'=>$responce);
				echo json_encode($responce);
			}


			public function actionChangeStatus(){
				$vodCategory = VodCategory::model()->findByPk($_POST['id']);
				$vodCategory->status = (!$vodCategory->status);
				//            $vodCategory->modify_date = new CDbExpression('NOW()');
				if ($vodCategory->update()) {
					echo $vodCategory->status;

				}
			}

			public function actionUpdateDisplayName() {

				$id = $_POST['id'];
				$model= VodCategory::model()->findByPk($id);
				if($model!=null) {
					$displayName = $_POST['display_name'];
					$model->display_name = $displayName;
					//                    $model->display_name_ascii = CVietnameseTools::makeSearchableStr($displayName);
					//                    $model->modify_date = new CDbExpression('NOW()');
					if ($model->update()) {
						echo $model->display_name;
					}
				}
				 
			}

			public function actionUpdateDescription() {

				$id = $_POST['id'];
				$model=VodCategory::model()->findByPk($id);
				if($model!=null) {
					$description = $_POST['description'];
					$model->description = $description;
					//                    $model->description_ascii = CVietnameseTools::makeSearchableStr($description);
					//                    $model->modify_date = new CDbExpression('NOW()');
					if ($model->update()) {
						echo $model->description;
					}
				}
				 
			}

			public function actionUpdateTags() {

				$id = $_POST['id'];
				$model=VodCategory::model()->findByPk($id);
				if($model!=null) {
					$tags = $_POST['tags'];
					$model->tags = $tags;
					//                    $model->tags_ascii = CVietnameseTools::makeSearchableStr($tags);
					//                    $model->modify_date = new CDbExpression('NOW()');
					if ($model->update()) {
						echo $model->tags;
					}
				}
				 
			}

			public function actionUpdateBasicInfo() {
				$id = $_POST['id'];
				$model=VodCategory::model()->findByPk($id);
				if($model!=null) {
					$model->vod_attribute_set_id = $_POST['vod_attribute_set_id'];
					$model->image_url = $_POST['image_url'];
					$model->status = ($_POST['status']=="true");
					//                    $model->modify_date = new CDbExpression('NOW()');
					if ($model->update()) {
						$this->renderPartial('_basic_info',array('model'=>$model));
					}
				}
				 
			}

			public function actionUpdateParent(){
				$id = $_POST['id'];
				$model=VodCategory::model()->findByPk($id);
				//            $model->modify_date = new CDbExpression('NOW()');
				$model->parent_id = $_POST['parent'];
				$oldParent = $model->parent;
				if ($oldParent!=NULL) {
					$oldParent->child_count -= 1;
				}

				if($model->update()) {
					if ($model->parent_id!=NULL) {
						$criteria = new CDbCriteria;
						if ($oldParent!=NULL) {
							$criteria->condition='order_number>:order_number AND parent_id=:parent_id';
							$criteria->params=array(':order_number'=>$model->order_number, ':parent_id'=>$oldParent->id);

						} else {
							$criteria->condition='order_number>:order_number AND parent_id IS NULL';
							$criteria->params=array(':order_number'=>$model->order_number);
						}
						$models = VodCategory::model()->findAll($criteria);
						foreach ($models as $model3) {
							$model3->order_number -= 1;
							$model3->update();
						}
						$oldParent->update();
						$parent_model = VodCategory::model()->findbyPk($model->parent_id);
						$parent_model->child_count += 1;
						$parent_model->update();
						$model->order_number = $parent_model->child_count;
						$model->path = $parent_model->path."/".$model->id;
						$model->level = $parent_model->level + 1;
					} else {
						$model->path = $model->id;
						$model->level = 0;
						$model->order_number = VodCategory::model()->countByAttributes(array("level"=>0)) + 1;
					}
					$model->update();
					echo $model->getPathName();
				}

			}

			public function responseError($error_no, $error_code, $message) {
				header("Content-type: text/xml; charset=utf-8");
				$xmlDoc = new DOMDocument();
				$xmlDoc->encoding = "UTF-8";
				$xmlDoc->version = "1.0";

				//TODO: authen, session, error handle
				$root = $xmlDoc->appendChild($xmlDoc->createElement("response"));
				$root->appendChild($xmlDoc->createElement("error_no", $error_no));
				$root->appendChild($xmlDoc->createElement("error_code", $error_code));
				$root->appendChild($xmlDoc->createElement("error_message", CHtml::encode($message)));

				echo $xmlDoc->saveXML();
				Yii::app()->end();
			}
}
