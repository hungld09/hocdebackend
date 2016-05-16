<?php

/**
 * This is the model class for table "content_provider".
 *
 * The followings are the available columns in table 'content_provider':
 * @property integer $id
 * @property string $display_name
 * @property string $code_name
 * @property string $create_date
 * @property string $modify_date
 * @property string $description
 *
 * The followings are the available model relations:
 * @property AppUser[] $appUsers
 * @property VodAsset[] $vodAssets
 */
class ContentProvider extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ContentProvider the static model class
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
		return 'content_provider';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('display_name, code_name', 'length', 'max'=>200),
			array('description', 'length', 'max'=>500),
			array('create_date, modify_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, display_name, code_name, create_date, modify_date, description', 'safe', 'on'=>'search'),
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
			'appUsers' => array(self::HAS_MANY, 'AppUser', 'content_provider_id'),
			'vodAssets' => array(self::HAS_MANY, 'VodAsset', 'content_provider_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'display_name' => 'Display Name',
			'code_name' => 'Code Name',
			'create_date' => 'Create Date',
			'modify_date' => 'Modify Date',
			'description' => 'Description',
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
		$criteria->compare('display_name',$this->display_name,true);
		$criteria->compare('code_name',$this->code_name,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('modify_date',$this->modify_date,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getAllCPName() {
		$allCP = ContentProvider::model()->findAll();
		$result = array();
		foreach($allCP as $contentProvider) {
			$result[$contentProvider->id] = $contentProvider->display_name;
		}
		return $result;
	}
}