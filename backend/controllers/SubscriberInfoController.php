<?php

class SubscriberInfoController extends RController
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
 			'IpLocalOnly + view, index, admin', // perform access control for CRUD operations
//				'rights', // perform access control for CRUD operations
		);
	}
	
	public function filterIpLocalOnly($filterChain) {
		$accept = true;
		$remoteAddr = $_SERVER['REMOTE_ADDR'];
		if(!ClientAuthen::checkLocalAddress($remoteAddr)) {
// 			$this->responseError(1,1, "This api must be called from localhost. Not from $remoteAddr");
			$accept = false;
		}
		$accept = true;//fixme: xoa dong nay sau khi add them ip cua VNP
		if ($accept) {
			$filterChain->run();
		} else {
			throw new CHttpException(401,'Access denied!');
		}
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
 				'actions'=>array('create','update','sendSMS'),
 				'users'=>array('admin'),
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
	public function actionView($msisdn)
	{
		$msisdn = CUtils::validatorMobile($msisdn);
		$subscriber = Subscriber::model()->findByAttributes(array('subscriber_number' => $msisdn));
		if($subscriber == NULL) {
			echo "Thuê bao $msisdn không tồn tại!";
			exit;
		}
		$this->render('view',array(
			'model'=>$this->loadModel($subscriber->id),
		));
	}
/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Subscriber');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Subscriber('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Subscriber']))
			$model->attributes=$_GET['Subscriber'];

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
		$model=Subscriber::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='subscriber-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
