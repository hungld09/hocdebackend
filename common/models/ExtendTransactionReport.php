<?php

/**
 * This is the model class for table "extend_transaction_report".
 *
 * The followings are the available columns in table 'extend_transaction_report':
 * @property integer $id
 * @property integer $service_id
 * @property integer $extend_type
 * @property integer $status
 * @property integer $subscriber_count
 * @property string $create_date
 */
class ExtendTransactionReport extends CActiveRecord
{
	const EXTEND_TYPE_CAN_GIA_HAN = 1;
	const EXTEND_TYPE_CAN_TRUY_THU = 2;
	const EXTEND_TYPE_GIA_HAN = 3;
	const EXTEND_TYPE_TRUY_THU = 4;
	
	const EXTEND_SUCCESSFULLY = 1;
	const EXTEND_FAILED = 0;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ExtendTransactionReport the static model class
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
		return 'extend_transaction_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, extend_type, status, subscriber_count', 'numerical', 'integerOnly'=>true),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, extend_type, status, subscriber_count, create_date', 'safe', 'on'=>'search'),
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
			'service_id' => 'Service',
			'extend_type' => 'Extend Type',
			'status' => 'Status',
			'subscriber_count' => 'Subscriber Count',
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
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('extend_type',$this->extend_type);
		$criteria->compare('status',$this->status);
		$criteria->compare('subscriber_count',$this->subscriber_count);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}