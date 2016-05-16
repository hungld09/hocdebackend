<?php

/**
 * This is the model class for table "subscriber_group_mapping".
 *
 * The followings are the available columns in table 'subscriber_group_mapping':
 * @property integer $id
 * @property integer $subscriber_id
 * @property integer $subscriber_group_id
 * @property string $description
 * @property string $create_date
 * @property string $create_user_id
 *
 * The followings are the available model relations:
 * @property AppUser $createUser
 * @property Subscriber $subscriber
 * @property SubscriberGroup $subscriberGroup
 */
class SubscriberGroupMapping extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberGroupMapping the static model class
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
		return 'subscriber_group_mapping';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id, subscriber_group_id', 'required'),
			array('subscriber_id, subscriber_group_id', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>255),
			array('create_user_id', 'length', 'max'=>11),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subscriber_id, subscriber_group_id, description, create_date, create_user_id', 'safe', 'on'=>'search'),
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
			'createUser' => array(self::BELONGS_TO, 'AppUser', 'create_user_id'),
			'subscriber' => array(self::BELONGS_TO, 'Subscriber', 'subscriber_id'),
			'subscriberGroup' => array(self::BELONGS_TO, 'SubscriberGroup', 'subscriber_group_id'),
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
			'subscriber_group_id' => 'Subscriber Group',
			'description' => 'Description',
			'create_date' => 'Create Date',
			'create_user_id' => 'Create User',
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
		$criteria->compare('subscriber_group_id',$this->subscriber_group_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}