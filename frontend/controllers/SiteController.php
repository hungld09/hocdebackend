<?php
/**
 * SiteController.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:25 AM
 */
class SiteController extends Controller {
	private $pageSize = 3;
	public function accessRules() {
		return array(
			// not logged in users should be able to login and view captcha images as well as errors
			array('allow', 'actions' => array('index', 'captcha', 'login', 'error', 'KK')),
			// logged in users can do whatever they want to
			array('allow', 'users' => array('@')),
			// not logged in users can't do anything except above
			array('deny'),
		);
	}

	/**
	 * Declares class-based actions.
	 * @return array
	 */
	public function actions() {
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha' => array(
				'class' => 'CCaptchaAction',
				'backColor' => 0xFFFFFF,
			),
		);
	}

	/* open on startup */
	public function actionIndex() {
		$oderNewCar = "t.create_date DESC";
		$result = CarNews::model()->findCARNEWSs(null, $oderNewCar, 0, $this->pageSize, null);
		$newCar = $result['data'];
//		for ($i = 0; $i < count($newCar); $i++) {
//			$newCar[$i] = CUtils::loadCarPoster($newCar[$i]);
//			$newCar[$i]['encrypted_id'] = $this->crypt->encrypt($newCar[$i]['id']);
//		}
		
		$oderCarNews247 = "t.create_date DESC";
		$result = CarNews::model()->findCARNEWSs(9, $oderCarNews247, 0, $this->pageSize, null);
		$carNews247 = $result['data'];
		
		$oderCarHigway = "t.create_date DESC";
		$result = CarNews::model()->findCARNEWSs(8, $oderCarHigway, 0, $this->pageSize, null);
		$carHighway = $result['data'];
		
		
		$this->render('index', array(
			'newest'   => $newCar,
			'carNews247' => $carNews247,
			'carHighway'=>$carHighway,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError() {
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin() {
		$model = new LoginForm;

		// if it is ajax validation request
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if (isset($_POST['LoginForm'])) {
			$model->attributes = $_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if ($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login', array('model' => $model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout() {
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}


}