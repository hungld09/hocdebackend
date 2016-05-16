<?php
class NavMenu extends CWidget {
		public $categoriesCarNews;
		public $carBrand;
		public $carVodCat;
        public $accesType = Controller::ACCESS_VIA_WIFI;
        public $moibleNumber = "";
        public function init() {
		
	}
	
	public function run() {
		$this->render("NavMenu", array('categoriesCarNews' => $this->categoriesCarNews, 'carBrand' => $this->carBrand, 'carVodCat' => $this->carVodCat, 'accesType' => $this->accesType,  'moibleNumber' => $this->moibleNumber));
//		$this->render("NavMenu", array('categories' => $this->categories));
	}
}