<?php

/**
 * This is the model class for table "vod_stream".
 *
 * The followings are the available columns in table 'vod_stream':
 * @property integer $id
 * @property integer $vod_asset_id
 * @property integer $vod_episode_id
 * @property string $stream_url
 * @property integer $resolution_w
 * @property integer $resolution_h
 * @property integer $bitrate
 * @property integer $stream_type
 * @property string $create_date
 * @property string $create_user_id
 * @property integer $status
 * @property integer $server_id
 * @property integer $protocol
 *
 * The followings are the available model relations:
 * @property AppUser $createUser
 * @property StreamingServer $server
 * @property VodAsset $vodAsset
 * @property VodEpisode $vodEpisode
 */
class VodStream extends CActiveRecord
{
	public $stream_low;
	public $stream_normal;
	public $stream_high;
	public $id_low;
	public $id_normal;
	public $id_high;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodStream the static model class
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
		return 'vod_stream';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stream_url', 'required'),
			array('vod_asset_id, vod_episode_id, resolution_w, resolution_h, bitrate, stream_type, status, server_id, protocol', 'numerical', 'integerOnly'=>true),
			array('stream_url', 'length', 'max'=>500),
			array('create_user_id', 'length', 'max'=>11),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vod_asset_id, vod_episode_id, stream_url, resolution_w, resolution_h, bitrate, stream_type, create_date, create_user_id, status, server_id, protocol', 'safe', 'on'=>'search'),
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
			'server' => array(self::BELONGS_TO, 'StreamingServer', 'server_id'),
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
			'vod_asset_id' => 'Vod Asset',
			'vod_episode_id' => 'Vod Episode',
			'stream_url' => 'Stream Url',
			'resolution_w' => 'Resolution W',
			'resolution_h' => 'Resolution H',
			'bitrate' => 'Bitrate',
			'stream_type' => 'Stream Type',
			'create_date' => 'Create Date',
			'create_user_id' => 'Create User',
			'status' => 'Status',
			'server_id' => 'Server',
			'protocol' => 'Protocol',
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
		$criteria->compare('vod_episode_id',$this->vod_episode_id);
		$criteria->compare('stream_url',$this->stream_url,true);
		$criteria->compare('resolution_w',$this->resolution_w);
		$criteria->compare('resolution_h',$this->resolution_h);
		$criteria->compare('bitrate',$this->bitrate);
		$criteria->compare('stream_type',$this->stream_type);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('server_id',$this->server_id);
		$criteria->compare('protocol',$this->protocol);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getStreamUrl($protocol){
		// 		return $this->stream_url; //fixme xoa dong nay
		$url = "";
		$server = "";
		$servers_streaming = StreamingServer::model()->active()->priority()->findAll();
		if(count($servers_streaming) <= 0){
			return "";
		}else{
			$server = $servers_streaming[0]->url;
		}
		switch ($protocol){
			case CUtils::$STREAMING_HLS:
				$url .= 'http://'.$server.':1935/vod/_definst_/'.$this->stream_url.'/playlist.m3u8';
				break;
			case CUtils::$STREAMING_RTSP:
				$url .= 'rtsp://'.$server.'/vod/_definst_/'.$this->stream_url;
				break;
			case CUtils::$STREAMING_HTTP:
				$url .= 'http://'.$server.'/vod/'.$this->stream_url;
				break;
			case CUtils::$STREAMING_MMS:
				$url .= 'http://'.$server.':1935/vod/_definst_/'.$this->stream_url.'/Manifest';
				break;
			default:
				$url .= 'rtsp://'.$server.'/vod/_definst_/'.$this->stream_url;
				break;
		}
	
		return $url;
	}
	
	public function generateStreams($protocol) {
		$streams = array();
		if($protocol == -1) {
			$streams[] = $this->getStreamUrl(CUtils::$STREAMING_RTSP);
			$streams[] = $this->getStreamUrl(CUtils::$STREAMING_HLS);
			$streams[] = $this->getStreamUrl(CUtils::$STREAMING_HTTP);
			$streams[] = $this->getStreamUrl(CUtils::$STREAMING_MMS);
		}
		else {
			$streams[] = $this->getStreamUrl($protocol);
		}
		return $streams;
	}
}