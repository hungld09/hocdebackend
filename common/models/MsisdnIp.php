<?php

/**
 * This is the model class for table "msisdn_ip".
 *
 * The followings are the available columns in table 'msisdn_ip':
 * @property string $id
 * @property string $request_time
 * @property string $msisdn
 * @property string $ip
 * @property integer $subscriber_id
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 */
class MsisdnIp extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MsisdnIp the static model class
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
		return 'msisdn_ip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id', 'numerical', 'integerOnly'=>true),
			array('msisdn, ip', 'length', 'max'=>30),
			array('request_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, request_time, msisdn, ip, subscriber_id', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'request_time' => 'Request Time',
			'msisdn' => 'Msisdn',
			'ip' => 'Ip',
			'subscriber_id' => 'Subscriber',
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
		$criteria->compare('request_time',$this->request_time,true);
		$criteria->compare('msisdn',$this->msisdn,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('subscriber_id',$this->subscriber_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}