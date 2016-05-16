<?php

/**
 * This is the model class for table "vod_view".
 *
 * The followings are the available columns in table 'vod_view':
 * @property integer $id
 * @property integer $vod_asset_id
 * @property integer $subscriber_id
 * @property string $expiry_date
 * @property integer $reserve_col
 * @property string $description
 * @property string $create_date
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 * @property VodAsset $vodAsset
 */
class VodView extends CActiveRecord
{
	//tk xem phim
	public $total_view;
	public $count_sub;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodView the static model class
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
		return 'vod_view';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vod_asset_id, subscriber_id', 'required'),
			array('vod_asset_id, subscriber_id, reserve_col, type', 'numerical', 'integerOnly'=>true),
			array('expiry_date', 'length', 'max'=>45),
			array('description', 'length', 'max'=>100),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vod_asset_id, subscriber_id, expiry_date, reserve_col, description, create_date, type', 'safe', 'on'=>'search'),
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
			'vod_asset_id' => 'Vod Asset',
			'subscriber_id' => 'Subscriber',
			'expiry_date' => 'Expiry Date',
			'reserve_col' => 'Reserve Col',
			'description' => 'Description',
			'create_date' => 'Create Date',
			'type' => 'Type',
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
		$criteria->compare('vod_asset_id',$this->vod_asset_id);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('reserve_col',$this->reserve_col);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('type',$this->type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public static function getReport_tk_xem_phim($startDate, $endDate, $contentProviderId=null){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$result = array();
	if ($contentProviderId == null){
			$lstContentProvider = ContentProvider::model()->findAllBySql("select * from content_provider where status = 1");
		} else {
			$lstContentProvider = ContentProvider::model()->findAllBySql("select * from content_provider where status = 1 and id = ".$contentProviderId);
		}
		if(count($lstContentProvider) == 0) return;
		foreach ($lstContentProvider as $contentProvider){
			$sqlString = "SELECT ";
			$sqlString .="count(id) As total_view,";
			$sqlString .="count(distinct subscriber_id) As count_sub ";
			$sqlString .="FROM vod_view st ";
			$sqlString .="WHERE (create_date BETWEEN '$startDate' AND '$endDate') ";
			$sqlString .="AND vod_asset_id is not null AND vod_asset_id in (select id from vod_asset where content_provider_id = ".$contentProvider->id.")";
			$vodView = VodView::model()->findBySql($sqlString, array());
			$data = (array($contentProvider->display_name=>array($vodView->total_view, $vodView->count_sub)));
			$result = array_merge($result,$data);
		}
		return $result;
	}
}