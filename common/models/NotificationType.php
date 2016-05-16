<?php

/**
 * This is the model class for table "notification_type".
 *
 * The followings are the available columns in table 'notification_type':
 * @property integer $id
 * @property string $code_name
 * @property string $display_name
 * @property integer $allow_filter
 * @property integer $status
 * @property string $description
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Notification[] $notifications
 * @property SubscriberNotificationFilter[] $subscriberNotificationFilters
 * @property SubscriberNotificationInbox[] $subscriberNotificationInboxes
 */
class NotificationType extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NotificationType the static model class
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
		return 'notification_type';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code_name, display_name, status', 'required'),
			array('allow_filter, status', 'numerical', 'integerOnly'=>true),
			array('code_name, display_name, description', 'length', 'max'=>255),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code_name, display_name, allow_filter, status, description, create_date', 'safe', 'on'=>'search'),
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
			'notifications' => array(self::HAS_MANY, 'Notification', 'notification_type_id'),
			'subscriberNotificationFilters' => array(self::HAS_MANY, 'SubscriberNotificationFilter', 'notification_type_id'),
			'subscriberNotificationInboxes' => array(self::HAS_MANY, 'SubscriberNotificationInbox', 'notification_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code_name' => 'Code Name',
			'display_name' => 'Display Name',
			'allow_filter' => 'Allow Filter',
			'status' => 'Status',
			'description' => 'Description',
			'create_date' => 'Create Date',
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
		$criteria->compare('code_name',$this->code_name,true);
		$criteria->compare('display_name',$this->display_name,true);
		$criteria->compare('allow_filter',$this->allow_filter);
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}