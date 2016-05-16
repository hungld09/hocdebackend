<?php

class ReportController extends RController
{
	const GROUP_DOANH_THU = 5;
	const GROUP_SAN_LUONG = 1;
	const GROUP_NOI_DUNG = 7;
	const GROUP_MOMITER = 0;
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
		$model=new Report;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Report']))
		{
			$model->attributes=$_POST['Report'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['Report']))
		{
			$model->attributes=$_POST['Report'];
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
		$dataProvider=new CActiveDataProvider('Report');
		
		$model = Report::model();
		if(isset($_REQUEST['Report'])) {
			$model->intervalId = $_REQUEST['Report']['intervalId'];
			$model->reportId = $_REQUEST['Report']['reportId'];
			$model->from_date = date('Y-m-d 00:00:00', strtotime($_REQUEST['Report']['from_date']));
			$model->to_date = date('Y-m-d 23:59:59', strtotime($_REQUEST['Report']['to_date']));
		}
		else {
			$model->intervalId = 0;
			$model->reportId = 2;
			$model->from_date = date('d/m/Y', time()-86400);
			$model->to_date = date('d/m/Y', time());
		}

		if(isset($_REQUEST['Report'])) {
			$model->setReportContent(true); //set noi dung tuy theo 4 attribute cua model: from_date, to_date, reportId, intervalId
		}
		else {
			$model->setReportContent(false); //ko co noi dung
		}
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Report('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Report']))
			$model->attributes=$_GET['Report'];

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
		$model=Report::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='report-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionShow($group_id) {
        $role = User::getRole(Yii::app()->user->id);
		$model = Report::model();
		if(isset($_REQUEST['Report'])) {
			$model->intervalId = $_REQUEST['Report']['intervalId'];
			$model->reportId = $_REQUEST['Report']['reportId'];
			$fromDate = DateTime::createFromFormat('d/m/Y', $_REQUEST['Report']['from_date']);
			$model->from_date = $fromDate->format('d/m/Y');
			$model->from_date_db = $fromDate->format('Y-m-d 00:00:00');
			$toDate = DateTime::createFromFormat('d/m/Y', $_REQUEST['Report']['to_date']);
			$model->to_date = $toDate->format('d/m/Y');
			$model->to_date_db = $toDate->format('Y-m-d 00:00:00');
			$model->partnerId = isset($_REQUEST['Report']['partnerId'])?$_REQUEST['Report']['partnerId']:null;
// 			echo strtotime($model->to_date_db); exit;
		}
		else {
			$model->intervalId = 0;
			$model->reportId = 2;
			$model->from_date = date('d/m/Y', time()-86400);
			$model->to_date = date('d/m/Y', time());
			$model->from_date_db = date('Y-m-d 00:00:00', time()-86400);
			$model->to_date_db = date('Y-m-d 23:59:59', time());
		}
		
