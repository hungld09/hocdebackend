<?php

/**
 * This is the model class for table "view_channel_type_report".
 *
 * The followings are the available columns in table 'view_channel_type_report':
 * @property integer $id
 * @property integer $subscriber_wap
 * @property integer $subscriber_app
 * @property integer $view_wap
 * @property integer $view_app
 * @property string $create_date
 */
class ViewChannelTypeReport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ViewChannelTypeReport the static model class
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
		return 'view_channel_type_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('create_date', 'required'),
			array('subscriber_wap, subscriber_app, view_wap, view_app', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subscriber_wap, subscriber_app, view_wap, view_app, create_date', 'safe', 'on'=>'search'),
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
			'subscriber_wap' => 'Subscriber Wap',
			'subscriber_app' => 'Subscriber App',
			'view_wap' => 'View Wap',
			'view_app' => 'View App',
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
		$criteria->compare('subscriber_wap',$this->subscriber_wap);
		$criteria->compare('subscriber_app',$this->subscriber_app);
		$criteria->compare('view_wap',$this->view_wap);
		$criteria->compare('view_app',$this->view_app);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}