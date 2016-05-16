<?php

/**
 * This is the model class for table "subscriber_order".
 *
 * The followings are the available columns in table 'subscriber_order':
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
 * @property integer $transaction_id
 * @property integer $transaction_date
 *
 * The followings are the available model relations:
 * @property Service $service
 * @property Subscriber $subscriber
 * @property VodAsset $vodAsset
 * @property VodEpisode $vodEpisode
 */
class SubscriberOrder extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberOrder the static model class
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
		return 'subscriber_order';
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
			array('service_id, vod_asset_id, vod_episode_id, subscriber_id, status, using_type, purchase_type, transaction_id', 'numerical', 'integerOnly'=>true),
			array('cost', 'numerical'),
			array('service_number', 'length', 'max'=>45),
			array('description', 'length', 'max'=>200),
			array('channel_type, event_id', 'length', 'max'=>10),
			array('error_code', 'length', 'max'=>20),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, vod_asset_id, vod_episode_id, subscriber_id, create_date, status, service_number, description, cost, channel_type, event_id, using_type, purchase_type, error_code, transaction_id', 'safe', 'on'=>'search'),
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
			'vodAsset' => array(self::BELONGS_TO, 'VodAsset', 'vod_asset_id'),
			'vodEpisode' => array(self::BELONGS_TO, 'VodEpisode', 'vod_episode_id'),
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
			'service_number' => 'Service Number',
			'description' => 'Description',
			'cost' => 'Cost',
			'channel_type' => 'Channel Type',
			'event_id' => 'Event',
			'using_type' => 'Using Type',
			'purchase_type' => 'Purchase Type',
			'error_code' => 'Error Code',
			'transaction_id' => 'Transaction',
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
		$criteria->compare('service_number',$this->service_number,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('channel_type',$this->channel_type,true);
		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('using_type',$this->using_type);
		$criteria->compare('purchase_type',$this->purchase_type);
		$criteria->compare('error_code',$this->error_code,true);
		$criteria->compare('transaction_id',$this->transaction_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getMaxTransactionId() {
		$result = Yii::app()->db->createCommand()
		->selectDistinct('t.id')
		->from('subscriber_order as t')
		->limit(0, 1)
		->order('t.id DESC')
		->queryScalar();
		if (!$result) {
			$result = 1;
		}
		return $result;
	}
}