// 			echo $model->to_date; exit;

		if(isset($_REQUEST['Report'])) {
			$model->setReportContent(true); //set noi dung tuy theo 4 attribute cua model: from_date, to_date, reportId, intervalId
		}
		else {
			$model->setReportContent(false); //ko co noi dung
		}
		$arrReport = Report::model()->findAllByAttributes(array("isRoot" => 0, "isReport" => 1, "report_parent_id" => $group_id));
		
		//xu ly truong hop ko co report voi id $model->reportId *** begin
		$tmp = Report::model()->findByAttributes(array('id'=>$model->reportId, "report_parent_id" => $group_id));
		if($tmp == NULL) {
			$model->reportId = $arrReport[0]->id;
		}
		//xu ly truong hop ko co report voi id $model->reportId *** end
		
		$arrReportRadButton = array();
		$i = 0; //fixme: xoa phan lquan den $i
		foreach($arrReport as $report) {
			$i++; if($i > 8) break;
			// 		$arrReportRadButton['label'] = $report->report_name;
            if($report->id == 40 && $role->name == 'ROLE_NAME_MARKETING'){ continue;}
			$arrReportRadButton[$report->id] = $report->report_name;
		}
		$model->arrReportRadButton = $arrReportRadButton;
		
		$this->render('index',array(
				'model'=>$model,
		));
	}

    public function actionShowDtVtv()
    {

        $this->render('showDtVtv', array(

        ));
    }

    public function actionShowcontent()
    {
        if(isset($_POST['start']) && isset($_POST['end'])){
            try{
                $birthdate = array_reverse(explode('/', $_POST['end']));
                $time = implode('-', $birthdate);
                $date = new DateTime($time);
                $end = $date->format('Y-m-d');

                $birthdate = array_reverse(explode('/', $_POST['start']));
                $time = implode('-', $birthdate);
                $date = new DateTime($time);
                $start = $date->format('Y-m-d');

                $content = array();
                while (strtotime($start) <= strtotime($end)) {
                    $tl_a = 1;
                    $tl_b = 1;
                    $tl_c = 1;
                    $tl_d = 1;
                    $tl_e = 1;
                    $tl_f = 1;
                    $data = ConfigSharing::model()->findAllByAttributes(array('service_id'=>6));
                    foreach($data as $date){
                        $startdate = date('Y-m-d', strtotime($date->start_date));
                        $enddate = date('Y-m-d', strtotime($date->end_date));
                        if(strtotime($startdate) <= strtotime($start) && strtotime($start) <= strtotime($enddate)){
                            $tl_a = $date->config_a / 100;
                            $tl_b = $date->config_b / 100;
                            $tl_c = $date->config_c / 100;
                            $tl_d = $date->config_d / 100;
                            $tl_e = $date->config_e / 100;
                            $tl_f = $date->config_f / 100;
                        }
                    }
                    $model = GeneralReport::model()->findByAttributes(
                        array(
                            'service_id'=>6,
                        ),
                        array(
                            'condition'=>'DATE(report_date) = "'. $start . '"'
                        )
                    );
                    $data = (array(
                        $start => array(
                            $model['register_success_count_free'] * $tl_a, //0 dk miễn phí
                            $model['register_success_count_notfree'] * $tl_b, //1 dk mất phí
                            ($model['manual_cancel_count'] * $tl_c) + ($model['auto_cancel_count'] * $tl_d), //2 chủ động hủy + hệ thống hủy
                            ($model['extend_success_count'] + $model['retry_extend_success_count']) * $tl_e, //3 gia hạn + truy thu thành công
                            $model['view_vtv_count'] * $tl_f, //4 xem lẻ vtv
                            (round(($model['register_success_count_notfree'] * $tl_b),0) * 2000) * 15/100, //5 doanh thu đk mới
                            (round((($model['extend_success_count'] + $model['retry_extend_success_count']) * $tl_e),0) * 2000) * 15/100,//6 doanh thu gia hạn
                            (round(($model['view_vtv_count'] * $tl_f),0) * 2000) * 15/100,//7 doanh thu xem lẻ
                        ))
                    );
                    $content = array_merge_recursive($content, $data);

                    $start = date('Y-m-d', strtotime('+1 days', strtotime($start)));
                }
                $this->renderPartial('_showcontent', array(
                    'model' => $content,
                ));
            }catch (Exception $e){

            }
        }else{
            Yii::app()->user->setFlash('response','Bạn chưa chọn ngày tháng');
            Yii::app()->end;
        }
    }

    public function actionConfigSharing() {
        $model = new ConfigSharing();
        $data = ConfigSharing::model()->findAllByAttributes(array('service_id'=>6));
        if(isset($_POST['ConfigSharing'])){
            $birthdate = array_reverse(explode('/', $_POST['start']));
            $time = implode('-', $birthdate);
            $date = new DateTime($time);
            $start = $date->format('Y-m-d');

            $birthdate = array_reverse(explode('/', $_POST['end']));
            $time = implode('-', $birthdate);
            $date = new DateTime($time);
            $end = $date->format('Y-m-d');


            $model->attributes = $_POST['ConfigSharing'];
            $model->service_id = 6;
            $model->start_date = $start.' 00:00:00';
            $model->end_date = $end.' 23:59:59';

            if($model->save()){
                $this->redirect(Yii::app()->createUrl('report/configSharing'));
            }else{
                $error = $model->getErrors();
                foreach($error as $value){
                    foreach($value as $item){
                        Yii::app()->user->setFlash('_error_', $item);
                    }
                }
            }
        }

        $this->render('configSharing', array(
            'model' => $model,
            'data' => $data
        ));
    }

    public function actionConfigSharingDel() {
        if(isset($_REQUEST['id'])){
            $model = ConfigSharing::model()->findByPk($_REQUEST['id']);
            if($model->delete()){
                $this->redirect(Yii::app()->createUrl('report/configSharing'));
            }else{
                $this->redirect(Yii::app()->createUrl('report/configSharing'));
            }
        }else{
            $this->redirect(Yii::app()->createUrl('report/configSharing'));
        }
    }

	public function actionMonitor() {
		$this->render('monitor');
	}
}
