<?php

/**
 * This is the model class for table "revenue".
 *
 * The followings are the available columns in table 'revenue':
 * @property integer $id
 * @property integer $service_id
 * @property double $view
 * @property double $view_vtv
 * @property double $download
 * @property double $gift
 * @property string $create_date
 * @property double $register
 * @property double $extend
 * @property double $gift_sub
 */
class Revenue extends CActiveRecord
{
	public $startDate;
    public $endDate;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Revenue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'revenue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id', 'numerical', 'integerOnly'=>true),
			array('view, view_vtv, download, gift, register, extend, gift_sub, retry_extend', 'numerical'),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, view, view_vtv, download, gift, create_date, register, extend, gift_sub, retry_extend', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'service_id' => 'Service',
			'view' => 'View',
			'view_vtv' => 'View VTV',
			'download' => 'Download',
			'gift' => 'Gift',
			'create_date' => 'Create Date',
			'register' => 'Register',
			'extend' => 'Extend',
			'gift_sub' => 'Gift Sub',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('view',$this->view);
		$criteria->compare('view_vtv',$this->view_vtv);
		$criteria->compare('download',$this->download);
		$criteria->compare('gift',$this->gift);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('register',$this->register);
		$criteria->compare('extend',$this->extend);
		$criteria->compare('gift_sub',$this->gift_sub);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function report($startDate, $endDate){
		$where = "1";
		if($startDate != null){
			$where .= " AND (DATE(t.create_date) >= DATE('".$startDate."'))"; 
		}
		if($endDate != null){
            $where .= " AND (DATE(t.create_date) <= DATE('".$endDate."'))"; 
		}
//		echo $where;
//		exit();
        $result = Yii::app()->db->createCommand()
                ->selectDistinct('t.id,t.service_id,t.create_date,t.register,t.extend,t.retry_extend,t.view,t.download,t.gift,t.view_vtv')
                ->from('revenue as t')
                ->where($where) 
//                ->order('t.create_date asc, t.service_id desc')
                ->queryAll();
        return array(
            'data'=>$result
        );
	}
