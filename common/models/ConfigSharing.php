<?php

/**
 * This is the model class for table "config_sharing".
 *
 * The followings are the available columns in table 'config_sharing':
 * @property integer $id
 * @property integer $service_id
 * @property double $config
 * @property double $config_b
 * @property double $config_k
 * @property double $config_h
 * @property double $config_g
 * @property double $config_f
 * @property double $config_e
 * @property double $config_d
 * @property double $config_c
 * @property string $start_date
 * @property string $end_date
 * @property string $description
 */
class ConfigSharing extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ConfigSharing the static model class
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
		return 'config_sharing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('start_date', 'required'),
			array('service_id', 'numerical', 'integerOnly'=>true),
			array('config_a, config_b, config_k, config_h, config_g, config_f, config_e, config_d, config_c', 'numerical'),
			array('description', 'length', 'max'=>500),
			array('end_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, config_a, config_b, config_k, config_h, config_g, config_f, config_e, config_d, config_c, start_date, end_date, description', 'safe', 'on'=>'search'),
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
			'config' => 'Config',
			'config_b' => 'Config B',
			'config_k' => 'Config K',
			'config_h' => 'Config H',
			'config_g' => 'Config G',
			'config_f' => 'Config F',
			'config_e' => 'Config E',
			'config_d' => 'Config D',
			'config_c' => 'Config C',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
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
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('config',$this->config);
		$criteria->compare('config_b',$this->config_b);
		$criteria->compare('config_k',$this->config_k);
		$criteria->compare('config_h',$this->config_h);
		$criteria->compare('config_g',$this->config_g);
		$criteria->compare('config_f',$this->config_f);
		$criteria->compare('config_e',$this->config_e);
		$criteria->compare('config_d',$this->config_d);
		$criteria->compare('config_c',$this->config_c);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}