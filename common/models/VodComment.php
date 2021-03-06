<?php

/**
 * This is the model class for table "vod_comment".
 *
 * The followings are the available columns in table 'vod_comment':
 * @property integer $id
 * @property string $title
 * @property string $comment
 * @property integer $vod_asset_id
 * @property integer $subscriber_id
 * @property string $create_date
 * @property integer $status
 * @property string $comment_note
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 * @property VodAsset $vodAsset
 */
class VodComment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodComment the static model class
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
		return 'vod_comment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comment, vod_asset_id, subscriber_id, create_date', 'required'),
			array('vod_asset_id, subscriber_id, status', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>100),
			array('comment_note', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, comment, vod_asset_id, subscriber_id, create_date, status, comment_note', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'comment' => 'Comment',
			'vod_asset_id' => 'Vod Asset',
			'subscriber_id' => 'Subscriber',
			'create_date' => 'Create Date',
			'status' => 'Status',
			'comment_note' => 'Comment Note',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('vod_asset_id',$this->vod_asset_id);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('comment_note',$this->comment_note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}