<?php

class CskhDichVuVfilmNvController extends RController
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column3';
    public $per_page = 20;
    /**
     * @return array action filters
     */
    public function filters()
    {
//        $url_path = Yii::app()->request->pathInfo;
//        if ($url_path != 'CskhDichVuVfilm' && $url_path != 'CskhDichVuVfilm/login'&& $url_path != 'CskhDichVuVfilm/loginProcess'){
//            if (!isset(Yii::app()->session['Username'])){
//                return $this->redirect($this->createUrl('CskhDichVuVfilm/tracuuthuebao'));
//            }
//        }

        return array(
 			'accessControl', // perform access control for CRUD operations
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

                'actions'=>array('index','tracuuthuebao', 'useService'
                , 'sendRegister', 'sendCancelSerivce', 'cancelnumber'
                ),

                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'sendSMS'),
                'users' => array('admin'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
//            array('deny',  // deny all users
//                'users'=>array('*'),
//            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */

    public function actionIndex(){
    	Yii::log("------------------------------CskhDichVuVfilmNv-------------------------------------");
    	Yii::app()->session['Username'] = 'Admin';
    	Yii::app()->session['Role'] =2;
    	CUtils::setCookie("Username", 'Admin');
    	Yii::log("Set and get session username: ".Yii::app()->session['Username']);
    	Yii::log("Set and get cookie username: ".CUtils::getCookie("Username"));
    	CUtils::setCookie("Role", 2);
    	Yii::log("Set and get session role: ".Yii::app()->session['Role']);
    	Yii::log("Set and get cookie role: ". CUtils::getCookie("Role"));
    	$this->redirect($this->createUrl('CskhDichVuVfilm/Tracuuthuebao'));

    }

	public function actionTracuuthuebao()
    {
        if (!empty($_GET['keyword']) || isset(Yii::app()->session['msisdn'])) {
            if (!empty($_GET['keyword'])){
                $msisdn = $_GET['keyword'];
            }else{
                $msisdn = Yii::app()->session['msisdn'];
                if(isset($msisdn)){
                	$msisdn = CUtils::getCookie("msisdn");
                }
            }
            Yii::app()->session['msisdn'] = $msisdn;
            CUtils::setCookie("msisdn",$msisdn);
            Yii::log("Set and get msisdn session: ".Yii::app()->session['msisdn']);
            Yii::log("Set and get msisdn cookie: ".CUtils::getCookie("msisdn"));
            $model = Subscriber::model()->findByAttributes(array('subscriber_number' => $msisdn));
            if($model != null){
                Yii::app()->session['checkview'] = 1;
                $this->render('tracuuthuebao',array(
                    'model'=>$model,
                ));
            }else{
//                Yii::app()->user->setFlash('response',"Thuê bao không tồn tại!");
                Yii::app()->session['checkview'] = 2;
                $this->render('tracuuthuebao',array(
                ));
            }
        }else{
            $this->render('tracuuthuebao',array(
            ));
        }
    }
    public function actionThongtindichvu()
    {
        /*$dataProvider=new CActiveDataProvider('Subscriber');*/
        $this->render('thongtindichvu',array(
            /*'dataProvider'=>$dataProvider,*/
        ));
    }
    public function actionCaidatdichvu()
    {
        if(Yii::app()->session['Role'] == 1){
            $this->redirect($this->createUrl('CskhDichVuVfilm/tracuuthuebao'));
        }
        $model=new Subscriber('search');
        $model->unsetAttributes();
        $model=new Subscriber('search');
        if (isset($_GET['msisdn'])){
            $msisdn = $_GET['msisdn'];
            Yii::app()->session['msisdn'] = $msisdn;
        }elseif (isset(Yii::app()->session['msisdn'])){
            $msisdn = Yii::app()->session['msisdn'];
        }else{
            $msisdn = null;
        }
        if($msisdn != null){
            Yii::app()->session['checkviewcd'] = $msisdn;
            Yii::app()->session['anlayout2'] = $msisdn;
            $model->subscriber_number = $msisdn;
        }else{
            $model->subscriber_number = 1234567890;
        }
        $this->render('caidatdichvu',array(
            'model'=>$model,
        ));
    }
    //admin dang ky dich vu cho thue bao
    public function actionSendRegister($id){
        $subscriber = Subscriber::model()->findByPk($id);
        /*echo '<pre>';var_dump($subscriber);die;*/
        if($subscriber == NULL) {
            Yii::app()->user->setFlash('response',"Lỗi hệ thống");
            $this->redirect(array('caidatdichvu',
                'keyword'=>$subscriber->subscriber_number
            ));
        }

        $apiService = new APIService();
        $user = User::model()->findByPk(Yii::app()->user->id);
        $username = '';
        if($user != NULL) {
            $username = $user->username;
        }else{
            $username = Yii::app()->session['Username'];
        }
        $response = $apiService->registerService($subscriber->subscriber_number, $username, '113.185.0.153');

        if($response["body"] == 0){
            $responses = 'Đăng ký thành công dịch vụ';
        }else{
            $responses = 'Lỗi trong quá trình xử lý';
        }

        Yii::app()->user->setFlash('response',$responses);
        $this->redirect(array('caidatdichvu',
            'keyword'=>$subscriber->subscriber_number,
            'response' => $responses
        ));
    }

    //admin huy dich vu cho thue bao
    public function actionSendCancelSerivce($id){
        $subscriber = Subscriber::model()->findByPk($id);
        if($subscriber == NULL) {
            Yii::app()->user->setFlash('response',"Lỗi hệ thống");
            $this->redirect(array('caidatdichvu',
                'keyword'=>$subscriber->subscriber_number
            ));
        }

        $user = User::model()->findByPk(Yii::app()->user->id);
        $username = '';
        if($user != NULL) {
            $username = $user->username;
        }else{
            $username = Yii::app()->session['Username'];
        }
        $apiService = new APIService();
        $response = $apiService->cancelService($subscriber->subscriber_number, $username, '113.185.0.153');

        if($response["body"] == 0 || $response["body"] == 6){
            $responseToUser = 'Hủy thành công dịch vụ';
        }else{
            $responseToUser = 'Lỗi trong quá trình xử lý';
        }

        Yii::app()->user->setFlash('response',$responseToUser);
        $this->redirect(array( 'caidatdichvu',
            'keyword'=>$subscriber->subscriber_number ,
            'response' => $responseToUser
        ));
    }

    public function actionUseService()
    {

        if (isset($_POST['search'])) {
            $subscriber_number = $_POST['subscriber_number'];
            $service_id = $_POST['service_id'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $subscriber_id = $this->getSubscriberId($subscriber_number);
            if ($subscriber_id == false) {
                $this->render('use_service', array(
                    'error' => 'Subscriber number is not correct. Please check again'
                ));
                return;
            }

            Yii::app()->session['msisdn'] = $subscriber_number;
            Yii::app()->session['service_id'] = $service_id;
            Yii::app()->session['start_date'] = $start_date;
            Yii::app()->session['end_date'] = $end_date;


            $criteria = new CDbCriteria();
            if ($service_id != ''){
                $criteria->condition = "subscriber_id = $subscriber_id and service_id = $service_id and (purchase_type = 1 or purchase_type = 3 or purchase_type = 4) and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }
            else{
                $criteria->condition = "subscriber_id = $subscriber_id and (purchase_type = 1 or purchase_type = 3 or purchase_type = 4) and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }
            $criteria->order = 'id DESC';
            //$criteria->params = array (':id'=>$id);

            $item_count = SubscriberTransaction::model()->count($criteria);

            $pages = new CPagination($item_count);
            $pages->setPageSize($this->per_page);
            $pages->applyLimit($criteria);  // the trick is here!

            $this->render('use_service',array(
                'search' => true,
                'model'=> SubscriberTransaction::model()->findAll($criteria), // must be the same as $item_count
                'item_count'=>$item_count,
                'page_size'=> $this->per_page,
                'items_count'=>$item_count,
                'pages'=>$pages,
                'msisdn' => $subscriber_number,
                'service_id' => $service_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));

        }
        elseif (isset(Yii::app()->session['msisdn'])){
            $date = new DateTime(date('Y-m-d'));
            $date->modify('-7 days');
            $start_date = $date->format('Y-m-d');
            $end_date = date('Y-m-d');

            $subscriber = Subscriber::model()->findByAttributes(array('subscriber_number' => Yii::app()->session['msisdn']));
            if ($subscriber){
                $subscriber_id = $subscriber->id;
            }else{
                $subscriber_id = -1000;
            }

            $service_id = isset(Yii::app()->session['service_id']) ? Yii::app()->session['service_id'] : '';
            $start_date = isset(Yii::app()->session['start_date']) ? Yii::app()->session['start_date'] : $start_date;
            $end_date = isset(Yii::app()->session['end_date']) ? Yii::app()->session['end_date'] : $end_date;
//            var_dump($service_id, $start_date, $end_date, $subscriber->id);die;
            $criteria = new CDbCriteria();
            if ($service_id != '') {
                $criteria->condition = "subscriber_id = $subscriber_id and service_id = $service_id and (purchase_type = 1 or purchase_type = 3 or purchase_type = 4) and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }else{
                $criteria->condition = "subscriber_id = $subscriber_id and (purchase_type = 1 or purchase_type = 3 or purchase_type = 4) and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }
            $criteria->order = 'id DESC';
            //$criteria->params = array (':id'=>$id);

            $item_count = SubscriberTransaction::model()->count($criteria);

            $pages = new CPagination($item_count);
            $pages->setPageSize($this->per_page);
            $pages->applyLimit($criteria);  // the trick is here!

            $this->render('use_service',array(
                'search' => true,
                'model'=> SubscriberTransaction::model()->findAll($criteria), // must be the same as $item_count
                'item_count'=>$item_count,
                'page_size'=> $this->per_page,
                'items_count'=>$item_count,
                'pages'=>$pages,
                'msisdn' => Yii::app()->session['msisdn'],
                'service_id' => $service_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));
        }
        else {
            $this->render('use_service', array());
        }

    }

    public function actionChargingHistory()
    {
        if (isset($_POST['search'])) {
            $subscriber_number = $_POST['subscriber_number'];
            $service_id = $_POST['service_id'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $subscriber_id = $this->getSubscriberId($subscriber_number);
            if ($subscriber_id == false) {
                $this->render('charging_history', array(
                    'error' => 'Subscriber number is not correct. Please check again'
                ));
                return;
            }
            Yii::app()->session['msisdn'] = $subscriber_number;
            Yii::app()->session['service_id'] = $service_id;
            Yii::app()->session['start_date'] = $start_date;
            Yii::app()->session['end_date'] = $end_date;


            $criteria = new CDbCriteria();
            if ($service_id != ''){
                $criteria->condition = "subscriber_id = $subscriber_id and service_id = $service_id and status = 1 and (purchase_type = 1 or purchase_type = 2) and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }else{
                $criteria->condition = "subscriber_id = $subscriber_id and status = 1 and (purchase_type = 1 or purchase_type = 2) and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }

            $criteria->order = 'id DESC';
            //$criteria->params = array (':id'=>$id);

            $item_count = SubscriberTransaction::model()->count($criteria);

            $pages = new CPagination($item_count);
            $pages->setPageSize($this->per_page);
            $pages->applyLimit($criteria);  // the trick is here!

            $this->render('charging_history',array(
                'search' => true,
                'model'=> SubscriberTransaction::model()->findAll($criteria), // must be the same as $item_count
                'item_count'=>$item_count,
                'page_size'=> $this->per_page,
                'items_count'=>$item_count,
                'pages'=>$pages,
                'msisdn' => $subscriber_number,
                'service_id' => $service_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));

        }
        elseif (isset(Yii::app()->session['msisdn'])){

            $date = new DateTime(date('Y-m-d'));
            $date->modify('-7 days');
            $start_date = $date->format('Y-m-d');
            $end_date = date('Y-m-d');

            $subscriber = Subscriber::model()->findByAttributes(array('subscriber_number' => Yii::app()->session['msisdn']));
            if ($subscriber){
                $subscriber_id = $subscriber->id;
            }else{
                $subscriber_id = -1000;
            }
            $service_id = isset(Yii::app()->session['service_id']) ? Yii::app()->session['service_id'] : '';
            $start_date = isset(Yii::app()->session['start_date']) ? Yii::app()->session['start_date'] : $start_date;
            $end_date = isset(Yii::app()->session['end_date']) ? Yii::app()->session['end_date'] : $end_date;

            $criteria = new CDbCriteria();
            if ($service_id != '') {
                $criteria->condition = "subscriber_id = $subscriber_id and service_id = $service_id and status = 1 and (purchase_type = 1 or purchase_type = 2) and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }
            else{
                $criteria->condition = "subscriber_id = $subscriber_id and status = 1 and (purchase_type = 1 or purchase_type = 2) and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }
            $criteria->order = 'id DESC';
            //$criteria->params = array (':id'=>$id);

            $item_count = SubscriberTransaction::model()->count($criteria);

            $pages = new CPagination($item_count);
            $pages->setPageSize($this->per_page);
            $pages->applyLimit($criteria);  // the trick is here!

            $this->render('charging_history',array(
                'search' => true,
                'model'=> SubscriberTransaction::model()->findAll($criteria), // must be the same as $item_count
                'item_count'=>$item_count,
                'page_size'=> $this->per_page,
                'items_count'=>$item_count,
                'pages'=>$pages,
                'msisdn' => Yii::app()->session['msisdn'],
                'service_id' => $service_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));
        }
        else {
            $this->render('charging_history', array());
        }
    }

    public function actionUseHistory()
    {
        if (isset($_POST['search'])) {
            $subscriber_number = $_POST['subscriber_number'];
            $service_id = $_POST['service_id'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $subscriber_id = $this->getSubscriberId($subscriber_number);
            if ($subscriber_id == false) {
                $this->render('use_history', array(
                    'error' => 'Subscriber number is not correct. Please check again'
                ));
                return;
            }
            Yii::app()->session['msisdn'] = $subscriber_number;
            Yii::app()->session['service_id'] = $service_id;
            Yii::app()->session['start_date'] = $start_date;
            Yii::app()->session['end_date'] = $end_date;


            $criteria = new CDbCriteria();
            if ($service_id != ''){
                $criteria->condition = "subscriber_id = $subscriber_id and service_id = $service_id and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }
            else{
                $criteria->condition = "subscriber_id = $subscriber_id and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }
            $criteria->order = 'id DESC';
            //$criteria->params = array (':id'=>$id);

            $item_count = SubscriberTransaction::model()->count($criteria);

            $pages = new CPagination($item_count);
            $pages->setPageSize($this->per_page);
            $pages->applyLimit($criteria);  // the trick is here!

            $this->render('use_history',array(
                'search' => true,
                'model'=> SubscriberTransaction::model()->findAll($criteria), // must be the same as $item_count
                'item_count'=>$item_count,
                'page_size'=> $this->per_page,
                'items_count'=>$item_count,
                'pages'=>$pages,
                'msisdn' => $subscriber_number,
                'service_id' => $service_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));

        }
        elseif (isset(Yii::app()->session['msisdn'])){

            $date = new DateTime(date('Y-m-d'));
            $date->modify('-7 days');
            $start_date = $date->format('Y-m-d');
            $end_date = date('Y-m-d');

            $subscriber = Subscriber::model()->findByAttributes(array('subscriber_number' => Yii::app()->session['msisdn']));
            if ($subscriber){
                $subscriber_id = $subscriber->id;
            }else{
                $subscriber_id = -1000;
            }
            $service_id = isset(Yii::app()->session['service_id']) ? Yii::app()->session['service_id'] : '';
            $start_date = isset(Yii::app()->session['start_date']) ? Yii::app()->session['start_date'] : $start_date;
            $end_date = isset(Yii::app()->session['end_date']) ? Yii::app()->session['end_date'] : $end_date;

            $criteria = new CDbCriteria();
            if ($service_id != '') {
                $criteria->condition = "subscriber_id = $subscriber_id and service_id = $service_id and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }else{
                $criteria->condition = "subscriber_id = $subscriber_id and (create_date between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }

            $criteria->order = 'id DESC';
            //$criteria->params = array (':id'=>$id);

            $item_count = SubscriberTransaction::model()->count($criteria);

            $pages = new CPagination($item_count);
            $pages->setPageSize($this->per_page);
            $pages->applyLimit($criteria);  // the trick is here!

            $this->render('use_history',array(
                'search' => true,
                'model'=> SubscriberTransaction::model()->findAll($criteria), // must be the same as $item_count
                'item_count'=>$item_count,
                'page_size'=> $this->per_page,
                'items_count'=>$item_count,
                'pages'=>$pages,
                'msisdn' => Yii::app()->session['msisdn'],
                'service_id' => $service_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));
        }
        else {
            $this->render('use_history', array());
        }
    }

    public function actionMtMoHistory()
    {
        if (isset($_POST['search'])) {
            $subscriber_number = $_POST['subscriber_number'];
            $service_id = $_POST['service_id'];
            $start_date = $_POST['start_date'];
            $end_date = $_POST['end_date'];

            $subscriber_id = $this->getSubscriberId($subscriber_number);
            if ($subscriber_id == false) {
                $this->render('mt_mo_history', array(
                    'error' => 'Subscriber number is not correct. Please check again'
                ));
                return;
            }
            Yii::app()->session['msisdn'] = $subscriber_number;
            Yii::app()->session['service_id'] = $service_id;
            Yii::app()->session['start_date'] = $start_date;
            Yii::app()->session['end_date'] = $end_date;


            $criteria = new CDbCriteria();
            if ($service_id != '') {
                $criteria->condition = "subscriber_id = $subscriber_id and service_id = $service_id and (sending_time between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }else{
                $criteria->condition = "subscriber_id = $subscriber_id and (sending_time between '$start_date 00:00:00' and '$end_date 23:59:59')";
            }

            $criteria->order = 'id DESC';
            //$criteria->params = array (':id'=>$id);

            $item_count = SmsMessage::model()->count($criteria);

            $pages = new CPagination($item_count);
            $pages->setPageSize($this->per_page);
            $pages->applyLimit($criteria);  // the trick is here!

            $this->render('mt_mo_history',array(
                'search' => true,
                'model'=> SmsMessage::model()->findAll($criteria), // must be the same as $item_count
                'item_count'=>$item_count,
                'page_size'=> $this->per_page,
                'items_count'=>$item_count,
                'pages'=>$pages,
                'msisdn' => $subscriber_number,
                'service_id' => $service_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));

        }
        elseif (isset(Yii::app()->session['msisdn'])){

            $date = new DateTime(date('Y-m-d'));
            $date->modify('-7 days');
            $start_date = $date->format('Y-m-d');
            $end_date = date('Y-m-d');

            $subscriber = Subscriber::model()->findByAttributes(array('subscriber_number' => Yii::app()->session['msisdn']));
            if ($subscriber){
                $subscriber_id = $subscriber->id;
            }else{
                $subscriber_id = -1000;
            }
            $service_id = isset(Yii::app()->session['service_id']) ? Yii::app()->session['service_id'] : '';
            $start_date = isset(Yii::app()->session['start_date']) ? Yii::app()->session['start_date'] : $start_date;
            $end_date = isset(Yii::app()->session['end_date']) ? Yii::app()->session['end_date'] : $end_date;

            $criteria = new CDbCriteria();
            $criteria->condition = "subscriber_id = $subscriber_id and (sending_time between '$start_date 00:00:00' and '$end_date 23:59:59')";


            $criteria->order = 'id DESC';
            //$criteria->params = array (':id'=>$id);

            $item_count = SmsMessage::model()->count($criteria);

            $pages = new CPagination($item_count);
            $pages->setPageSize($this->per_page);
            $pages->applyLimit($criteria);  // the trick is here!
            $this->render('mt_mo_history',array(
                'search' => true,
                'model'=> SmsMessage::model()->findAll($criteria), // must be the same as $item_count
                'item_count'=>$item_count,
                'page_size'=> $this->per_page,
                'items_count'=>$item_count,
                'pages'=>$pages,
                'msisdn' => Yii::app()->session['msisdn'],
                'service_id' => $service_id,
                'start_date' => $start_date,
                'end_date' => $end_date
            ));
        }
        else {
            $this->render('mt_mo_history', array());
        }
    }

    public function actionBonusCode()
    {
        $this->render('bonus_code', array());
    }

    protected function getSubscriberId($subscriber_number)
    {
        $subscriber = Subscriber::model()->findByAttributes(array('subscriber_number' => $subscriber_number));
        if ($subscriber) {
            return $subscriber->id;
        }
        return false;
    }
    public function actionCancelnumber(){
        if (empty($_POST['fileToUpload'])) {
            echo "Bạn chưa chọn file upload";die;
        }
        $fullFileName = '/var/www/html/namviet_vfilmbackend/backend/www/upload/'. $_POST['fileToUpload'];
        $file = file($fullFileName);
        $relations = array();
        $str = "";
        $status = 0;
        $cancelFaild = 0;
        $cancalSuccess =0;
        $listSubFail = '';
        $apiService = new APIService();
        $user = User::model()->findByPk(Yii::app()->user->id);
        $username = '';
        if($user != NULL) {
            $username = $user->username;
        }else{
            $username = Yii::app()->session['Username'];
        }
        for($i = 0; $i < count($file); $i++)
        {
            $relation = explode(";",trim($file[$i]));
//                $relation[0]=null; // so thue bao
            $subscriber = Subscriber::model()->findByAttributes(array('subscriber_number' => $relation[0]));
            $usingServices = $subscriber != null ? ServiceSubscriberMapping::model()->findAllByAttributes(array('subscriber_id' => $subscriber->id, 'is_active' => 1)) :null;
            if ($subscriber != null && count($usingServices) > 0) {
                foreach ($usingServices as $k=>$s) {
                    $response = $apiService->cancelService($s, $username, '113.185.0.153');
                }
                //      $cancelSuccess +=$cancelSuccess;
//                echo "Thành công : ".$relation[0].'<br/>';
//              echo $k."<br/>";
            }else{
                echo "Số này : ".$relation[0]." hủy rồi".'<br/>';
            }
        }

    }
}
