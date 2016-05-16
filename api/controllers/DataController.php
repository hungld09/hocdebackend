<?php
/**
 * DataController.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:25 AM
 */
include 'const.php';

class DataController extends Controller {

	public function accessRules() {
		return array(
				// not logged in users should be able to login and view captcha images as well as errors
				array('allow', 'actions' => array('index', 'captcha', 'login', 'error', 'KK')),
				// logged in users can do whatever they want to
				array('allow', 'users' => array('@', 'getNews')),
				// not logged in users can't do anything except above
				array('deny'),
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

	public function actionGetNewsItems() {
		$order = isset($_REQUEST['order'])?$_REQUEST['order']:"";

		$page = isset($_REQUEST['page'])?$_REQUEST['page']:0;
		$page_size = isset($_REQUEST['page_size'])?$_REQUEST['page_size']:10;
		$image_width = isset($_REQUEST['image_width'])?$_REQUEST['image_width']:NULL;
		$keyword = isset($_REQUEST['keyword'])?$_REQUEST['keyword']:"";
		$category = isset($_REQUEST['category'])?$_REQUEST['category']:null; //truong hop dac biet: -1 : all carNews, -2 : favorite carNews

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
				$db_order = "t.id DESC, t.code_name";
				break;
		}

		$res = CarNews::findCARNEWSs($category, $db_order, $page, $page_size, $keyword);

		header('Content-type: application/json; charset=utf-8');

		$arr = $this->createHeaderJson();
			
		$result['keyword'] = $res['keyword'];
		$result['page_number'] = CHtml::encode($res['page_number']);
		$result['page_size'] = CHtml::encode($res['page_size']);
		$result['total_page'] = CHtml::encode($res['total_page']);
		$result['total_result'] = CHtml::encode($res['total_result']);

		$arrCarNewsNode = CarNews::createJsonNewsList($res);
		$result['carNews'] = $arrCarNewsNode;
			
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}

	public function actionGetNewsCategories(){
		header('Content-type: application/json; charset=utf-8');
		$arr = $this->createHeaderJson();

		$result = array();
		$result = CarNewsCategory::_categoriesToJSON(CarNewsCategory::getSubCategories(null,false));
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}

	public function actionGetNewsDetail() {
		$news_id = isset($_REQUEST['news_id'])?$_REQUEST['news_id']:'';
		$carNews = CarNews::model()->findByPk($news_id);
		if($carNews == NULL) {
			$this->responseError(ERROR_CODE_INVALID_ID, 1, "No news with id \"$news_id\" found");
		}
			
		$arr = $this->createHeaderJson();
			
		$result['title'] = $carNews->title;
		$result['content'] = CHtml::encode($carNews->content);
		$result['create_date'] = $carNews->create_date;
		$result['like_count'] = $carNews->like_count;
		$result['rating_count'] = $carNews->rating_count;
		$result['rating'] = $carNews->rating;
		$result['content_short'] = $carNews->content_short;
		$result['content'] = $carNews->content;
			
		$imageUrl = "";
		$image = Image::model()->findByAttributes(array("car_news_id"=>$news_id));
		if($image != NULL) {
			$imageUrl = SERVER_URL.$image->url;
		}
		$result['image'] = CHtml::encode($imageUrl);
			
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}

	public function actionGetCars() {
		$order = isset($_REQUEST['order'])?$_REQUEST['order']:"";

		$page = isset($_REQUEST['page'])?$_REQUEST['page']:0;
		$page_size = isset($_REQUEST['page_size'])?$_REQUEST['page_size']:10;
		$image_width = isset($_REQUEST['image_width'])?$_REQUEST['image_width']:NULL;
		$keyword = isset($_REQUEST['keyword'])?$_REQUEST['keyword']:"";
		$brand = isset($_REQUEST['brand'])?$_REQUEST['brand']:null; //truong hop dac biet: -1 : all carNews, -2 : favorite carNews

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
				$db_order = "t.id DESC, t.code_name";
				break;
		}

		$res = Car::findCars($brand, $db_order, $page, $page_size, $keyword);

		header('Content-type: application/json; charset=utf-8');

		$arr = $this->createHeaderJson();

		$result['keyword'] = $res['keyword'];
		$result['page_number'] = CHtml::encode($res['page_number']);
		$result['page_size'] = CHtml::encode($res['page_size']);
		$result['total_page'] = CHtml::encode($res['total_page']);
		$result['total_result'] = CHtml::encode($res['total_result']);

		foreach ($res['data'] as $car) {
			$carNode = array();
			$carNode['id'] = CHtml::encode($car['id']);
			$carNode['model'] = $car['model'];

			$imageUrl = "";
			$image = Image::model()->findByAttributes(array("car_id"=>$car["id"]));
			if($image != NULL) {
				$imageUrl = SERVER_URL.$image->url;
			}
			$carNode['image'] = CHtml::encode($imageUrl);

			$s_car_brand = '';
			$carBrand = CarBrand::model()->findByPk($car['car_brand_id']);
			if($carBrand != NULL) {
				$s_car_brand = $carBrand->name;
			}
			$carNode['brand'] = $s_car_brand;

			$result['car'][] = $carNode;
		}

		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}

