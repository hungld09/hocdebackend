<?php

/**
 * This is the model class for table "service_subscriber_mapping".
 *
 * The followings are the available columns in table 'service_subscriber_mapping':
 * @property string $id
 * @property integer $service_id
 * @property integer $subscriber_id
 * @property string $description
 * @property string $activate_date
 * @property string $expiry_date
 * @property integer $is_active
 * @property string $create_date
 * @property string $modify_date
 * @property integer $is_deleted
 * @property string $pending_date
 * @property integer $view_count
 * @property integer $download_count
 * @property integer $gift_count
 * @property integer $sent_notification
 * @property integer $recur_retry_times
 * @property integer $partner_id
 * @property string $product_order_key
 * @property integer $watching_time
 *
 * The followings are the available model relations:
 * @property AppUser $createUser
 * @property AppUser $modifyUser
 * @property AppUser $deleteUser
 * @property Service $service
 * @property Subscriber $subscriber
 */
class ServiceSubscriberMapping extends CActiveRecord
{
	const SERVICE_STATUS_INACTIVE = 0;
	const SERVICE_STATUS_ACTIVE = 1;
	const SERVICE_STATUS_PENDING = 2;
	const SERVICE_STATUS_EXTEND_PENDING = 3;
	
	public $report_date;
	public $count_register;
	public $count_cancel_after_one_cycle;
	public $count_recur_three_cycle_success;
	public $count_recur_failed;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServiceSubscriberMapping the static model class
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
		return 'service_subscriber_mapping';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, subscriber_id, activate_date, expiry_date, create_date', 'required'),
			array('service_id, subscriber_id, is_active, is_deleted, view_count, download_count, gift_count, sent_notification, recur_retry_times', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>1000),
			array('modify_date, pending_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, subscriber_id, description, activate_date, expiry_date, is_active, create_date, modify_date, is_deleted, pending_date, view_count, download_count, gift_count,partner_id, sent_notification, recur_retry_times', 'safe', 'on'=>'search'),
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
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
			'subscriber' => array(self::BELONGS_TO, 'Subscriber', 'subscriber_id'),
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
			'subscriber_id' => 'Subscriber',
			'description' => 'Description',
			'activate_date' => 'Activate Date',
			'expiry_date' => 'Expiry Date',
			'is_active' => 'Is Active',
			'create_date' => 'Create Date',
			'modify_date' => 'Modify Date',
			'is_deleted' => 'Is Deleted',
			'pending_date' => 'Pending Date',
			'view_count' => 'View Count',
			'download_count' => 'Download Count',
			'gift_count' => 'Gift Count',
			'sent_notification' => 'Sent Notification',
			'recur_retry_times' => 'Recur Retry Times',
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
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('activate_date',$this->activate_date,true);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('modify_date',$this->modify_date,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('pending_date',$this->pending_date,true);
		$criteria->compare('view_count',$this->view_count);
		$criteria->compare('download_count',$this->download_count);
		$criteria->compare('gift_count',$this->gift_count);
		$criteria->compare('sent_notification',$this->sent_notification);
		$criteria->compare('recur_retry_times',$this->recur_retry_times);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function isExpired() {
		/*$expiry_date = DateTime::createFromFormat("Y-m-d H:i:s", $this->expiry_date);
		$today = new DateTime();
		if (!isset($expiry_date) || $expiry_date < $today) {
			return TRUE;
		} else {
			return FALSE;
		}
		*/
		return FALSE;
	}
	
	public static function getReport_tk_mobile_ads_register($startDate, $endDate, $partnerId){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$sqlString = "select DATE_FORMAT(DATE(ssm.create_date), '%Y/%m/%d') as report_date, ";
		$sqlString .= "(select COUNT(subscriber_id) from service_subscriber_mapping ssm1 where ssm1.service_id is not null AND 
		ssm1.partner_id = '$partnerId' AND DATE(ssm1.create_date) = DATE(ssm.create_date)) As count_register ";
		$sqlString .= "From service_subscriber_mapping ssm where ssm.create_date between '$startDate' and '$endDate' GROUP BY DATE(ssm.create_date)";
		$subAL = ServiceSubscriberMapping::model()->findAllBySql($sqlString, array());
		return $subAL;
	}
	public static function getReport_tk_mobile_ads_cycle($startDate, $endDate, $partnerId){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$sqlString = "select DATE_FORMAT(DATE(ssm.modify_date), '%Y/%m/%d') as report_date, ";
		$sqlString .= "(select COUNT(subscriber_id) from service_subscriber_mapping ssm1 where ssm1.service_id is not null AND is_active = 0 AND 
		ssm1.partner_id = '$partnerId' AND ADDDATE(DATE(ssm1.create_date),7 ) >= DATE(ssm1.modify_date) AND DATE(ssm1.modify_date) = DATE(ssm.modify_date)) As count_cancel_after_one_cycle, ";
		$sqlString .= "(select SUM(recur_retry_times) from service_subscriber_mapping ssm1 where ssm1.service_id is not null AND is_active = 1 AND recur_retry_times > 0 AND 
		ssm1.partner_id = '$partnerId' AND DATE(ssm1.modify_date) = DATE(ssm.modify_date)) As count_recur_failed ";
		$sqlString .= "From service_subscriber_mapping ssm where ssm.modify_date between '$startDate' and '$endDate' GROUP BY DATE(ssm.modify_date)";
		$subAL = ServiceSubscriberMapping::model()->findAllBySql($sqlString, array());
		return $subAL;
	}
}
