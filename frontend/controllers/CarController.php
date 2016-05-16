<?php

class CarController extends Controller
{
	private $pageSize = 12;
	public function actionIndex() {
        return $this->redirect(array("car/browse"));
    }

    public function actionView($id) {
        if (!isset($id))
            return $this->redirect(array("car/browse"));

        $model = Car::model();
        /** @var $asset VodAsset */
        $car = $model->findByAttributes(array('id' => $id, 'status' => 1));
        if (!$car)
            return $this->redirect(array("car/browse"));

        $posterUrl = Car::model()->getFirstImage($id);
//        $related = $car->getRelatedCar("rand()", 0, 5);
//        $relatedCar = $related['data'];
//        for ($i = 0; $i < count($relatedCar); $i++) {
//            $relatedVods[$i] = CUtils::loadVodPoster($relatedVods[$i]);
//            $relatedVods[$i]['encrypted_id'] = $this->crypt->encrypt($relatedVods[$i]['id']);
//        }
//        $cats = $car->CarCategoryMappings;
        
        $nameCats = " ";
//        foreach ($cats as $cat) {
//            $catModel = CarCategory::model()->findByPk($cat->car_news_category_id);
//            $nameCats .= $catModel->name . ',';
//        }
        $this->page_id = "car_index_$id";
        $this->render('index', array(
            'car' => $car,
            'posterUrl' => $posterUrl,
//            'catenames' => $nameCats,
//            'related' => $relatedCar,
            'page_id' => 'Car_index'));
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
                $db_order = 't.id DESC';
                $categoryName = "Xe mới nhất";
                break;
            case "most_viewed":
                $db_order = 't.view_count DESC';
                $categoryName = "Xe xem nhiều";
                break;
            case "top_rated":
                $db_order = 't.rating_count DESC';
                $categoryName = "Xe bình chọn nhiều";
                break;
            case "most_discussed":
                $db_order = 't.comment_count DESC';
                $categoryName = "Xe bình luận nhiều";
                break;
            case "featured"://not support now
            // $models = Asset::model()->findAll();
            //break;
            default: //case "default":
                $order = 'default';
                $db_order = "t.id DESC";
                $categoryName = "Xe mới nhất";
                break;
        }

        if (isset($category_id)) {
            $catModel = new CarBrand();
            $category = $catModel->findByPk($category_id);
            if (isset($category))
                $categoryName = $category->name;
        }

        $result = Car::findCars($category_id, $db_order, $page, $pageSize, $keyword);
//        exit();
        $cars = $result['data'];
//        for ($i = 0; $i < count($cars); $i++) {
//            $assets[$i] = CUtils::loadVodPoster($assets[$i]);
//            $assets[$i]['encrypted_id'] = $this->crypt->encrypt($assets[$i]['id']);
//        }

        $pager = array();
        foreach (array('total_result', 'page_number', 'page_size', 'total_page') as $e) {
            if (array_key_exists($e, $result))
                $pager[$e] = $result[$e];
        }
//        $this->page_id = "video_browse";
        $this->render('browse', array(
            'type' => 'browse',
            'category' => $categoryName,
            'cars' => $cars,
            'category_id' => $category_id,
            'order_by' => $order_by,
            'pager' => $pager,
            'page_id' => 'car_browse'
        ));
    }
}
