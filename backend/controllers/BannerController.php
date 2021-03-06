<?php

class BannerController extends RController
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
                'actions'=>array('create','update',),
                'users'=>array('@'),
            ),
            array('allow', // allow only the owner to perform 'view' 'update' 'delete'                                       actions
                'actions' => array('view', 'update'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
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
//	public function actionCreate()
//	{
//		$model=new Banner;
//
//		// Uncomment the following line if AJAX validation is needed
//		// $this->performAjaxValidation($model);
//
//		if(isset($_POST['Banner']))
//		{
//			$model->attributes=$_POST['Banner'];
//			if($model->save())
//				$this->redirect(array('view','id'=>$model->id));
//		}
//
//		$this->render('create',array(
//			'model'=>$model,
//		));
//	}


    public function actionCreate()
    {
        $model = new Banner('upload');
        $model->type = Banner::banner;
        if(isset($_POST['Banner']))
        {
            $model->attributes=$_POST['Banner'];
            $model->picture = CUploadedFile::getInstance($model, 'picture');
            if ($model->picture !== null  && $model->validate(array('picture')))
            {
                $fileName = str_replace(" ","_",CVietnameseTools::removeSigns2($model->picture->name));
                $model->content = $fileName;
                $path = Yii::getPathOfAlias('www').'/banner/';
                $model->picture->saveAs($path.$fileName);
                $imageSize = $model->getImageSize();
                if(count($imageSize) > 0) {
                    $model->width = $imageSize[0];
                    $model->height = $imageSize[1];
                    if($imageSize[0] > $imageSize[1]) { //neu width > height
                        $model->orientation = Banner::ORIENTATION_LANDSCAPE;
                    }
                    else {
                        $model->orientation = Banner::ORIENTATION_PORTRAIT;
                    }
                }
            }
            if( $model->save()){
                $this->redirect($this->createUrl('banner/admin'));
            }
        }
        $this->render('createBanner', array('model'=>$model));
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

        if(isset($_POST['Banner']))
        {
            $model->attributes=$_POST['Banner'];
            $model->picture = CUploadedFile::getInstance($model, 'picture');
            if ($model->picture !== null)
            {
                $fileName = str_replace(" ","_",CVietnameseTools::removeSigns2($model->picture->name));
                $model->content = $fileName;
                $path = Yii::getPathOfAlias('www').'/banner/';
                $model->picture->saveAs($path.$fileName);
                $imageSize = $model->getImageSize();
                if(count($imageSize) > 0) {
                    $model->width = $imageSize[0];
                    $model->height = $imageSize[1];
                    if($imageSize[0] > $imageSize[1]) { //neu width > height
                        $model->orientation = Banner::ORIENTATION_LANDSCAPE;
                    }
                    else {
                        $model->orientation = Banner::ORIENTATION_PORTRAIT;
                    }
                }
            }
            if($model->save())
                $this->redirect($this->createUrl('banner/admin'));
//				$this->redirect(array('view','id'=>$model->id));
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('Banner');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new Banner('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Banner']))
            $model->attributes=$_GET['Banner'];
        $model = Banner::model()->getListBanner();
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
        $model=Banner::model()->findByPk($id);
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
        if(isset($_POST['ajax']) && $_POST['ajax']==='banner-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

//	public function actionDelete($id)
//	{
//		if(Yii::app()->request->isPostRequest)
//		{
//			// we only allow deletion via POST request
//			$this->loadModel($id)->delete();
//
//			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//			if(!isset($_GET['ajax']))
//				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//		}
//		else
//			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
//	}

    public function actionUpload(){
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) &&
            (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false))
        {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        $data = array();
        $model = new Banner('upload');
        $model->picture = CUploadedFile::getInstance($model, 'picture');
        $model->content = $model->picture;
        if ($model->picture !== null  && $model->validate(array('picture')))
        {
            $model->picture->saveAs(Yii::app()->getBaseUrl(true).'/banner/'.$model->picture->name);
            $imageSize = $model->getImageSize();
            if(count($imageSize) > 0) {
                $model->width = $imageSize[0];
                $model->height = $imageSize[1];
                if($imageSize[0] > $imageSize[1]) { //neu width > height
                    $model->orientation = Banner::ORIENTATION_LANDSCAPE;
                }
                else {
                    $model->orientation = Banner::ORIENTATION_PORTRAIT;
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
                    'delete_url' => $this->createUrl('banner/delete',
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

    /*public function actionChangeActive() {
        echo 'a';die;
        $banner = Banner::model()->findByPk($_POST['id']);
        $banner->status = $banner->status ? 0 : 1;
        if ($banner->update()) {
            echo $banner->status;
        }
    }*/
    public function actionChangeStatus($id)
    {
        $model = Banner::model()->findByPk($id);

        $criteria = new CDbCriteria();
        $criteria->addCondition('id <>'.$id);
        $arrBanner = Banner::model()->findAll($criteria);
        if ($model != null) {
            $model->status = $model->status ? 0 : 1;
            $model->save();
        }
        if ($model != null) {
            foreach($arrBanner as $item){
                $item->status = 0;
                $item->save();
            }
        }
        $this->redirect(Yii::app()->createUrl('banner/admin'));
    }

    public function actionPopup()
    {
        $model=new Banner('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Banner']))
            $model->attributes=$_GET['Banner'];
        $model = Banner::model()->getListBanner();
        $this->render('popup',array(
            'model'=>$model,
        ));
    }
    public function actionCreatePopup()
    {
        $model = new Banner('upload');
        $model->type = Banner::popup;
        if(isset($_POST['Banner']))
        {
            $model->attributes=$_POST['Banner'];
            $model->picture = CUploadedFile::getInstance($model, 'picture');
            if ($model->picture !== null  && $model->validate(array('picture')))
            {
                $fileName = str_replace(" ","_",CVietnameseTools::removeSigns2($model->picture->name));
                $model->content = $fileName;
                $path = Yii::getPathOfAlias('www').'/popup/';
                $model->picture->saveAs($path.$fileName);
                $imageSize = $model->getPopupImageSize();
                if(count($imageSize) > 0) {
                    $model->width = $imageSize[0];
                    $model->height = $imageSize[1];
                    if($imageSize[0] > $imageSize[1]) { //neu width > height
                        $model->orientation = Banner::ORIENTATION_LANDSCAPE;
                    }
                    else {
                        $model->orientation = Banner::ORIENTATION_PORTRAIT;
                    }
                }
            }
            if( $model->save()){
                $this->redirect($this->createUrl('banner/popup'));
            }
        }
        $this->render('createPopup', array('model'=>$model));
    }
}