//	public static function revenueToday($startDate, $endDate){
////		date_default_timezone_set("Asia/Ho_Chi_Minh");
//		$today = date("Y-m-d H:i:s", time());
//		$date = date('Y-m-d');
//		$startDate = CUtils::getStartDate($startDate);
//		$endDate = CUtils::getEndDate($endDate);
//		if($today >= $startDate && $today <= $endDate){
//			$sqlString = "select ";
//			$sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = ".SERVICE_2." and DATE(create_date) = '$date' and purchase_type = ".PURCHASE_TYPE_NEW." and using_type = ".USING_TYPE_REGISTER.") as revenueRegister,";
//			$sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = ".SERVICE_2." and DATE(create_date) = '$date' and purchase_type = ".PURCHASE_TYPE_RECUR.") as revenueExtend,";
//			$sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = ".SERVICE_2." and DATE(create_date) = '$date' and purchase_type = ".PURCHASE_TYPE_RETRY_EXTEND.") as revenueRetryExtend, ";
//			$sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and DATE(create_date) = '$date' and purchase_type = ".PURCHASE_TYPE_NEW." and using_type = ".USING_TYPE_WATCH.") as revenueView ";
//			$sqlString .= "From subscriber_transaction";
//			$subscriberTransaction = SubscriberTransaction::model()->findBySql($sqlString, array());
//			if($subscriberTransaction != NULL) {
//				$subscriberTransaction->revenueRegister = ($subscriberTransaction->revenueRegister==null)?0:$subscriberTransaction->revenueRegister;
//				$subscriberTransaction->revenueExtend = ($subscriberTransaction->revenueExtend==null)?0:$subscriberTransaction->revenueExtend;
//				$subscriberTransaction->revenueRetryExtend = ($subscriberTransaction->revenueRetryExtend==null)?0:$subscriberTransaction->revenueRetryExtend;
//				$subscriberTransaction->revenueView = ($subscriberTransaction->revenueView==null)?0:$subscriberTransaction->revenueView;
//				$subscriberTransaction->revenueTotal = $subscriberTransaction->revenueRegister + $subscriberTransaction->revenueExtend + $subscriberTransaction->revenueRetryExtend + $subscriberTransaction->revenueView;
//			}
//			return $subscriberTransaction;
//		}
//	}
    public static function revenueToday($startDate, $endDate){
//		date_default_timezone_set("Asia/Ho_Chi_Minh");
        $today = date("Y-m-d H:i:s", time());
        $date = date('Y-m-d');
        $startDate = CUtils::getStartDate($startDate);
        $endDate = CUtils::getEndDate($endDate);
        $time = CUtils::getStartDate($today);
        if($today >= $startDate && $today <= $endDate){
            $sqlString = "select ";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 4 and create_date > '$time' and purchase_type = ".PURCHASE_TYPE_NEW." and using_type = ".USING_TYPE_REGISTER.") as revenueRegister,";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 4 and create_date > '$time' and purchase_type = ".PURCHASE_TYPE_RECUR.") as revenueExtend,";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 4 and DATE(create_date) = '$date' and purchase_type = ".PURCHASE_TYPE_RETRY_EXTEND.") as revenueRetryExtend, ";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 4 and create_date > '$time' and using_type = ".USING_TYPE_SEND_GIFT.") as revenueGifts, ";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 5 and create_date > '$time' and purchase_type = ".PURCHASE_TYPE_NEW." and using_type = ".USING_TYPE_REGISTER.") as revenueRegister7,";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 5 and create_date > '$time' and purchase_type = ".PURCHASE_TYPE_RECUR.") as revenueExtend7,";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 5 and DATE(create_date) = '$date' and purchase_type = ".PURCHASE_TYPE_RETRY_EXTEND.") as revenueRetryExtend7, ";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 5 and create_date > '$time' and using_type = ".USING_TYPE_SEND_GIFT.") as revenueGift7, ";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 6 and DATE(create_date) = '$date' and purchase_type = ".PURCHASE_TYPE_NEW." and using_type = ".USING_TYPE_REGISTER.") as revenueRegisterVtv,";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 6 and DATE(create_date) = '$date' and purchase_type = ".PURCHASE_TYPE_RECUR.") as revenueExtendVtv,";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 6 and DATE(create_date) = '$date' and purchase_type = ".PURCHASE_TYPE_RETRY_EXTEND.") as revenueRetryExtendVtv, ";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and service_id = 6 and DATE(create_date) = '$date' and using_type = ".USING_TYPE_SEND_GIFT.") as revenueGiftVtv, ";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and create_date > '$time' and purchase_type = ".PURCHASE_TYPE_NEW." and using_type = ".USING_TYPE_WATCH.") as revenueView, ";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and create_date > '$time' and purchase_type = ".PURCHASE_TYPE_NEW." and using_type = ".USING_TYPE_DOWNLOAD.") as revenueDownload, ";
            $sqlString .= "(select sum(`cost`) from subscriber_transaction where status = 1 and create_date > '$time' and purchase_type = ".PURCHASE_TYPE_NEW." and using_type = ".USING_TYPE_SEND_GIFT.") as revenueGift ";
            $sqlString .= "From subscriber_transaction where create_date > '$time' GROUP BY DATE(create_date)";
            $subscriberTransaction = SubscriberTransaction::model()->findBySql($sqlString, array());
            if($subscriberTransaction != NULL) {
                $subscriberTransaction->revenueRegister = ($subscriberTransaction->revenueRegister==null)?0:$subscriberTransaction->revenueRegister;
                $subscriberTransaction->revenueExtend = ($subscriberTransaction->revenueExtend==null)?0:$subscriberTransaction->revenueExtend;
                $subscriberTransaction->revenueRetryExtend = ($subscriberTransaction->revenueRetryExtend==null)?0:$subscriberTransaction->revenueRetryExtend;
                $subscriberTransaction->revenueGifts = ($subscriberTransaction->revenueGifts==null)?0:$subscriberTransaction->revenueGifts;
                $subscriberTransaction->revenueRegister7 = ($subscriberTransaction->revenueRegister7==null)?0:$subscriberTransaction->revenueRegister7;
                $subscriberTransaction->revenueExtend7 = ($subscriberTransaction->revenueExtend7==null)?0:$subscriberTransaction->revenueExtend7;
                $subscriberTransaction->revenueRetryExtend7 = ($subscriberTransaction->revenueRetryExtend7==null)?0:$subscriberTransaction->revenueRetryExtend7;
                $subscriberTransaction->revenueGift7 = ($subscriberTransaction->revenueGift7==null)?0:$subscriberTransaction->revenueGift7;
                $subscriberTransaction->revenueRegisterVtv = ($subscriberTransaction->revenueRegisterVtv==null)?0:$subscriberTransaction->revenueRegisterVtv;
                $subscriberTransaction->revenueExtendVtv = ($subscriberTransaction->revenueExtendVtv==null)?0:$subscriberTransaction->revenueExtendVtv;
                $subscriberTransaction->revenueRetryExtendVtv = ($subscriberTransaction->revenueRetryExtendVtv==null)?0:$subscriberTransaction->revenueRetryExtendVtv;
                $subscriberTransaction->revenueGiftVtv = ($subscriberTransaction->revenueGiftVtv==null)?0:$subscriberTransaction->revenueGiftVtv;
                $subscriberTransaction->revenueView = ($subscriberTransaction->revenueView==null)?0:$subscriberTransaction->revenueView;
                $subscriberTransaction->revenueDownload= ($subscriberTransaction->revenueDownload==null)?0:$subscriberTransaction->revenueDownload;
                $subscriberTransaction->revenueGift = ($subscriberTransaction->revenueGift==null)?0:$subscriberTransaction->revenueGift;
            }
            return $subscriberTransaction;
        }
    }
}