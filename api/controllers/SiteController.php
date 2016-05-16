<?php
/**
 * SiteController.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:25 AM
 */
class SiteController extends Controller {

	public function accessRules() {
		return array(
			// not logged in users should be able to login and view captcha images as well as errors
			array('allow', 'actions' => array('index', 'captcha', 'login', 'error', 'KK', 'getNews')),
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
		$this->render('index');
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

	public function actionGetNews() {
		$order = isset($_REQUEST['order'])?$_REQUEST['order']:"";
	
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:0;
		$page_size = isset($_REQUEST['page_size'])?$_REQUEST['page_size']:10;
		$image_width = isset($_REQUEST['image_width'])?$_REQUEST['image_width']:NULL;
		$keyword = isset($_REQUEST['keyword'])?$_REQUEST['keyword']:"";
		$category = isset($_REQUEST['category'])?$_REQUEST['category']:"-1"; //truong hop dac biet: -1 : all carNews, -2 : favorite carNews
	
		// add keyword to history
		if (!empty($keyword)) {
			$keyword = CVietnameseTools::makeSearchableStr($keyword);
		}
	
		$db_order = "";
		switch($order)
		{
			case "top_new":
				$db_order = 't.id DESC';
				break;
			case "most_viewed":
				$db_order = 't.view_count DESC';
				break;
			case "top_rated":
				//$db_order = '(rating_count*3 + rating*7) DESC';
				$db_order = 't.rating_count DESC';
				break;
			case "most_discussed":
				$db_order = 't.comment_count DESC';
				break;
			case "featured"://not support now
				// $models = Asset::model()->findAll();
				//break;
			case "order_number":
				$db_order = 't.order_number ASC';
				break;
			default ://case "default":
				$order = 'default';
				//                $db_order = "t.modify_date DESC"; // tam thoi comment lai, sap xep theo ten phim
				$db_order = "t.id DESC, t.display_name_ascii";
				break;
		}
	
		$res = CarNews::findCARNEWSs($category, $db_order, $page, $page_size, $keyword);
	
		header('Content-type: application/json; charset=utf-8');
	
		$arr['session'] = $this->_sessionID?$this->_sessionID:"";
		$arr['client_app_code'] = $this->_app_version_code?$this->_app_version_code:1;
		$arr['device_type_id'] = $this->_device_type_id?$this->_device_type_id:"";
		$arr['user_name'] = $this->_username?$this->_username:"";
		$arr['action'] = $this->action->id;
		$arr['error_no'] = 0;
			
		$result['keyword'] = $res['keyword'];
		$result['page_number'] = CHtml::encode($res['page_number']);
		$result['page_size'] = CHtml::encode($res['page_size']);
		$result['total_page'] = CHtml::encode($res['total_page']);
		$result['total_result'] = CHtml::encode($res['total_result']);
			
		foreach ($res['data'] as $carNews) {
			$carNewsNode = array();
			$carNewsNode['id'] = CHtml::encode($carNews['id']);
			$carNewsNode['create_date'] = CHtml::encode($carNews['create_date']);
			$carNewsNode['view_count'] = CHtml::encode($carNews['view_count']);
			$carNewsNode['comment_count'] = CHtml::encode($carNews['comment_count']);
			$carNewsNode['like_count'] = CHtml::encode($carNews['like_count']);
			$carNewsNode['dislike_count'] = CHtml::encode($carNews['dislike_count']);
			$carNewsNode['rating'] = CHtml::encode($carNews['rating']);
			$carNewsNode['rating_count'] = CHtml::encode($carNews['rating_count']);
			$carNewsNode['name'] = $carNews['name'];
	
			$author = Author::model()->findByPk($carNews['author_id']);
			$authorStr = "";
			if($author != NULL) {
				$authorStr = $author->display_name;
			}
			$carNewsNode['author'] = $authorStr;
	
			$imageUrl = "";
			$image = CarNewsImage::model()->findByAttributes(array("car_news_id"=>$carNews["id"]));
			if($image != NULL) {
				$imageUrl = $image->url;
			}
			$carNewsNode['image'] = CHtml::encode($imageUrl);
			$carNewsNode['short_description'] = $carNews['short_description'];
			$carNewsNode['description'] = $carNews['description'];
	
			$result['carNews'][] = $carNewsNode;
		}
			
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}
}