<?php

/**
 * Description of CUtils
 *
 * @author Nguyen Chi Thuc
 */
class CUtils {
    //put your code here
    
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
    
}

?>
