<?php

/**
 * This is the model class for table "app_user".
 *
 * The followings are the available columns in table 'app_user':
 * @property string $id
 * @property integer $account_expired
 * @property integer $account_locked
 * @property string $address
 * @property string $city
 * @property string $country
 * @property string $postal_code
 * @property string $province
 * @property integer $credentials_expired
 * @property string $email
 * @property integer $account_enabled
 * @property string $first_name
 * @property string $last_name
 * @property string $password
 * @property string $password_hint
 * @property string $phone_number
 * @property string $username
 * @property integer $version
 * @property string $website
 * @property integer $content_provider_id
 *
 * The followings are the available model relations:
 * @property ContentProvider $contentProvider
 * @property Service[] $services
 * @property Service[] $services1
 * @property Service[] $services2
 * @property ServiceSubscriberMapping[] $serviceSubscriberMappings
 * @property ServiceSubscriberMapping[] $serviceSubscriberMappings1
 * @property ServiceSubscriberMapping[] $serviceSubscriberMappings2
 * @property SubscriberFeedback[] $subscriberFeedbacks
 * @property SubscriberGroup[] $subscriberGroups
 * @property SubscriberGroup[] $subscriberGroups1
 * @property SubscriberGroupMapping[] $subscriberGroupMappings
 * @property SubscriberUserActionLog[] $subscriberUserActionLogs
 * @property Role[] $roles
 * @property VodAsset[] $vodAssets
 * @property VodAsset[] $vodAssets1
 * @property VodCategory[] $vodCategories
 * @property VodCategory[] $vodCategories1
 * @property VodCategoryAssetMapping[] $vodCategoryAssetMappings
 * @property VodEpisode[] $vodEpisodes
 * @property VodEpisode[] $vodEpisodes1
 * @property VodImage[] $vodImages
 * @property VodStream[] $vodStreams
 * @property VodSubscriberMapping[] $vodSubscriberMappings
 * @property VodSubscriberMapping[] $vodSubscriberMappings1
 * @property VodSubscriberMapping[] $vodSubscriberMappings2
 */
class AppUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AppUser the static model class
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
		return 'app_user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_expired, account_locked, credentials_expired, first_name, last_name, password, username', 'required'),
			array('account_expired, account_locked, credentials_expired, account_enabled, version, content_provider_id', 'numerical', 'integerOnly'=>true),
			array('address', 'length', 'max'=>150),
			array('city, first_name, last_name, username', 'length', 'max'=>50),
			array('country, province', 'length', 'max'=>100),
			array('postal_code', 'length', 'max'=>15),
			array('email, password, password_hint, phone_number, website', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, account_expired, account_locked, address, city, country, postal_code, province, credentials_expired, email, account_enabled, first_name, last_name, password, password_hint, phone_number, username, version, website, content_provider_id', 'safe', 'on'=>'search'),
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
			'contentProvider' => array(self::BELONGS_TO, 'ContentProvider', 'content_provider_id'),
			'services' => array(self::HAS_MANY, 'Service', 'create_user_id'),
			'services1' => array(self::HAS_MANY, 'Service', 'modify_user_id'),
			'services2' => array(self::HAS_MANY, 'Service', 'delete_user_id'),
			'serviceSubscriberMappings' => array(self::HAS_MANY, 'ServiceSubscriberMapping', 'create_user_id'),
			'serviceSubscriberMappings1' => array(self::HAS_MANY, 'ServiceSubscriberMapping', 'modify_user_id'),
			'serviceSubscriberMappings2' => array(self::HAS_MANY, 'ServiceSubscriberMapping', 'delete_user_id'),
			'subscriberFeedbacks' => array(self::HAS_MANY, 'SubscriberFeedback', 'response_user_id'),
			'subscriberGroups' => array(self::HAS_MANY, 'SubscriberGroup', 'create_user_id'),
			'subscriberGroups1' => array(self::HAS_MANY, 'SubscriberGroup', 'modify_user_id'),
			'subscriberGroupMappings' => array(self::HAS_MANY, 'SubscriberGroupMapping', 'create_user_id'),
			'subscriberUserActionLogs' => array(self::HAS_MANY, 'SubscriberUserActionLog', 'user_id'),
			'roles' => array(self::MANY_MANY, 'Role', 'user_role(user_id, role_id)'),
			'vodAssets' => array(self::HAS_MANY, 'VodAsset', 'create_user_id'),
			'vodAssets1' => array(self::HAS_MANY, 'VodAsset', 'modify_user_id'),
			'vodCategories' => array(self::HAS_MANY, 'VodCategory', 'create_user_id'),
			'vodCategories1' => array(self::HAS_MANY, 'VodCategory', 'modify_user_id'),
			'vodCategoryAssetMappings' => array(self::HAS_MANY, 'VodCategoryAssetMapping', 'create_user_id'),
			'vodEpisodes' => array(self::HAS_MANY, 'VodEpisode', 'create_user_id'),
			'vodEpisodes1' => array(self::HAS_MANY, 'VodEpisode', 'modify_user_id'),
			'vodImages' => array(self::HAS_MANY, 'VodImage', 'create_user_id'),
			'vodStreams' => array(self::HAS_MANY, 'VodStream', 'create_user_id'),
			'vodSubscriberMappings' => array(self::HAS_MANY, 'VodSubscriberMapping', 'create_user_id'),
			'vodSubscriberMappings1' => array(self::HAS_MANY, 'VodSubscriberMapping', 'modify_user_id'),
			'vodSubscriberMappings2' => array(self::HAS_MANY, 'VodSubscriberMapping', 'delete_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'account_expired' => 'Account Expired',
			'account_locked' => 'Account Locked',
			'address' => 'Address',
			'city' => 'City',
			'country' => 'Country',
			'postal_code' => 'Postal Code',
			'province' => 'Province',
			'credentials_expired' => 'Credentials Expired',
			'email' => 'Email',
			'account_enabled' => 'Account Enabled',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'password' => 'Password',
			'password_hint' => 'Password Hint',
			'phone_number' => 'Phone Number',
			'username' => 'Username',
			'version' => 'Version',
			'website' => 'Website',
			'content_provider_id' => 'Content Provider',
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
		$criteria->compare('account_expired',$this->account_expired);
		$criteria->compare('account_locked',$this->account_locked);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('postal_code',$this->postal_code,true);
		$criteria->compare('province',$this->province,true);
		$criteria->compare('credentials_expired',$this->credentials_expired);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('account_enabled',$this->account_enabled);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('password_hint',$this->password_hint,true);
		$criteria->compare('phone_number',$this->phone_number,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('version',$this->version);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('content_provider_id',$this->content_provider_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}