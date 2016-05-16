<?php

/**
 * This is the model class for table "subscriber_user_action_log".
 *
 * The followings are the available columns in table 'subscriber_user_action_log':
 * @property integer $id
 * @property string $user_id
 * @property integer $subscriber_id
 * @property integer $action
 * @property integer $status
 * @property string $request_date
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 * @property AppUser $user
 */
class SubscriberUserActionLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberUserActionLog the static model class
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
		return 'subscriber_user_action_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, subscriber_id, action, status, request_date', 'required'),
			array('subscriber_id, action, status', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, subscriber_id, action, status, request_date', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'AppUser', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'subscriber_id' => 'Subscriber',
			'action' => 'Action',
			'status' => 'Status',
			'request_date' => 'Request Date',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('action',$this->action);
		$criteria->compare('status',$this->status);
		$criteria->compare('request_date',$this->request_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}