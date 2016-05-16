<?php

/**
 * Description of CUtils
 *
 * @author Nguyen Chi Thuc
 */
class CUtils {
    //put your code here
    public static $STREAMING_HTTP = 0;
    public static $STREAMING_RTSP = 1;
    public static $STREAMING_HLS  = 2;
    public static $STREAMING_RTMP = 3;
    
    /**
     * Log a msg as custom level "CUtils::Debug"
     * You need to add this level ("CUtils::Debug") to log component in config/main.php :
     * <code>
     * 'log'=>array(
	 *		'class'=>'CLogRouter',
	 *		'routes'=>array(
	 *			array(
	 *				'class'=>'CFileLogRoute',
	 *				'levels'=>'error, warning, <b>CUtils::Debug</b>',
	 *			),
	 *			array('class'=>'CWebLogRoute',),
	 *		),
     * </code>
     * @param string $msg 
     */
    public static function Debug($msg, $category="-=Thuc=-") {
        Yii::log($msg, 'CUtils::Debug', $category);
    }
    
    public static function randomString($length=32, $chars="abcdefghijklmnopqrstuvwxyz0123456789") {
        $max_ind = strlen($chars)-1;
        $res = "";
        for ($i =0; $i < $length; $i++) {
            $res .= $chars{rand(0, $max_ind)};
        }
        
        return $res;
    }
    
    public static function encrypt($str) {
        return md5($str);
    }
    
    public static function loadVodPoster($asset) {
    	$data = VodAsset::getVODImages($asset['id']);
    	$posters = array();
    	foreach ($data as $poster) {
    		$orientation = $poster->orientation == 1 ? "poster_port" : "poster_land";
    		$posters[$orientation] = $poster->url;
    	}
    	return array_merge($asset, $posters);
    }
    
    public static function timeElapsedString($ptime) {
	    $etime = time() - $ptime;
	    
	    if ($etime < 1) {
	        return '0 giây';
	    }
	    
	    $a = array( 12 * 30 * 24 * 60 * 60  => 'năm',
	                30 * 24 * 60 * 60       => 'tháng',
	                24 * 60 * 60            => 'ngày',
	                60 * 60                 => 'giờ',
	                60                      => 'phút',
	                1                       => 'giây'
	                );
	    
	    foreach ($a as $secs => $str) {
	        $d = $etime / $secs;
	        if ($d >= 1) {
	            $r = round($d);
	            return $r . ' ' . $str . ' trước';
	        }
	    }
	}
	
	public static function convertMysqlToTimestamp($dateString) {
		$format = '@^(?P<year>\d{4})-(?P<month>\d{2})-(?P<day>\d{2}) (?P<hour>\d{2}):(?P<minute>\d{2}):(?P<second>\d{2})$@';
		preg_match($format, $dateString, $dateInfo);
		$unixTimestamp = mktime(
				$dateInfo['hour'], $dateInfo['minute'], $dateInfo['second'],
				$dateInfo['month'], $dateInfo['day'], $dateInfo['year']
		);
		return $unixTimestamp;
	}
	
	public static function timeElapsedStringFromMysql($dateString) {
		$ptime = CUtils::convertMysqlToTimestamp($dateString);
		return CUtils::timeElapsedString($ptime);
	}
	
	public static function getDeviceInfo() {
		$uaString = $_SERVER['HTTP_USER_AGENT'];
		//echo $uaString;
		$info = array();
		if (preg_match("/android/i", $uaString)) {
			if (preg_match("/android (\d+)\.(\d+)/i", $uaString, $matches)) {
				$info = array('os' => 'android', 'major' => $matches[1], 'minor' => $matches[2]);
			} else {
				$info = array('os' => 'android', 'major' => 1, 'minor' => 0);
			}
		} else if (preg_match("/iPhone|iPod|iPad/i", $uaString)) {
			$info = array('os' => 'ios', 'major' => 1, 'minor' => 0);
			if (preg_match("/iOS (\d+)\.(\d+)/", $uaString, $matches)) {
				$info['major'] = $matches[1];
				$info['minor'] = $matches[2];
			} else if (preg_match("/iPhone OS (\d+)_(\d+)/", $uaString, $matches)) {
				$info['major'] = $matches[1];
				$info['minor'] = $matches[2];
			}
		} else if (preg_match("/Windows Phone (\d+)\.(\d+)/", $uaString, $matches)) {
			$info = array('os' => 'wp', 'major' => $matches[1], 'minor' => $matches[0]);
		} else if (preg_match("/symbian/i", $uaString)) {
			$info = array('os' => 'symbian', 'major' => 1, 'minor' => 0);
		} else {
			$info = array('os' => 'unknown', 'major' => 1, 'minor' => 0);
		}
		//var_dump($info);
		return $info;
	}
	
	public static function getSupportedStreamingProtocol() {
//		$devInfo = CUtils::getDeviceInfo();
                $detect = Yii::app()->mobileDetect;
                if ($detect->is('AndroidOS')) {
                    if ($detect->version('Android') < 3.0) {
                        return CUtils::$STREAMING_RTSP;
                    } else {
                        return CUtils::$STREAMING_HLS;
                    }
                } else if ($detect->is('SymbianOS')) {
			return CUtils::$STREAMING_RTSP; // rtsp
		} else if ($detect->is('iOS')) {
			return CUtils::$STREAMING_HLS; // hls
		} else if ($detect->is('WindowsMobileOS')) {
			return CUtils::$STREAMING_HTTP;
		} else {
			return CUtils::$STREAMING_HTTP; // http progressive download
		}
	}

	public static function cidrMatch($ip, $range) {
		list ($subnet, $bits) = explode('/', $range);
		$ip = ip2long($ip);
		$subnet = ip2long($subnet);
		$mask = -1 << (32 - $bits);
		$subnet &= $mask; # nb: in case the supplied subnet wasn't correctly aligned
		return ($ip & $mask) == $subnet;
	}
        
        public static function truncateWords($text, $length = 10){
            if(strlen($text) > $length){
                $text_temp = substr($text, 0, $length);
                $end_point = strrpos($text_temp, ' ');
                $text_fi = substr($text_temp, 0, $end_point).'...';
                return $text_fi;
            }else{
                return $text;
            }
        }
        
        public static function validatorMobile($mobileNumber){
            $valid_number = '';
            if(preg_match('/^(84|0)(91|94|123|124|125|127|129)\d{7}$/', $mobileNumber, $matches)){
                if ($matches[1] == 0){
                    $valid_number = preg_replace('/^0/', '84', $mobileNumber);
                }else{
                    $valid_number = $mobileNumber;
                }
            }
            return $valid_number;
        }
        
        public static function getVirtualView($fromDate){
        	//Cheat so luot xem theo ngay up len
        	$createDate = new DateTime($fromDate);
        	$currentDate = new DateTime('now');
        	$interval = $createDate->diff($currentDate);
        	$extraVirtualView = 50*($interval->format('%a') + 1);
        	if($extraVirtualView > 500)
        		$extraVirtualView = 500;
        	return $extraVirtualView;
        }
}

?>
