<?php

/**
 * This is the model class for table "streaming_log".
 *
 * The followings are the available columns in table 'streaming_log':
 * @property integer $id
 * @property integer $subscriber_id
 * @property integer $vod_stream_id
 * @property integer $status
 * @property string $create_date
 * @property string $channel_type
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 * @property VodStream $vodStream
 */
class StreamingLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StreamingLog the static model class
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
		return 'streaming_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subscriber_id, vod_stream_id, status', 'numerical', 'integerOnly'=>true),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subscriber_id, vod_stream_id, status, create_date', 'safe', 'on'=>'search'),
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
			'vodStream' => array(self::BELONGS_TO, 'VodStream', 'vod_stream_id'),
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
			'vod_stream_id' => 'Nội dung (xem phim)',
			'status' => 'Trạng thái',
			'channel_type' => 'Kênh',
			'create_date' => 'Thời điểm',
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
		$criteria->compare('vod_stream_id',$this->vod_stream_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_date',$this->create_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getVodName() {
		$result = "";
		if($this->vodStream != NULL) {
			if($this->vodStream->vodAsset != NULL) {
				$result = $this->vodStream->vodAsset->display_name;
			}
			else if($this->vodStream->vodEpisode != NULL) {
				$result = $this->vodStream->vodEpisode->display_name;
			}
		}
		return $result;
	}
	
	public function getStatusLabel() {
		if($this->status == 1) {
			return "Thành công";
		}
		else {
			return "Thất bại";
		}
	}
}