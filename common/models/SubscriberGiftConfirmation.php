<?php

/**
 * This is the model class for table "subscriber_gift_confirmation".
 *
 * The followings are the available columns in table 'subscriber_gift_confirmation':
 * @property integer $id
 * @property integer $subscriber_id
 * @property integer $receiver_id
 * @property integer $service_id
 * @property string $confirmation_code
 * @property string $create_date
 * @property string $note
 * @property string $expiration_date
 *
 * The followings are the available model relations:
 * @property Subscriber $receiver
 * @property Subscriber $subscriber
 * @property Service $service
 */
class SubscriberGiftConfirmation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberGiftConfirmation the static model class
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
		return 'subscriber_gift_confirmation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
				array('subscriber_id, receiver_id, service_id', 'numerical', 'integerOnly'=>true),
				array('confirmation_code', 'length', 'max'=>10),
				array('note', 'length', 'max'=>100),
				array('create_date, expiration_date', 'safe'),
				// The following rule is used by search().
				// Please remove those attributes that should not be searched.
				array('id, subscriber_id, receiver_id, service_id, confirmation_code, create_date, note, expiration_date', 'safe', 'on'=>'search'),
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
				'receiver' => array(self::BELONGS_TO, 'Subscriber', 'receiver_id'),
				'subscriber' => array(self::BELONGS_TO, 'Subscriber', 'subscriber_id'),
				'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
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
				'receiver_id' => 'Receiver',
				'service_id' => 'Service',
				'confirmation_code' => 'Confirmation Code',
				'create_date' => 'Create Date',
				'note' => 'Note',
				'expiration_date' => 'Expiration Date',
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
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('receiver_id',$this->receiver_id);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('confirmation_code',$this->confirmation_code,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('expiration_date',$this->expiration_date,true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	public static function newGiftConfirm($subscriber, $receiver, $service) {
		$giftConfirm = new SubscriberGiftConfirmation();
		$giftConfirm->subscriber_id = $subscriber->id;
		$giftConfirm->receiver_id = $receiver->id;
		$giftConfirm->confirmation_code = CUtils::randomString(4, "0123456789");
		$giftConfirm->service_id = $service->id;
		$giftConfirm->expiration_date = date("Y:m:d H:i:s", time() + 86400); //co hieu luc trong 1 ngay
		$giftConfirm->create_date = new CDbExpression("NOW()");
		if(!$giftConfirm->save()) {
			return NULL;
		}
		return $giftConfirm;
	}
	
}