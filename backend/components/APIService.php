<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of APIService
 *
 * @author qhuy
 */
class APIService {

    protected $apiURL;
    protected $apiKey;
    protected $ch;
    protected $apiURL2;

    function __construct($apiURL = '') {
// 		$this->apiKey = Yii::app()->params['apiServer']['key'];
		$this->apiKey = "api1K3y";
////         $this->apiURL = $apiURL != '' ? $apiURL : Yii::app()->params['apiServer']['url'];
        /*gọi api VFILM*/
        $this->apiURL2 = "http://127.0.0.1/api";
//        $this->apiURL = "http://vtv.vfilm.vn/api";
        /*gọi api VTV.VFILM*/
        $this->apiURL = "http://192.168.41.67/api";
        //Add option
        $this->ch = new MyCurl(array('api_key' => $this->apiKey));
    }

    public function registerService($msisdn, $user_name, $user_ip, $service_id){
        $response = $this->ch->get($this->apiURL . '/sub/adminRegisterService', array(
            'phone_number' => $msisdn,
            'user_name' => $user_name,
            'user_ip' => $user_ip,
            'service_id' => $service_id,
        ));

        if ($response == null || $response === false)
            return null;
        else{
            $respon = $response;
        }
        return $respon;
    }

    public function cancelService($msisdn, $user_name, $user_ip, $service_id){
        $response = $this->ch->get($this->apiURL . '/sub/adminCancelService', array(
            'phone_number' => $msisdn,
        	'user_name' => $user_name,
        	'user_ip' => $user_ip,
            'service_id' => $service_id,
        ));

        if ($response == null || $response === false)
            return null;
        else{
//            $respon = new SimpleXMLElement($response->body);
            $respon = $response;
        }
        return $respon;
    }

    public function registerRecurring($msisdn){
    	$response = $this->ch->get($this->apiURL . '/sub/adminRegisterRecurring', array(
    			'phone_number' => $msisdn,
    	));
    
    	if ($response == null || $response === false)
    		return null;
    	else{
    		$respon = new SimpleXMLElement($response->body);
    	}
    	return $respon;
    }   

    public function cancelRecurring($msisdn){
    	$response = $this->ch->get($this->apiURL . '/sub/adminCancelRecurring', array(
    			'phone_number' => $msisdn,
    	));
    
    	if ($response == null || $response === false)
    		return null;
    	else{
    		$respon = new SimpleXMLElement($response->body);
    	}
    	return $respon;
    }   
}

?>