	public function actionGetCarBrands(){
		header('Content-type: application/json; charset=utf-8');
		$arr = $this->createHeaderJson();

		$result = array();
		$result = CarBrand::_carBrandsToJSON(CarBrand::model()->findAll());
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}

	public function actionGetCarDetail() {
		$car_id = isset($_REQUEST['car_id'])?$_REQUEST['car_id']:'';
		$car = Car::model()->findByPk($car_id);
		if($car == NULL) {
			$this->responseError(ERROR_CODE_INVALID_ID, 1, "No car with id \"$car_id\" found");
		}
			
		$arr = $this->createHeaderJson();
			
		$result['table_content'] = $car->getHtmlContent();
		$result['model'] = $car->model;
		$result['release_date'] = $car->release_date;
		$result['like_count'] = $car->like_count;
		$result['rating_count'] = $car->rating_count;
		$result['rating'] = $car->rating;
		$result['release_date'] = $car->release_date;
		$result['msrp'] = $car->msrp;
		$result['wheelbase'] = $car->wheelbase;
		$result['length'] = $car->length;
		$result['width'] = $car->width;
		$result['height'] = $car->height;
		$result['ground_clearence'] = $car->ground_clearence;
		$result['weight'] = $car->weight;
		$result['epa_cargo_volumn'] = $car->epa_cargo_volumn;
		$result['fuel_tank'] = $car->fuel_tank;
		$result['seating_capacity'] = $car->seating_capacity;
		$result['epa_mpg_city'] = $car->epa_mpg_city;
		$result['epa_mpg_hwy'] = $car->epa_mpg_hwy;
		$result['epg_mpg_combined'] = $car->epg_mpg_combined;
		$result['engine_type'] = $car->engine_type;
		$result['displacement'] = $car->displacement;
		$result['horsepower'] = $car->horsepower;
		$result['torque'] = $car->torque;
		$result['recommended_fuel'] = $car->recommended_fuel;
		$result['tune_up_interval'] = $car->tune_up_interval;
			
		$s_car_brand = '';
		$carBrand = CarBrand::model()->findByPk($car->car_brand_id);
		if($carBrand != NULL) {
			$s_car_brand = $carBrand->name;
		}
		$result['brand'] = $s_car_brand;

		$arrCarTypeMapping = CarTypeMapping::model()->findAllByAttributes(array('car_id' => $car_id));
		$s_car_type = '';
		foreach($arrCarTypeMapping as $mapping) {
			$carType = CarType::model()->findByPk($mapping->car_type_id);
			$s_car_type .= ', '. $carType->type;
			if($carType->subtype != NULL) {
				$s_car_type .= ' ('.$carType->subtype.')';
			}
		}
		$s_car_type = substr($s_car_type, 2);
		$result['type'] = $s_car_type;

		$imageUrl = "";
		$image = Image::model()->findByAttributes(array("car_id"=>$car_id));
		if($image != NULL) {
			$imageUrl = SERVER_URL.$image->url;
		}
		$result['image'] = CHtml::encode($imageUrl);
			
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}

	public function actionGetNewsHomePage() {
		$arr = $this->createHeaderJson();

		$order = 'top_new';
		$result[] = CarNews::createNewsGroup($order);

		$order = 'tin_tuc_247';
		$result[] = CarNews::createNewsGroup($order);

		$order = 'cam_nang_xa_lo';
		$result[] = CarNews::createNewsGroup($order);

		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}
	
