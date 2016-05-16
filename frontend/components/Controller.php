<?php
/**
 * Controller.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:55 AM
 */
define('SERVER_URL', 'http://cmsxe247.mobiphim.vn/files/');
class Controller extends CController {
	public $layout='//layouts/main';
	public $breadcrumbs = array();
	public $menu = array();
	protected $page_id = 'home_page';
	
	const ACCESS_VIA_WIFI = 1;
    const ACCESS_VIA_3G = 2;
  	public $detect;      
	public $categoriesCarNews = array();
	public $carBrand = array();
	public $carVodCat = array();
	public $crypt;
	public $msisdn = '84944723607';
	public function __construct($id, $module) {
		parent::__construct($id, $module);
		Yii::app()->theme = 'advance';
		$this->categoriesCarNews = CarNewsCategory::getSubCategories();
		$this->carBrand = CarBrand::model()->findAll();
		$this->carVodCat = VodCategory::model()->findAllByAttributes(array('status' => 1));
		// crypt object
		$cryptOptions = Yii::app()->params['cryptOptions'];
		$cryptOptions['key'] = $this->msisdn . "_" . Yii::app()->request->getUserHostAddress();
		$this->crypt = new Crypt($cryptOptions);
		
		//detect device
		$this->detect = Yii::app()->mobileDetect;
		if ($this->detect->isMobile() || $this->detect->isTablet()) {
			if ($this->detect->is('AndroidOS')) {
				if ($this->detect->version('Android') < 3.0) {
					Yii::app()->theme = 'basic';
				} else {
					Yii::app()->theme = 'advance';
				}
			} else if ($this->detect->is('iOS')) {
				if ($this->detect->getIOSGrade() === 'B') {
					Yii::app()->theme = 'basic';
				} else {
					Yii::app()->theme = 'advance';
				}
			} else {
                                if($this->detect->mobileGrade() === 'A'){
                                    Yii::app()->theme = 'advance';
                                }else{
                                    Yii::app()->theme = 'basic';
                                }
			}
		} else {
			Yii::app()->theme = 'basic';
		}
		Yii::app()->theme = 'advance';
	}
}
