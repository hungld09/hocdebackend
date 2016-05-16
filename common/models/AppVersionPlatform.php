<?php

/**
 * This is the model class for table "app_version_platform".
 *
 * The followings are the available columns in table 'app_version_platform':
 * @property integer $id
 * @property integer $platform
 * @property string $change_log
 * @property string $release_date
 * @property integer $app_version_code
 * @property string $app_version_name
 * @property string $download_url
 * @property string $checksum
 * @property integer $status
 * @property string $userguide_url
 *
 * The followings are the available model relations:
 * @property VodAsset[] $vodAssets
 */
class AppVersionPlatform extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AppVersionPlatform the static model class
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
		return 'app_version_platform';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('platform, app_version_code, status', 'required'),
			array('platform, app_version_code, status', 'numerical', 'integerOnly'=>true),
			array('app_version_name', 'length', 'max'=>100),
			array('download_url, userguide_url', 'length', 'max'=>200),
			array('checksum', 'length', 'max'=>40),
			array('change_log, release_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, platform, change_log, release_date, app_version_code, app_version_name, download_url, checksum, status, userguide_url', 'safe', 'on'=>'search'),
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
			'vodAssets' => array(self::HAS_MANY, 'VodAsset', 'min_app_version_platform_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'platform' => 'Platform',
			'change_log' => 'Change Log',
			'release_date' => 'Release Date',
			'app_version_code' => 'App Version Code',
			'app_version_name' => 'App Version Name',
			'download_url' => 'Download Url',
			'checksum' => 'Checksum',
			'status' => 'Status',
			'userguide_url' => 'Userguide Url',
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
		$criteria->compare('platform',$this->platform);
		$criteria->compare('change_log',$this->change_log,true);
		$criteria->compare('release_date',$this->release_date,true);
		$criteria->compare('app_version_code',$this->app_version_code);
		$criteria->compare('app_version_name',$this->app_version_name,true);
		$criteria->compare('download_url',$this->download_url,true);
		$criteria->compare('checksum',$this->checksum,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('userguide_url',$this->userguide_url,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}