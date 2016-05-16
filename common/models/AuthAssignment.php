<?php

/**
 * This is the model class for table "AuthAssignment".
 *
 * The followings are the available columns in table 'AuthAssignment':
 * @property string $itemname
 * @property string $userid
 * @property string $bizrule
 * @property string $data
 *
 * The followings are the available model relations:
 * @property AuthItem $itemname0
 */
class AuthAssignment extends CActiveRecord
{
	const AUTH_ADMIN = 'ADMIN';
	const AUTH_SERVICE_ADMIN = 'SERVICE_ADMIN';
	const AUTH_SUBSCRIBER_SUPPORT = 'SUBSCRIBER_SUPPORT';
	const AUTH_CONTENT_ADMIN = 'CONTENT_ADMIN';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AuthAssignment the static model class
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
		return 'AuthAssignment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemname, userid', 'required'),
			array('itemname, userid', 'length', 'max'=>64),
			array('bizrule, data', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('itemname, userid, bizrule, data', 'safe', 'on'=>'search'),
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
			'itemname0' => array(self::BELONGS_TO, 'AuthItem', 'itemname'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'itemname' => 'Itemname',
			'userid' => 'Userid',
			'bizrule' => 'Bizrule',
			'data' => 'Data',
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

		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('userid',$this->userid,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	//tuy theo role cua ng` quan ly ma tao authassignment (authitem  - user) tuong ung cho user dc tao
	//function nay dung trong actionCreate cua AdminController
	public function assign($user) {
		switch($user->role_id) {
			case User::ROLE_ID_SERVICE_ADMIN:
				self::createNew($user->id, self::AUTH_SUBSCRIBER_SUPPORT);
				break;
			default:
				self::createNew($user->id, self::AUTH_SUBSCRIBER_SUPPORT);
				break;
		}
	}
	
	private function createNew($userId, $authItemBizRule) {
		$authItem = AuthItem::model()->findByAttributes(array('bizrule' => $authItemBizRule));
		if($authItem == NULL) {
			return;
		}
		$itemname = $authItem->name;
		$model = AuthAssignment::model()->findByAttributes(array('userid' => $userId, 'itemname' => $itemname));
		if($model != NULL)  return;
		$model = new AuthAssignment();
		$model->userid = $userId;
		$model->itemname = $itemname;
		$model->save();
	}
}
