<?php

/**
 * This is the model class for table "subscriber_request".
 *
 * The followings are the available columns in table 'subscriber_request':
 * @property string $id
 * @property integer $service_id
 * @property integer $vod_asset_id
 * @property integer $vod_episode_id
 * @property integer $subscriber_id
 * @property string $create_date
 * @property integer $status
 * @property integer $vnp_status
 * @property string $service_number
 * @property string $description
 * @property double $cost
 * @property string $channel_type
 * @property string $event_id
 * @property integer $using_type
 * @property integer $purchase_type
 * @property string $error_code
 * @property string $transaction_id
 * @property integer $transaction_date
 */
class SubscriberRequest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberRequest the static model class
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
		return 'subscriber_request';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id, status, error_code', 'required'),
			array('service_id, vod_asset_id, vod_episode_id, subscriber_id, status, vnp_status, using_type, purchase_type, transaction_date', 'numerical', 'integerOnly'=>true),
			array('cost', 'numerical'),
			array('service_number', 'length', 'max'=>45),
			array('description', 'length', 'max'=>200),
			array('channel_type, event_id', 'length', 'max'=>10),
			array('error_code', 'length', 'max'=>20),
			array('transaction_id', 'length', 'max'=>50),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, vod_asset_id, vod_episode_id, subscriber_id, create_date, status, vnp_status, service_number, description, cost, channel_type, event_id, using_type, purchase_type, error_code, transaction_id, transaction_date', 'safe', 'on'=>'search'),
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
			'vod_asset_id' => 'Vod Asset',
			'vod_episode_id' => 'Vod Episode',
			'subscriber_id' => 'Subscriber',
			'create_date' => 'Create Date',
			'status' => 'Status',
			'vnp_status' => 'Vnp Status',
			'service_number' => 'Service Number',
			'description' => 'Description',
			'cost' => 'Cost',
			'channel_type' => 'Channel Type',
			'event_id' => 'Event',
			'using_type' => 'Using Type',
			'purchase_type' => 'Purchase Type',
			'error_code' => 'Error Code',
			'transaction_id' => 'Transaction',
			'transaction_date' => 'Transaction Date',
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
		$criteria->compare('vod_asset_id',$this->vod_asset_id);
		$criteria->compare('vod_episode_id',$this->vod_episode_id);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('vnp_status',$this->vnp_status);
		$criteria->compare('service_number',$this->service_number,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('channel_type',$this->channel_type,true);
		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('using_type',$this->using_type);
		$criteria->compare('purchase_type',$this->purchase_type);
		$criteria->compare('error_code',$this->error_code,true);
		$criteria->compare('transaction_id',$this->transaction_id,true);
		$criteria->compare('transaction_date',$this->transaction_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}