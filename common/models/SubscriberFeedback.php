<?php

/**
 * This is the model class for table "subscriber_feedback".
 *
 * The followings are the available columns in table 'subscriber_feedback':
 * @property integer $id
 * @property integer $subscriber_id
 * @property string $content
 * @property string $title
 * @property string $create_date
 * @property integer $status
 * @property string $status_log
 * @property integer $is_responsed
 * @property string $response_date
 * @property string $response_user_id
 * @property string $response_detail
 *
 * The followings are the available model relations:
 * @property AppUser $responseUser
 * @property Subscriber $subscriber
 */
class SubscriberFeedback extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberFeedback the static model class
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
		return 'subscriber_feedback';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id, content, status', 'required'),
			array('subscriber_id, status, is_responsed', 'numerical', 'integerOnly'=>true),
			array('content, response_detail', 'length', 'max'=>5000),
			array('title', 'length', 'max'=>500),
			array('response_user_id', 'length', 'max'=>11),
			array('create_date, status_log, response_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subscriber_id, content, title, create_date, status, status_log, is_responsed, response_date, response_user_id, response_detail', 'safe', 'on'=>'search'),
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
			'responseUser' => array(self::BELONGS_TO, 'AppUser', 'response_user_id'),
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
			'subscriber_id' => 'Số điện thoại',
			'content' => 'Nội dung',
			'title' => 'Tiêu đề',
			'create_date' => 'Ngày',
			'status' => 'Status',
			'status_log' => 'Status Log',
			'is_responsed' => 'Is Responsed',
			'response_date' => 'Response Date',
			'response_user_id' => 'Response User',
			'response_detail' => 'Response Detail',
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
		$criteria->compare('content',$this->content,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('status_log',$this->status_log,true);
		$criteria->compare('is_responsed',$this->is_responsed);
		$criteria->compare('response_date',$this->response_date,true);
		$criteria->compare('response_user_id',$this->response_user_id,true);
		$criteria->compare('response_detail',$this->response_detail,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getListFeedBack() {
		$criteria=new CDbCriteria;
        $criteria->addCondition('subscriber_id IS NOT NULL');
		$criteria->order = 'create_date DESC';
		$model = new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	
		return $model;
	}
}