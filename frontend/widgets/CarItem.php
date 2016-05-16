<?php
class CarItem extends CWidget {
	public $cars;
	public $posterUrl;
	public $isFree = false;
	public function init() {
		
	}
	
	public function run() {
		$this->render("CarItem", array('car' => $this->cars, 'posterUrl' => $this->posterUrl, 'isFree' => $this->isFree));
	}
}