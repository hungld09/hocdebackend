<?php
class CarNewsController extends Controller {
	private $pageSize = 12;
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

	public function actionIndex() {
        return $this->redirect(array("carNews/browse"));
    }

    public function actionView($id) {
        if (!isset($id))
            return $this->redirect(array("carNews/browse"));

        $model = CarNews::model();
        /** @var $asset VodAsset */
        $carNews = $model->findByAttributes(array('id' => $id, 'status' => 1));
        if (!$carNews)
            return $this->redirect(array("carNews/browse"));

        $posterUrl = CarNews::model()->getFirstImage($id);
	
        $related = $carNews->getRelatedCarNews("rand()", 0, 5);
        $relatedCarNews = $related['data'];
        for ($i = 0; $i < count($relatedCarNews); $i++) {
//            $relatedVods[$i] = CUtils::loadVodPoster($relatedVods[$i]);
//            $relatedVods[$i]['encrypted_id'] = $this->crypt->encrypt($relatedVods[$i]['id']);
        }
//        $comments = $carNews->getComments(0, 1000);
//        $comments = $comments['data'];
        $cats = $carNews->carNewsCategoryMappings;
        
        $nameCats = " ";
        foreach ($cats as $cat) {
            $catModel = CarNewsCategory::model()->findByPk($cat->car_news_category_id);
            $nameCats .= $catModel->name . ',';
        }
        $this->page_id = "carNews_index_$id";
        $this->render('index', array(
            'carNews' => $carNews,
            'posterUrl' => $posterUrl,
            'catenames' => $nameCats,
            'related' => $relatedCarNews,
//            'comments' => $comments,
            'page_id' => 'carNews_index'));
    }
	
	public function actionBrowse() {
        $category_id = isset($_REQUEST['category']) && preg_match("/^\d+$/", $_REQUEST['category']) ?
                $_REQUEST['category'] : null;
        $order_by = isset($_REQUEST['order']) && preg_match("/(newest|most_viewed)/", $_REQUEST['order']) ?
                $_REQUEST['order'] : "";
        $page = isset($_REQUEST['page']) && preg_match("/^\d+$/", $_REQUEST['page']) ?
                $_REQUEST['page'] : 0;
        $pageSize = isset($_REQUEST['page_size']) && preg_match("/^\d+$/", $_REQUEST['page_size']) ?
                $_REQUEST['page_size'] : $this->pageSize;

        $keyword = null;
        $page = $page > 0 ? $page - 1 : 0;
        $db_order = "";
        $categoryName = "";
        switch ($order_by) {
            case "newest":
                $db_order = 't.create_date DESC';
                $categoryName = "Tin mới nhất";
                break;
            case "most_viewed":
                $db_order = 't.view_count DESC';
                $categoryName = "Tin xem nhiều";
                break;
            case "top_rated":
                $db_order = 't.rating_count DESC';
                $categoryName = "Tin bình chọn nhiều";
                break;
            case "most_discussed":
                $db_order = 't.comment_count DESC';
                $categoryName = "Tin bình luận nhiều";
                break;
            case "featured"://not support now
            // $models = Asset::model()->findAll();
            //break;
            default: //case "default":
                $order = 'default';
                $db_order = "t.create_date DESC";
                $categoryName = "Tin mới nhất";
                break;
        }

        if (isset($category_id)) {
            $catModel = new CarNewsCategory();
            $category = $catModel->findByPk($category_id);
            if (isset($category))
                $categoryName = $category->name;
        }

        $result = CarNews::findCARNEWSs($category_id, $db_order, $page, $pageSize, $keyword);
//        exit();
        $assets = $result['data'];
        for ($i = 0; $i < count($assets); $i++) {
//            $assets[$i] = CUtils::loadVodPoster($assets[$i]);
//            $assets[$i]['encrypted_id'] = $this->crypt->encrypt($assets[$i]['id']);
        }

        $pager = array();
        foreach (array('total_result', 'page_number', 'page_size', 'total_page') as $e) {
            if (array_key_exists($e, $result))
                $pager[$e] = $result[$e];
        }
//        $this->page_id = "video_browse";
        $this->render('browse', array(
            'type' => 'browse',
            'category' => $categoryName,
            'assets' => $assets,
            'category_id' => $category_id,
            'order_by' => $order_by,
            'pager' => $pager,
            'page_id' => 'video_browse'
        ));
    }

}