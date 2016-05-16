<?php

/**
 * This is the model class for table "service_subscriber_report".
 *
 * The followings are the available columns in table 'service_subscriber_report':
 * @property integer $id
 * @property integer $phim
 * @property integer $phim7
 * @property integer $phim30
 * @property integer $view
 * @property integer $download
 * @property integer $gift
 * @property string $create_date
 * @property integer $failed_extend_phim
 * @property integer $failed_extend_phim7
 * @property integer $failed_extend_phim30
 */
class ServiceSubscriberReport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServiceSubscriberReport the static model class
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
		return 'service_subscriber_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('phim, phim7, phim30, view, download, gift, failed_extend_phim, failed_extend_phim7, failed_extend_phim30', 'numerical', 'integerOnly'=>true),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, phim, phim7, phim30, view, download, gift, create_date, failed_extend_phim, failed_extend_phim7, failed_extend_phim30', 'safe', 'on'=>'search'),
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
			'phim' => 'Phim',
			'phim7' => 'Phim7',
			'phim30' => 'Phim30',
			'view' => 'View',
			'download' => 'Download',
			'gift' => 'Gift',
			'create_date' => 'Create Date',
			'failed_extend_phim' => 'Failed Extend Phim',
			'failed_extend_phim7' => 'Failed Extend Phim7',
			'failed_extend_phim30' => 'Failed Extend Phim30',
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
		$criteria->compare('phim',$this->phim);
		$criteria->compare('phim7',$this->phim7);
		$criteria->compare('phim30',$this->phim30);
		$criteria->compare('view',$this->view);
		$criteria->compare('download',$this->download);
		$criteria->compare('gift',$this->gift);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('failed_extend_phim',$this->failed_extend_phim);
		$criteria->compare('failed_extend_phim7',$this->failed_extend_phim7);
		$criteria->compare('failed_extend_phim30',$this->failed_extend_phim30);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public static function getReport_tb_dk_su_dung_dich_vu($startDate, $endDate){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$sqlString ="select * from service_subscriber_report where create_date between '$startDate' AND '$endDate' ";
		$serviceSubscriberReport = ServiceSubscriberReport::model()->findAllBySql($sqlString, array());
		return $serviceSubscriberReport;
	}
}