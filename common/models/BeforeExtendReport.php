<?php

/**
 * This is the model class for table "before_extend_report".
 *
 * The followings are the available columns in table 'before_extend_report':
 * @property integer $id
 * @property string $create_date
 * @property integer $can_gia_han_phim
 * @property integer $can_gia_han_phim7
 * @property integer $can_gia_han_phim30
 * @property integer $can_truy_thu
 * @property integer $can_truy_thu7
 * @property integer $can_truy_thu30
 */
class BeforeExtendReport extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BeforeExtendReport the static model class
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
		return 'before_extend_report';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('can_gia_han_phim, can_gia_han_phim7, can_gia_han_phim30, can_truy_thu, can_truy_thu7, can_truy_thu30', 'numerical', 'integerOnly'=>true),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, create_date, can_gia_han_phim, can_gia_han_phim7, can_gia_han_phim30, can_truy_thu, can_truy_thu7, can_truy_thu30', 'safe', 'on'=>'search'),
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
			'create_date' => 'Create Time',
			'can_gia_han_phim' => 'Can Gia Han Phim',
			'can_gia_han_phim7' => 'Can Gia Han Phim7',
			'can_gia_han_phim30' => 'Can Gia Han Phim30',
			'can_truy_thu' => 'Can Truy Thu',
			'can_truy_thu7' => 'Can Truy Thu7',
			'can_truy_thu30' => 'Can Truy Thu30',
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
		$criteria->compare('can_gia_han_phim',$this->can_gia_han_phim);
		$criteria->compare('can_gia_han_phim7',$this->can_gia_han_phim7);
		$criteria->compare('can_gia_han_phim30',$this->can_gia_han_phim30);
		$criteria->compare('can_truy_thu',$this->can_truy_thu);
		$criteria->compare('can_truy_thu7',$this->can_truy_thu7);
		$criteria->compare('can_truy_thu30',$this->can_truy_thu30);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}