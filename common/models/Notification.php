<?php

/**
 * This is the model class for table "notification".
 *
 * The followings are the available columns in table 'notification':
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property integer $notification_type_id
 * @property integer $serverity
 * @property string $create_date
 * @property string $description
 * @property string $url
 * @property integer $status
 * @property string $expiry_date
 *
 * The followings are the available model relations:
 * @property NotificationType $notificationType
 * @property SubscriberNotificationInbox[] $subscriberNotificationInboxes
 */
class Notification extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Notification the static model class
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
		return 'notification';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('content, notification_type_id', 'required'),
			array('notification_type_id, serverity, status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('url', 'length', 'max'=>500),
			array('create_date, description, expiry_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, content, notification_type_id, serverity, create_date, description, url, status, expiry_date', 'safe', 'on'=>'search'),
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
			'subscriberNotificationInboxes' => array(self::HAS_MANY, 'SubscriberNotificationInbox', 'notification_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'content' => 'Content',
			'notification_type_id' => 'Notification Type',
			'serverity' => 'Serverity',
			'create_date' => 'Create Date',
			'description' => 'Description',
			'url' => 'Url',
			'status' => 'Status',
			'expiry_date' => 'Expiry Date',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('notification_type_id',$this->notification_type_id);
		$criteria->compare('serverity',$this->serverity);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('expiry_date',$this->expiry_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}