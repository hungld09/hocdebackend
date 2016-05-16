<?php

/**
 * This is the model class for table "vod_search_history".
 *
 * The followings are the available columns in table 'vod_search_history':
 * @property integer $id
 * @property integer $subscriber_id
 * @property string $keyword
 * @property integer $hit_count
 * @property string $last_date
 * @property integer $vod_category_id
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 * @property VodCategory $vodCategory
 */
class VodSearchHistory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodSearchHistory the static model class
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
		return 'vod_search_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id, keyword', 'required'),
			array('subscriber_id, hit_count, vod_category_id', 'numerical', 'integerOnly'=>true),
			array('keyword', 'length', 'max'=>200),
			array('last_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subscriber_id, keyword, hit_count, last_date, vod_category_id', 'safe', 'on'=>'search'),
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
			'vodCategory' => array(self::BELONGS_TO, 'VodCategory', 'vod_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subscriber_id' => 'Subscriber',
			'keyword' => 'Keyword',
			'hit_count' => 'Hit Count',
			'last_date' => 'Last Date',
			'vod_category_id' => 'Vod Category',
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
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('keyword',$this->keyword,true);
		$criteria->compare('hit_count',$this->hit_count);
		$criteria->compare('last_date',$this->last_date,true);
		$criteria->compare('vod_category_id',$this->vod_category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}