<?php

/**
 * This is the model class for table "subscriber_activity_log".
 *
 * The followings are the available columns in table 'subscriber_activity_log':
 * @property string $id
 * @property integer $subscriber_id
 * @property integer $subscriber_session_id
 * @property integer $action
 * @property string $params
 * @property string $server_ip
 * @property string $request_date
 * @property string $client_ip
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 * @property SubscriberSession $subscriberSession
 */
class SubscriberActivityLog extends CActiveRecord
{
	public $total_click;
	public $not_coincide_ip;
	public $count_subscriber;
	public $count_ip_not_coincide;
	public $report_date;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberActivityLog the static model class
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
		return 'subscriber_activity_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id, subscriber_session_id, action, status', 'numerical', 'integerOnly'=>true),
			array('server_ip, client_ip', 'length', 'max'=>45),
			array('params, request_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subscriber_id, subscriber_session_id, action, params, server_ip, request_date, client_ip, status', 'safe', 'on'=>'search'),
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
			'subscriber' => array(self::BELONGS_TO, 'Subscriber', 'subscriber_id'),
			'subscriberSession' => array(self::BELONGS_TO, 'SubscriberSession', 'subscriber_session_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subscriber_id' => 'Subscriber',
			'subscriber_session_id' => 'Subscriber Session',
			'action' => 'Action',
			'params' => 'Params',
			'server_ip' => 'Server Ip',
			'request_date' => 'Request Date',
			'client_ip' => 'Client Ip',
			'status' => 'Status',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('subscriber_session_id',$this->subscriber_session_id);
		$criteria->compare('action',$this->action);
		$criteria->compare('params',$this->params,true);
		$criteria->compare('server_ip',$this->server_ip,true);
		$criteria->compare('request_date',$this->request_date,true);
		$criteria->compare('client_ip',$this->client_ip,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getReport_tk_mobile_ads($startDate, $endDate, $partnerId){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
//		$sqlString = "select DATE_FORMAT(DATE(sal.request_date), '%Y/%m/%d') as report_date, ";
//			$sqlString .= "(select COUNT(DISTINCT(sal1.client_ip)) from subscriber_activity_log sal1 where sal1.action= ".ACTION_CLICK_MOBILE_ADS." and DATE(sal1.request_date) = DATE(sal.request_date)) As not_coincide_ip,";
//			$sqlString .= "(select COUNT(sal1.subscriber_id) from subscriber_activity_log sal1 where sal1.action= ".ACTION_CLICK_MOBILE_ADS." and sal1.subscriber_id is not null and DATE(sal1.request_date) = DATE(sal.request_date)) as count_subscriber,";
//			$sqlString .= "(select COUNT(DISTINCT(sal1.client_ip)) from subscriber_activity_log sal1 where sal1.action= ".ACTION_CLICK_MOBILE_ADS." and sal1.subscriber_id is not null and DATE(sal1.request_date) = DATE(sal.request_date)) as count_ip_not_coincide ";
//			$sqlString .= "From subscriber_activity_log sal where sal.request_date between '$startDate' and '$endDate' GROUP BY DATE(sal.request_date)";
		$sqlString = "SELECT ";
		$sqlString .="DATE_FORMAT(DATE(sal.request_date), '%Y/%m/%d') as report_date,";
		$sqlString .="COUNT(id) As total_click, ";
		$sqlString .="COUNT(DISTINCT(sal.client_ip)) As not_coincide_ip, ";
		$sqlString .="SUM(if(sal.subscriber_id is not null , 1, 0)) As count_subscriber,";
		$sqlString .="(SELECT COUNT(DISTINCT client_ip) FROM subscriber_activity_log where `subscriber_id` is not null AND DATE(request_date) = DATE(sal.request_date)) as count_ip_not_coincide ";
		$sqlString .="FROM subscriber_activity_log sal ";
		$sqlString .="WHERE (sal.request_date BETWEEN '$startDate' AND '$endDate') AND sal.action= ".ACTION_CLICK_MOBILE_ADS." AND sal.partner_id = $partnerId";
		$sqlString .=" GROUP BY DATE(sal.request_date)";
		$subAL = SubscriberActivityLog::model()->findAllBySql($sqlString, array());
		return $subAL;
	}
}