<?php

class SubscriberController extends RController
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
// 			'accessControl', // perform access control for CRUD operations
				'rights', // perform access control for CRUD operations
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
		$model=new Subscriber;
		
		$strStatus = "";

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Subscriber']))
		{
			try {
				$model->attributes=$_POST['Subscriber'];
				$msisdn = $model->subscriber_number;
				$msisdn = CUtils::validatorMobile($msisdn);
				if(empty($msisdn)) {
					$strStatus = "Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại của VinaPhone.";
					throw new Exception($strStatus);
				}
				$tmp = Subscriber::model()->findByAttributes(array('subscriber_number'=>$msisdn));
				/* @var $tmp Subscriber */
				if($tmp != NULL) {
					if($tmp->status == Subscriber::STATUS_WHITE_LIST) {
						$strStatus = "Thuê bao này đã tồn tại và đã được đưa vào danh sách thuê bao miễn phí để test dịch vụ rồi.";
						throw new Exception($strStatus);
					}
					else {
						/* @var $tmp Subscriber */
						$tmp->status = Subscriber::STATUS_WHITE_LIST;
						$tmp->auto_recurring = 0;
						$tmp->update();
						$strStatus = "Cập nhật trạng thái của thuê bao $msisdn thành thuê bao miễn phí thành công.";
						throw new Exception($strStatus);
					}
				}
				else {
					$model->user_name = $msisdn;
					$model->status = Subscriber::STATUS_WHITE_LIST;
					$model->auto_recurring = 0;
					$model->create_date = new CDbExpression('NOW()');
				}
				if(!$model->save()) {
					$strStatus = "Bị lỗi trong quá trình tạo thuê bao miễn phí. Vui lòng thử lại sau";
					throw new Exception($strStatus);
				}
				else {
					$strStatus = "Đã tạo thuê bao miễn phí mới thành công";
					$this->redirect(array('subscriber/adminWhiteList',));
				}
			}
			catch(Exception $e) {
				$model->error_message = $e->getMessage();
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

		if(isset($_POST['Subscriber']))
		{
			$model->attributes=$_POST['Subscriber'];
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

	private function getArrSubWhiteList() {
		$criteriaSub = new CDbCriteria;
		$criteriaSub = array(
				'condition'=>'status='.Subscriber::STATUS_WHITE_LIST,
				'order'=>'id desc',
		);
		$modelSub = new CActiveDataProvider(Subscriber::model(), array(
				'criteria'=>$criteriaSub,
		));
		return $modelSub;
	}
	
	/**
	 * Manages all models.
	 */
	public function actionAdminWhiteList()
	{
		$modelSub = $this->getArrSubWhiteList();
		$this->render('adminWhiteList',array(
			'model'=>$modelSub,
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
	
// 	public function actionGetTransactions($id) {
// 		$criteria=new CDbCriteria;
// 		$criteria->compare('subscriber_id',$id);
			
// 		$model = new CActiveDataProvider($this, array(
// 				'criteria'=>$criteria,
// 		));
		
// 		$model=new SubscriberTransaction('search');
// 		$model->unsetAttributes();  // clear any default values
// 		if(isset($_GET['SubscriberTransaction'])) {
// 			$model->attributes=$_GET['SubscriberTransaction'];
// 		}
		
// 		$this->render('listTransaction',array(
// 				'model'=>$model,
// 		));
// 	}

	public function actionChangeStatus($status, $id) {
		$subscriber = Subscriber::model()->findByPk($id);
		$subscriber->status = $status;
		$subscriber->update();
		$this->render('view',array(
			'model'=>$subscriber,
		));
	}
	
	//gui tin nhan
	public function actionSendSMS(){
			$id = isset($_POST['Subscriber']['id'])?$_POST['Subscriber']['id']:'';
        	$model = Subscriber::model()->findByPk($id);
			$message = isset($_POST['Subscriber']['message'])?$_POST['Subscriber']['message']:'';
			//call api
			VinaphoneController::sendSms($model->subscriber_number, $message);
			$result = true;
			if($result){
				$response = "Gửi tin nhắn thành công.";
			} else $response = "Gửi tin nhắn thất bại.";
			Yii::app()->user->setFlash('response',$response);
			$this->redirect(array('view','id'=>$model->id));
        }

        //admin dang ky dich vu cho thue bao
    public function actionSendRegister(){
        $service_id = isset($_POST['Subscriber']['service_id'])?$_POST['Subscriber']['service_id']:'4';
        $subscriber_id = isset($_POST['Subscriber']['id'])?$_POST['Subscriber']['id']:'4';
        $subscriber = Subscriber::model()->findByPk($subscriber_id);
        /*echo '<pre>';var_dump($subscriber);die;*/
        if($subscriber == NULL) {
            Yii::app()->user->setFlash('response',"Lỗi hệ thống");
            $this->redirect(array('view','id'=>$subscriber->id));
        }

        $apiService = new APIService();
        $user = User::model()->findByPk(Yii::app()->user->id);
        $username = '';
        if($user != NULL) {
            $username = $user->username;
        }else{
            $username = Yii::app()->session['Username'];
        }
        $response = $apiService->registerService($subscriber->subscriber_number, $username, '113.185.0.153', $service_id);
//        $xml=simplexml_load_string($response);
//        $responseToUser = "".$xml->error_desc;
//
//        Yii::app()->user->setFlash('response',$responseToUser);
        $this->redirect(array('view','id'=>$subscriber->id));
    }
	
	//admin huy dich vu cho thue bao
    public function actionSendCancelSerivce(){
        $service_id = isset($_POST['Subscriber']['service_id'])?$_POST['Subscriber']['service_id']:'4';
        $subscriber_id = isset($_POST['Subscriber']['id'])?$_POST['Subscriber']['id']:'4';
        $subscriber = Subscriber::model()->findByPk($subscriber_id);
        if($subscriber == NULL) {
            Yii::app()->user->setFlash('response',"Lỗi hệ thống");
            $this->redirect(array('view','id'=>$subscriber->id));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);
        $username = '';
        if($user != NULL) {
            $username = $user->username;
        }else{
            $username = Yii::app()->session['Username'];
        }
        $apiService = new APIService();
        $response = $apiService->cancelService($subscriber->subscriber_number, $username, '113.185.0.153', $service_id);
//        echo '<pre>';echo "".$response->body;die;
//        $responseToUser = "".$response->error_desc;
//
//        Yii::app()->user->setFlash('response',$responseToUser);
        $this->redirect(array('view','id'=>$subscriber->id));
    }
	
	//dk tu gia han
	public function actionSendAutoRegisterRecur(){
		$id = isset($_POST['Subscriber']['id'])?$_POST['Subscriber']['id']:'';
        $subscriber = Subscriber::model()->findByPk($id);
        if($subscriber == NULL) {
        	Yii::app()->user->setFlash('response',"Lỗi hệ thống");
        	$this->redirect(array('view','id'=>$subscriber->id));
        }
        
        $apiService = new APIService();
        $response = $apiService->registerRecurring($subscriber->subscriber_number);
        $responseToUser = $response->error_message;
        
		Yii::app()->user->setFlash('response',$response->error_message);
		$this->redirect(array('view','id'=>$subscriber->id, 'response' => $response->error_message));
	}
	
	//huy tu gia han
	public function actionSendCancelAutoRegisterRecur(){
		$id = isset($_POST['Subscriber']['id'])?$_POST['Subscriber']['id']:'';
        $subscriber = Subscriber::model()->findByPk($id);
        if($subscriber == NULL) {
        	Yii::app()->user->setFlash('response',"Lỗi hệ thống");
        	$this->redirect(array('view','id'=>$subscriber->id));
        }
        
        $apiService = new APIService();
        $response = $apiService->cancelRecurring($subscriber->subscriber_number);
        $responseToUser = $response->error_message;
        
		Yii::app()->user->setFlash('response',$response->error_message);
		$this->redirect(array('view','id'=>$subscriber->id, 'response' => $response->error_message));
	}
	
	//tang mien phi
	public function actionSendGiftFree(){
		$id = isset($_POST['Subscriber']['id'])?$_POST['Subscriber']['id']:'';
        $model = Subscriber::model()->findByPk($id);
		//call api
		$result = 1;
		if($result){
			$response = "Tặng miễn phi thành công.";
		} else $response = "Tặng miễn phi thất bại.";
		Yii::app()->user->setFlash('response',$response);
		$this->redirect(array('view','id'=>$model->id));
	}
        
}
