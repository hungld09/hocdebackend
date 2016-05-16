<?php

/**
 * This is the model class for table "service".
 *
 * The followings are the available columns in table 'service':
 * @property integer $id
 * @property string $code_name
 * @property string $display_name
 * @property string $description
 * @property string $tags
 * @property integer $is_active
 * @property string $create_date
 * @property string $create_user_id
 * @property string $modify_date
 * @property string $modify_user_id
 * @property integer $is_deleted
 * @property string $delete_date
 * @property string $delete_user_id
 * @property integer $free_download_count
 * @property integer $free_view_count
 * @property integer $free_gift_count
 * @property double $price
 * @property integer $using_days
 * @property integer $auto_recurring
 * @property string $content_id
 * @property string $category_id
 * @property integer $free_duration
 *
 * The followings are the available model relations:
 * @property AppUser $createUser
 * @property AppUser $modifyUser
 * @property AppUser $deleteUser
 * @property ServiceSubscriberMapping[] $serviceSubscriberMappings
 * @property SubscriberTransaction[] $subscriberTransactions
 */
class Service extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Service the static model class
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
		return 'service';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code_name, display_name', 'required'),
			array('is_active, is_deleted, free_download_count, free_view_count, free_gift_count, using_days, auto_recurring', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('code_name, package_name', 'length', 'max'=>200),
			array('display_name', 'length', 'max'=>500),
			array('description, tags', 'length', 'max'=>1000),
			array('create_user_id, modify_user_id, delete_user_id', 'length', 'max'=>11),
			array('content_id, category_id', 'length', 'max'=>30),
			array('create_date, modify_date, delete_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code_name, display_name, package_name, description, tags, is_active, create_date, create_user_id, modify_date, modify_user_id, is_deleted, delete_date, delete_user_id, free_download_count, free_view_count, free_gift_count, price, using_days, auto_recurring, content_id, category_id', 'safe', 'on'=>'search'),
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
			'serviceSubscriberMappings' => array(self::HAS_MANY, 'ServiceSubscriberMapping', 'service_id'),
			'subscriberTransactions' => array(self::HAS_MANY, 'SubscriberTransaction', 'service_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code_name' => 'Code Name',
			'display_name' => 'Display Name',
			'description' => 'Description',
			'tags' => 'Tags',
			'is_active' => 'Is Active',
			'create_date' => 'Create Date',
			'create_user_id' => 'Create User',
			'modify_date' => 'Modify Date',
			'modify_user_id' => 'Modify User',
			'is_deleted' => 'Is Deleted',
			'delete_date' => 'Delete Date',
			'delete_user_id' => 'Delete User',
			'free_download_count' => 'Free Download Count',
			'free_view_count' => 'Free View Count',
			'free_gift_count' => 'Free Gift Count',
			'price' => 'Price',
			'using_days' => 'Using Days',
			'auto_recurring' => 'Auto Recurring',
			'content_id' => 'Content',
			'category_id' => 'Category',
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
		$criteria->compare('code_name',$this->code_name,true);
		$criteria->compare('display_name',$this->display_name,true);
        $criteria->compare('package_name',$this->package_name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('modify_date',$this->modify_date,true);
		$criteria->compare('modify_user_id',$this->modify_user_id,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('delete_date',$this->delete_date,true);
		$criteria->compare('delete_user_id',$this->delete_user_id,true);
		$criteria->compare('free_download_count',$this->free_download_count);
		$criteria->compare('free_view_count',$this->free_view_count);
		$criteria->compare('free_gift_count',$this->free_gift_count);
		$criteria->compare('price',$this->price);
		$criteria->compare('using_days',$this->using_days);
		$criteria->compare('auto_recurring',$this->auto_recurring);
		$criteria->compare('content_id',$this->content_id,true);
		$criteria->compare('category_id',$this->category_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}