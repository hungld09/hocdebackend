<?php

/**
 * This is the model class for table "new_subscriber_report".
 *
 * The followings are the available columns in table 'new_subscriber_report':
 * @property integer $id
 * @property string $create_date
 * @property integer $service_id
 * @property integer $register_wap
 * @property integer $register_sms
 * @property integer $register_app
 * @property integer $register_web
 * @property integer $register_km
 */
class NewSubscriberReport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return NewSubscriberReport the static model class
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
		return 'new_subscriber_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, register_wap, register_sms, register_app, register_web, register_km', 'numerical', 'integerOnly'=>true),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, create_date, service_id, register_wap, register_sms, register_app, register_web, register_km', 'safe', 'on'=>'search'),
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
			'create_date' => 'Create Date',
			'service_id' => 'Service',
			'register_wap' => 'Register Wap',
			'register_sms' => 'Register Sms',
			'register_app' => 'Register App',
			'register_web' => 'Register Web',
			'register_km' => 'Register Km',
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
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('register_wap',$this->register_wap);
		$criteria->compare('register_sms',$this->register_sms);
		$criteria->compare('register_app',$this->register_app);
		$criteria->compare('register_web',$this->register_web);
		$criteria->compare('register_km',$this->register_km);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getReport_tk_tong_dk_moi($startDate, $endDate){
		$sqlString = "select * from new_subscriber_report where create_date between '$startDate' and '$endDate'";
		$newSubscriberReport = NewSubscriberReport::model()->findAllBySql($sqlString, array());
		return $newSubscriberReport;
	}
}