	public function actionGetVodAssets() {
		$order = isset($_REQUEST['order'])?$_REQUEST['order']:"";
		
		$page = isset($_REQUEST['page'])?$_REQUEST['page']:0;
		$page_size = isset($_REQUEST['page_size'])?$_REQUEST['page_size']:10;
		$image_width = isset($_REQUEST['image_width'])?$_REQUEST['image_width']:NULL;
		$keyword = isset($_REQUEST['keyword'])?$_REQUEST['keyword']:"";
		$category = isset($_REQUEST['category'])?$_REQUEST['category']:null; //truong hop dac biet: -1 : all carNews, -2 : favorite carNews
		
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
				$db_order = "t.id DESC, t.code_name";
				break;
		}
		
		$res = VodAsset::findVODs($category, $db_order, $page, $page_size, $keyword);
		
		header('Content-type: application/json; charset=utf-8');
		
		$arr = $this->createHeaderJson();
			
		$result['keyword'] = $res['keyword'];
		$result['page_number'] = CHtml::encode($res['page_number']);
		$result['page_size'] = CHtml::encode($res['page_size']);
		$result['total_page'] = CHtml::encode($res['total_page']);
		$result['total_result'] = CHtml::encode($res['total_result']);
		
		$arrVideoNode = VodAsset::createJsonNewsList($res);
		$result['videos'] = $arrVideoNode;
			
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();		
	}
	
	public function actionGetVodCategories() {
		header('Content-type: application/json; charset=utf-8');
		$arr = $this->createHeaderJson();
		
		$result = array();
		$result = VodCategory::_categoriesToJSON(VodCategory::getSubCategories(null,false));
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();		
	}
	
	public function actionGetVodAssetDetail() {
		$vod_id = isset($_REQUEST['vod'])?$_REQUEST['vod']:'';
		$vod = VodAsset::model()->findByPk($vod_id);
		if($vod == NULL) {
			$this->responseError(ERROR_CODE_INVALID_ID, 1, "No video with id \"$vod_id\" found");
		}
			
		$arr = $this->createHeaderJson();
			
		$result['display_name'] = $vod->display_name;
		$result['create_date'] = $vod->create_date;
		$result['like_count'] = $vod->like_count;
		$result['rating_count'] = $vod->rating_count;
		$result['rating'] = $vod->rating;
		$result['short_description'] = $vod->short_description;
		$result['description'] = $vod->description;
			
			
		$imageUrl = "";
		$image = Image::model()->findByAttributes(array("vod_asset_id"=>$vod_id));
		if($image != NULL) {
			$imageUrl = SERVER_URL.$image->url;
		}
		$result['image'] = CHtml::encode($imageUrl);
			
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}
	
	public function actionGetStreamUrl() {
		$vod_id = (isset($_REQUEST['vod']) && !empty($_REQUEST['vod']))?$_REQUEST['vod']:null;
		$protocol = (isset($_REQUEST['protocol']) && !empty($_REQUEST['protocol']))?$_REQUEST['protocol']:1;
		
		if ($vod_id === null) {
			$this->responseError(1,"ERROR_","No vod specified!");
		}
		
		$vod = VodAsset::model()->findByPk($vod_id);
		/* @var $vod VodAsset */
		
		if (empty ($vod)) {
			$this->responseError(1,"ERROR_","Requested vod not found.");
		}
		
		$arr = $this->createHeaderJson();
		$streams = array();
		$vodStreams = VodStream::model()->findAllByAttributes(array("vod_asset_id" => $vod->id, "status" => 1, "stream_type" => 1));
		foreach ($vodStreams as $stream) {
			/* @var $stream VodStream */
			if (($stream->protocol == $protocol) || ($protocol == -1)) {
				$streams[] = $stream;
			}
		}
		$result = array();
		foreach ($streams as $stream) {
			$streamNode['protocol'] = $stream->protocol;
			$streamNode['stream_url'] = $stream->stream_url;
			$result[] = $streamNode;
		}
		$vod->view_count++;
		$vod->update();
	
		$arr['result'] = $result;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}
}