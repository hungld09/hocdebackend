<?php

/**
 * This is the model class for table "vod_like_dislike".
 *
 * The followings are the available columns in table 'vod_like_dislike':
 * @property integer $id
 * @property integer $like
 * @property integer $vod_asset_id
 * @property integer $subscriber_id
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 * @property VodAsset $vodAsset
 */
class VodLikeDislike extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodLikeDislike the static model class
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
		return 'vod_like_dislike';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('like, vod_asset_id, subscriber_id, create_date', 'required'),
			array('like, vod_asset_id, subscriber_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, like, vod_asset_id, subscriber_id, create_date', 'safe', 'on'=>'search'),
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
			'like' => 'Like',
			'vod_asset_id' => 'Vod Asset',
			'subscriber_id' => 'Subscriber',
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
		$criteria->compare('like',$this->like);
		$criteria->compare('vod_asset_id',$this->vod_asset_id);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}