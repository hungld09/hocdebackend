<?php

/**
 * This is the model class for table "ads_report".
 *
 * The followings are the available columns in table 'ads_report':
 * @property integer $id
 * @property string $create_date
 * @property integer $not_coincide_ip
 * @property integer $identify
 * @property integer $identify_not_coincide_ip
 * @property integer $register_success
 * @property integer $cancel_after_one_cycle
 * @property integer $recur_after_three_cycle
 * @property integer $recur_failed
 * @property integer $recur_success
 * @property double $revenue
 * @property integer $partner_id
 */
class AdsReport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AdsReport the static model class
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
		return 'ads_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('not_coincide_ip, identify, identify_not_coincide_ip, register_success, cancel_after_one_cycle, recur_after_three_cycle, recur_failed, recur_success, partner_id, register_success_free, register_success_notfree, cumulative_subscribers, cumulative_subscribers_real, total_cancel', 'numerical', 'integerOnly'=>true),
			array('revenue', 'numerical'),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, create_date, not_coincide_ip, identify, identify_not_coincide_ip, register_success, cancel_after_one_cycle, recur_after_three_cycle, recur_failed, recur_success, revenue, partner_id, register_success_free, register_success_notfree, cumulative_subscribers, cumulative_subscribers_real, total_cancel', 'safe', 'on'=>'search'),
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
			'not_coincide_ip' => 'Not Coincide Ip',
			'identify' => 'Identify',
			'identify_not_coincide_ip' => 'Identify Not Coincide Ip',
			'register_success' => 'Register Success',
			'cancel_after_one_cycle' => 'Cancel After One Cycle',
			'recur_after_three_cycle' => 'Recur After Three Cycle',
			'recur_failed' => 'Recur Failed',
			'recur_success' => 'Recur Success',
			'revenue' => 'Revenue Register',
			'partner_id' => 'Partner',
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
		$criteria->compare('not_coincide_ip',$this->not_coincide_ip);
		$criteria->compare('identify',$this->identify);
		$criteria->compare('identify_not_coincide_ip',$this->identify_not_coincide_ip);
		$criteria->compare('register_success',$this->register_success);
		$criteria->compare('cancel_after_one_cycle',$this->cancel_after_one_cycle);
		$criteria->compare('recur_after_three_cycle',$this->recur_after_three_cycle);
		$criteria->compare('recur_failed',$this->recur_failed);
		$criteria->compare('recur_success',$this->recur_success);
		$criteria->compare('revenue',$this->revenue);
		$criteria->compare('partner_id',$this->partner_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getReport_tk_mobile_ads($startDate, $endDate, $partnerId){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$sqlString = "select * from ads_report where partner_id = '$partnerId' AND create_date between '$startDate' and '$endDate'";
		$adsReport = AdsReport::model()->findAllBySql($sqlString, array());
		return $adsReport;
	}
}