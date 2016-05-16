<?php

/**
 * This is the model class for table "charging_report".
 *
 * The followings are the available columns in table 'charging_report':
 * @property integer $id
 * @property integer $charging_success
 * @property integer $charging_failed
 * @property string $create_date
 * @property integer $vms_charging_success
 * @property integer $vms_charging_failed
 */
class ChargingReport extends CActiveRecord
{
	public $total_charging_success;
	public $total_charging_failed;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChargingReport the static model class
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
		return 'charging_report';
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
			array('charging_success, charging_failed, vms_charging_success, vms_charging_failed', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, charging_success, charging_failed, create_date, vms_charging_success, vms_charging_failed', 'safe', 'on'=>'search'),
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
			'charging_success' => 'Charging Success',
			'charging_failed' => 'Charging Failed',
			'create_date' => 'Create Date',
			'vms_charging_success' => 'Vms Charging Success',
			'vms_charging_failed' => 'Vms Charging Failed',
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
		$criteria->compare('charging_success',$this->charging_success);
		$criteria->compare('charging_failed',$this->charging_failed);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('vms_charging_success',$this->vms_charging_success);
		$criteria->compare('vms_charging_failed',$this->vms_charging_failed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getReport_tk_ti_le_tru_tien($startDate, $endDate){
		$sqlString = "select";
		$sqlString .= " (select SUM(charging_success) from charging_report where create_date between '$startDate' and '$endDate') as total_charging_success, ";
		$sqlString .= "(select SUM(charging_failed) from charging_report where create_date between '$startDate' and '$endDate') as total_charging_failed ";
		$sqlString .= "from charging_report";
		$chargingReport = ChargingReport::model()->findBySql($sqlString, array());
		if($chargingReport != null){
			$chargingReport->total_charging_success = ($chargingReport->total_charging_success==null?0:$chargingReport->total_charging_success);
			$chargingReport->total_charging_failed = ($chargingReport->total_charging_failed==null?0:$chargingReport->total_charging_failed);
		}
		return $chargingReport;
	}
}