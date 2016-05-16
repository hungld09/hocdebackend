<?php

/**
 * SQL create table streaming_session
 * 
 * CREATE TABLE IF NOT EXISTS `streaming_session` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(100) DEFAULT NULL,
  `subscriber_id` int(11) NOT NULL,
  `status` int(4) DEFAULT '1' COMMENT '1 - active2 - intactive',
  `start_time` int(11) DEFAULT NULL COMMENT '			',
  `end_time` int(11) DEFAULT NULL COMMENT '	',
  `duration` int(11) DEFAULT NULL,
  `ip_address` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_streaming_session_subscriber1` (`subscriber_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `streaming_session`
--
ALTER TABLE `streaming_session`
  ADD CONSTRAINT `fk_streaming_session_subscriber1` FOREIGN KEY (`subscriber_id`) REFERENCES `subscriber` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
 */


/**
 * This is the model class for table "streaming_session".
 *
 * The followings are the available columns in table 'streaming_session':
 * @property integer $id
 * @property string $session_id
 * @property integer $subscriber_id
 * @property integer $status
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $duration
 * @property string $ip_address
 *
 * The followings are the available model relations:
 * @property Subscriber $subscriber
 */
class StreamingSession extends CActiveRecord
{
	const FREE_DURATION_CONNECT = 60;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StreamingSession the static model class
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
		return 'streaming_session';
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
			array('subscriber_id, status, start_time, end_time, duration', 'numerical', 'integerOnly'=>true),
			array('session_id', 'length', 'max'=>100),
			array('ip_address', 'length', 'max'=>40),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, session_id, subscriber_id, status, start_time, end_time, duration, ip_address', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'session_id' => 'Session',
			'subscriber_id' => 'Subscriber',
			'status' => 'Status',
			'start_time' => 'Start Time',
			'end_time' => 'End Time',
			'duration' => 'Duration',
			'ip_address' => 'Ip Address',
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
		$criteria->compare('session_id',$this->session_id,true);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('start_time',$this->start_time);
		$criteria->compare('end_time',$this->end_time);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('ip_address',$this->ip_address,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
