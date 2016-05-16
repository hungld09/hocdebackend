<?php

/**
 * This is the model class for table "download_token".
 *
 * The followings are the available columns in table 'download_token':
 * @property string $id
 * @property integer $vod_asset_id
 * @property integer $vod_episode_id
 * @property integer $subscriber_id
 * @property string $create_date
 * @property string $token
 *
 * The followings are the available model relations:
 * @property VodAsset $vodAsset
 * @property VodEpisode $vodEpisode
 * @property Subscriber $subscriber
 */
class DownloadToken extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DownloadToken the static model class
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
		return 'download_token';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id', 'required'),
			array('vod_asset_id, vod_episode_id, subscriber_id', 'numerical', 'integerOnly'=>true),
			array('token', 'length', 'max'=>45),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vod_asset_id, vod_episode_id, subscriber_id, create_date, token', 'safe', 'on'=>'search'),
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
			'vodAsset' => array(self::BELONGS_TO, 'VodAsset', 'vod_asset_id'),
			'vodEpisode' => array(self::BELONGS_TO, 'VodEpisode', 'vod_episode_id'),
			'subscriber' => array(self::BELONGS_TO, 'Subscriber', 'subscriber_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vod_asset_id' => 'Vod Asset',
			'vod_episode_id' => 'Vod Episode',
			'subscriber_id' => 'Subscriber',
			'create_date' => 'Create Date',
			'token' => 'Token',
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
		$criteria->compare('vod_asset_id',$this->vod_asset_id);
		$criteria->compare('vod_episode_id',$this->vod_episode_id);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('token',$this->token,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}