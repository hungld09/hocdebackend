<?php

/**
 * This is the model class for table "vod_subscriber_mapping".
 *
 * The followings are the available columns in table 'vod_subscriber_mapping':
 * @property string $id
 * @property integer $vod_episode_id
 * @property integer $vod_asset_id
 * @property integer $subscriber_id
 * @property string $description
 * @property string $activate_date
 * @property string $expiry_date
 * @property integer $is_active
 * @property string $create_date
 * @property string $modify_date
 * @property integer $is_deleted
 * @property string $delete_date
 * @property string $create_user_id
 * @property string $modify_user_id
 * @property string $delete_user_id
 * @property integer $using_type
 *
 * The followings are the available model relations:
 * @property AppUser $createUser
 * @property AppUser $modifyUser
 * @property AppUser $deleteUser
 * @property Subscriber $subscriber
 * @property VodAsset $vodAsset
 * @property VodEpisode $vodEpisode
 */
class VodSubscriberMapping extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodSubscriberMapping the static model class
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
		return 'vod_subscriber_mapping';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id, activate_date, expiry_date, create_date', 'required'),
			array('vod_episode_id, vod_asset_id, subscriber_id, is_active, is_deleted, using_type', 'numerical', 'integerOnly'=>true),
			array('description', 'length', 'max'=>1000),
			array('create_user_id, modify_user_id, delete_user_id', 'length', 'max'=>11),
			array('modify_date, delete_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vod_episode_id, vod_asset_id, subscriber_id, description, activate_date, expiry_date, is_active, create_date, modify_date, is_deleted, delete_date, create_user_id, modify_user_id, delete_user_id, using_type', 'safe', 'on'=>'search'),
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
			'createUser' => array(self::BELONGS_TO, 'AppUser', 'create_user_id'),
			'modifyUser' => array(self::BELONGS_TO, 'AppUser', 'modify_user_id'),
			'deleteUser' => array(self::BELONGS_TO, 'AppUser', 'delete_user_id'),
			'subscriber' => array(self::BELONGS_TO, 'Subscriber', 'subscriber_id'),
			'vodAsset' => array(self::BELONGS_TO, 'VodAsset', 'vod_asset_id'),
			'vodEpisode' => array(self::BELONGS_TO, 'VodEpisode', 'vod_episode_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vod_episode_id' => 'Vod Episode',
			'vod_asset_id' => 'Vod Asset',
			'subscriber_id' => 'Subscriber',
			'description' => 'Description',
			'activate_date' => 'Activate Date',
			'expiry_date' => 'Expiry Date',
			'is_active' => 'Is Active',
			'create_date' => 'Create Date',
			'modify_date' => 'Modify Date',
			'is_deleted' => 'Is Deleted',
			'delete_date' => 'Delete Date',
			'create_user_id' => 'Create User',
			'modify_user_id' => 'Modify User',
			'delete_user_id' => 'Delete User',
			'using_type' => 'Using Type',
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
		$criteria->compare('vod_episode_id',$this->vod_episode_id);
		$criteria->compare('vod_asset_id',$this->vod_asset_id);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('activate_date',$this->activate_date,true);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('modify_date',$this->modify_date,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('delete_date',$this->delete_date,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('modify_user_id',$this->modify_user_id,true);
		$criteria->compare('delete_user_id',$this->delete_user_id,true);
		$criteria->compare('using_type',$this->using_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}