<?php

/**
 * This is the model class for table "access_tracking_report".
 *
 * The followings are the available columns in table 'access_tracking_report':
 * @property integer $id
 * @property integer $access_count_of_registered_sub
 * @property integer $access_count_of_not_registered_sub
 * @property integer $access_registered_sub_count
 * @property integer $access_not_registered_sub_count
 * @property integer $free_watch_count_of_retroactive_sub
 * @property integer $free_watch_retroactive_sub_count
 * @property integer $free_watch_count_of_registered_sub
 * @property integer $free_watch_registered_sub_count
 * @property integer $free_watch_count_of_not_registered_sub
 * @property integer $free_watch_not_registered_sub_count
 * @property integer $charging_watch_count
 * @property integer $charging_watch_sub_count
 * @property string $create_date
 */
class AccessTrackingReport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AccessTrackingReport the static model class
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
		return 'access_tracking_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('access_count_of_registered_sub, access_count_of_not_registered_sub, access_registered_sub_count, access_not_registered_sub_count, free_watch_count_of_retroactive_sub, free_watch_retroactive_sub_count, free_watch_count_of_registered_sub, free_watch_registered_sub_count, free_watch_count_of_not_registered_sub, free_watch_not_registered_sub_count, charging_watch_count, charging_watch_sub_count', 'numerical', 'integerOnly'=>true),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, access_count_of_registered_sub, access_count_of_not_registered_sub, access_registered_sub_count, access_not_registered_sub_count, free_watch_count_of_retroactive_sub, free_watch_retroactive_sub_count, free_watch_count_of_registered_sub, free_watch_registered_sub_count, free_watch_count_of_not_registered_sub, free_watch_not_registered_sub_count, charging_watch_count, charging_watch_sub_count, create_date', 'safe', 'on'=>'search'),
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
			'access_count_of_registered_sub' => 'Access Count Of Registered Sub',
			'access_count_of_not_registered_sub' => 'Access Count Of Not Registered Sub',
			'access_registered_sub_count' => 'Access Registered Sub Count',
			'access_not_registered_sub_count' => 'Access Not Registered Sub Count',
			'free_watch_count_of_retroactive_sub' => 'Free Watch Count Of Retroactive Sub',
			'free_watch_retroactive_sub_count' => 'Free Watch Retroactive Sub Count',
			'free_watch_count_of_registered_sub' => 'Free Watch Count Of Registered Sub',
			'free_watch_registered_sub_count' => 'Free Watch Registered Sub Count',
			'free_watch_count_of_not_registered_sub' => 'Free Watch Count Of Not Registered Sub',
			'free_watch_not_registered_sub_count' => 'Free Watch Not Registered Sub Count',
			'charging_watch_count' => 'Charging Watch Count',
			'charging_watch_sub_count' => 'Charging Watch Sub Count',
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
		$criteria->compare('access_count_of_registered_sub',$this->access_count_of_registered_sub);
		$criteria->compare('access_count_of_not_registered_sub',$this->access_count_of_not_registered_sub);
		$criteria->compare('access_registered_sub_count',$this->access_registered_sub_count);
		$criteria->compare('access_not_registered_sub_count',$this->access_not_registered_sub_count);
		$criteria->compare('free_watch_count_of_retroactive_sub',$this->free_watch_count_of_retroactive_sub);
		$criteria->compare('free_watch_retroactive_sub_count',$this->free_watch_retroactive_sub_count);
		$criteria->compare('free_watch_count_of_registered_sub',$this->free_watch_count_of_registered_sub);
		$criteria->compare('free_watch_registered_sub_count',$this->free_watch_registered_sub_count);
		$criteria->compare('free_watch_count_of_not_registered_sub',$this->free_watch_count_of_not_registered_sub);
		$criteria->compare('free_watch_not_registered_sub_count',$this->free_watch_not_registered_sub_count);
		$criteria->compare('charging_watch_count',$this->charging_watch_count);
		$criteria->compare('charging_watch_sub_count',$this->charging_watch_sub_count);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}