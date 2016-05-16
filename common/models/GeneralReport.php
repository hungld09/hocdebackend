<?php

/**
 * This is the model class for table "general_report".
 *
 * The followings are the available columns in table 'general_report':
 * @property string $id
 * @property integer $service_id
 * @property integer $using_type
 * @property integer $register_success_count
 * @property integer $extend_success_count
 * @property integer $register_fail_count
 * @property integer $extend_fail_count
 * @property integer $pay_per_video_success_count
 * @property integer $pay_per_video_fail_count
 * @property integer $auto_cancel_count
 * @property string $report_date
 * @property integer $manual_cancel_count
 * @property integer $register_lack_money_count
 * @property integer $extend_lack_money_count
 * @property integer $pay_per_video_lack_money_count
 * @property integer $retry_extend_success_count
 * @property integer $retry_extend_failed_count
 */
class GeneralReport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GeneralReport the static model class
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
		return 'general_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, using_type', 'required'),
			array('service_id, using_type,view_vtv_count, register_success_count, register_success_count_free, register_success_count_notfree, extend_success_count, register_fail_count, extend_fail_count, pay_per_video_success_count, pay_per_video_fail_count, auto_cancel_count, manual_cancel_count, register_lack_money_count, extend_lack_money_count, pay_per_video_lack_money_count', 'numerical', 'integerOnly'=>true),
			array('report_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, service_id, using_type,view_vtv_count, register_success_count, register_success_count_free, register_success_count_notfree, extend_success_count, register_fail_count, extend_fail_count, pay_per_video_success_count, pay_per_video_fail_count, auto_cancel_count, report_date, manual_cancel_count, register_lack_money_count, extend_lack_money_count, pay_per_video_lack_money_count', 'safe', 'on'=>'search'),
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
			'using_type' => 'Using Type',
			'register_success_count' => 'Register Success Count',
			'extend_success_count' => 'Extend Success Count',
			'register_fail_count' => 'Register Fail Count',
			'extend_fail_count' => 'Extend Fail Count',
			'pay_per_video_success_count' => 'Pay Per Video Success Count',
			'pay_per_video_fail_count' => 'Pay Per Video Fail Count',
			'auto_cancel_count' => 'Auto Cancel Count',
			'report_date' => 'Report Date',
			'manual_cancel_count' => 'Manual Cancel Count',
			'register_lack_money_count' => 'Register Lack Money Count',
			'extend_lack_money_count' => 'Extend Lack Money Count',
			'pay_per_video_lack_money_count' => 'Pay Per Video Lack Money Count',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('using_type',$this->using_type);
		$criteria->compare('register_success_count',$this->register_success_count);
		$criteria->compare('extend_success_count',$this->extend_success_count);
		$criteria->compare('register_fail_count',$this->register_fail_count);
		$criteria->compare('extend_fail_count',$this->extend_fail_count);
		$criteria->compare('pay_per_video_success_count',$this->pay_per_video_success_count);
		$criteria->compare('pay_per_video_fail_count',$this->pay_per_video_fail_count);
		$criteria->compare('auto_cancel_count',$this->auto_cancel_count);
		$criteria->compare('report_date',$this->report_date,true);
		$criteria->compare('manual_cancel_count',$this->manual_cancel_count);
		$criteria->compare('register_lack_money_count',$this->register_lack_money_count);
		$criteria->compare('extend_lack_money_count',$this->extend_lack_money_count);
		$criteria->compare('pay_per_video_lack_money_count',$this->pay_per_video_lack_money_count);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getReport_tk_san_luong_dich_vu($startDate, $endDate){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$sqlString = "SELECT * FROM general_report WHERE report_date BETWEEN '$startDate' AND '$endDate'  ORDER BY report_date ASC, using_type ASC, service_id ASC";
		$generalReport = GeneralReport::model()->findAllBySql($sqlString, array());
		return $generalReport;
	}
}