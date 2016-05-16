<?php
/**
 * Controller.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:55 AM
 */
define('CHECK_SECURITY', '1');
define('ESPECIAL_API_KEY', '3sp3c1al_ap1_k3y');
define('IV_KEY', 'CAdvS3cur1ty@IV$');
define('SERVER_URL', 'http://cmsxe247.mobiphim.vn/files/');

class Controller extends CController {

	public $breadcrumbs = array();
	public $menu = array();

	protected $_api_key = "";
	protected $_device_id = "";
	protected $_device_token = "";
	protected $_sessionID = "";
	protected $_device_type_id = "1"; // tam thoi 1 - android, 2 - iOS, 3 - Web
	protected $_app_version_code = "";
	protected $_clientUser = NULL;
	protected $_isTablet = 0; // 0 - not tablet, 1 - is tablet
	protected $_msisdn = "";
	protected $_password = "";
	protected $_client_ip;
	protected $_subscriber = NULL;
	protected $_format = 'json';
	
	/**
	 *
	 * @param type $error_no
	 * @param type $error_code
	 * @param type $message
	 */
	public function responseError($error_no, $error_code, $message) {
		header('Content-type: application/json; charset=utf-8');

		$arr['session'] = $this->_sessionID?$this->_sessionID:"";
		$arr['client_app_code'] = $this->_app_version_code?$this->_app_version_code:1;
		$arr['device_type_id'] = $this->_device_type_id?$this->_device_type_id:"";
		$arr['msisdn'] = $this->_msisdn?$this->_msisdn:"";
		$arr['action'] = $this->action->id;
		$arr['error_no'] = $error_no;
		$arr['error_code'] = $error_code;
		$arr['error_message'] = $message;
		$content = CJSON::encode($arr);
		echo $content;
		Yii::app()->end();
	}
	
	public function createHeaderJson() {
		header('Content-type: application/json; charset=utf-8');
		$arr['session'] = $this->_sessionID?$this->_sessionID:"";
		$arr['client_app_code'] = $this->_app_version_code?$this->_app_version_code:1;
		$arr['device_type_id'] = $this->_device_type_id?$this->_device_type_id:"";
		$arr['msisdn'] = $this->_msisdn?$this->_msisdn:"";
		$arr['action'] = $this->action->id;
		$arr['error_no'] = 0;
		return $arr;
	}
}
