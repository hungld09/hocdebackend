<?php
class CarNewsItem extends CWidget {
	public $carNews;
	public $posterUrl;
	public $isFree = false;
	public function init() {
		
	}
	
	public function run() {
		$this->render("CarNewsItem", array('carNews' => $this->carNews, 'posterUrl' => $this->posterUrl, 'isFree' => $this->isFree));
	}
}