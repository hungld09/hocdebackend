<?php

/**
 * This is the model class for table "vod_rating".
 *
 * The followings are the available columns in table 'vod_rating':
 * @property integer $id
 * @property integer $rating
 * @property string $create_date
 * @property integer $vod_asset_id
 * @property integer $subscriber_id
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 * @property VodAsset $vodAsset
 */
class VodRating extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodRating the static model class
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
		return 'vod_rating';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rating, create_date, vod_asset_id, subscriber_id', 'required'),
			array('rating, vod_asset_id, subscriber_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, rating, create_date, vod_asset_id, subscriber_id', 'safe', 'on'=>'search'),
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
			'subscriber' => array(self::BELONGS_TO, 'Subscriber', 'subscriber_id'),
			'vodAsset' => array(self::BELONGS_TO, 'VodAsset', 'vod_asset_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rating' => 'Rating',
			'create_date' => 'Create Date',
			'vod_asset_id' => 'Vod Asset',
			'subscriber_id' => 'Subscriber',
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
		$criteria->compare('rating',$this->rating);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('vod_asset_id',$this->vod_asset_id);
		$criteria->compare('subscriber_id',$this->subscriber_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}