<?php

/**
 * This is the model class for table "subscriber_notification_filter".
 *
 * The followings are the available columns in table 'subscriber_notification_filter':
 * @property integer $id
 * @property integer $subscriber_id
 * @property integer $notification_type_id
 * @property string $create_date
 * @property string $description
 *
 * The followings are the available model relations:
 * @property NotificationType $notificationType
 * @property Subscriber $subscriber
 */
class SubscriberNotificationFilter extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberNotificationFilter the static model class
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
		return 'subscriber_notification_filter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id, notification_type_id, create_date', 'required'),
			array('subscriber_id, notification_type_id', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subscriber_id, notification_type_id, create_date, description', 'safe', 'on'=>'search'),
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
			'notificationType' => array(self::BELONGS_TO, 'NotificationType', 'notification_type_id'),
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
			'subscriber_id' => 'Subscriber',
			'notification_type_id' => 'Notification Type',
			'create_date' => 'Create Date',
			'description' => 'Description',
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
		$criteria->compare('notification_type_id',$this->notification_type_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}