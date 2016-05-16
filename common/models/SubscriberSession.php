<?php

/**
 * This is the model class for table "subscriber_session".
 *
 * The followings are the available columns in table 'subscriber_session':
 * @property integer $id
 * @property string $session_id
 * @property integer $subscriber_id
 * @property string $ip_address
 * @property string $create_time
 * @property string $expire_time
 * @property string $cookies
 * @property integer $status
 * @property string $device_type_id
 *
 * The followings are the available model relations:
 * @property SubscriberActivityLog[] $subscriberActivityLogs
 * @property Subscriber $subscriber
 */
class SubscriberSession extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberSession the static model class
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
		return 'subscriber_session';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('session_id, subscriber_id', 'required'),
			array('subscriber_id, status', 'numerical', 'integerOnly'=>true),
			array('session_id', 'length', 'max'=>100),
			array('ip_address, device_type_id', 'length', 'max'=>45),
			array('cookies', 'length', 'max'=>1000),
			array('create_time, expire_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, session_id, subscriber_id, ip_address, create_time, expire_time, cookies, status, device_type_id', 'safe', 'on'=>'search'),
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
			'subscriberActivityLogs' => array(self::HAS_MANY, 'SubscriberActivityLog', 'subscriber_session_id'),
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
			'session_id' => 'Session',
			'subscriber_id' => 'Subscriber',
			'ip_address' => 'Ip Address',
			'create_time' => 'Create Time',
			'expire_time' => 'Expire Time',
			'cookies' => 'Cookies',
			'status' => 'Status',
			'device_type_id' => 'Device Type',
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
		$criteria->compare('session_id',$this->session_id,true);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('expire_time',$this->expire_time,true);
		$criteria->compare('cookies',$this->cookies,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('device_type_id',$this->device_type_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function createNewSession($subscriber_id) {
		$session = new SubscriberSession();
		$session->create_time = new CDbExpression("NOW()");
		$session->expire_time = date('Y:m:d H:i:s', time() + 86400);
		$session->session_id = CUtils::randomString(32);
		$session->subscriber_id = $subscriber_id;
		$session->status = 1;
		$session->save();
		return $session;
	}
}