<?php

/**
 * This is the model class for table "vod_episode".
 *
 * The followings are the available columns in table 'vod_episode':
 * @property integer $id
 * @property integer $vod_asset_id
 * @property string $code_name
 * @property string $display_name
 * @property integer $status
 * @property string $description
 * @property string $tags
 * @property integer $episode_order
 * @property double $price
 * @property integer $is_free
 * @property string $create_date
 * @property string $create_user_id
 * @property string $modify_date
 * @property string $modify_user_id
 * @property integer $view_count
 * @property integer $comment_count
 * @property integer $favorite_count
 * @property integer $vod_stream_count
 * @property integer $like_count
 * @property integer $dislike_count
 * @property integer $duration
 * @property double $rating
 * @property integer $is_multibitrate
 * @property double $price_download
 * @property double $price_gift
 * @property integer $rating_count
 * @property integer $using_duration
 * @property string $approve_date
 *
 * The followings are the available model relations:
 * @property DownloadToken[] $downloadTokens
 * @property SubscriberTransaction[] $subscriberTransactions
 * @property ViewToken[] $viewTokens
 * @property VodAsset $vodAsset
 * @property AppUser $createUser
 * @property AppUser $modifyUser
 * @property VodImage[] $vodImages
 * @property VodStream[] $vodStreams
 * @property VodSubscriberMapping[] $vodSubscriberMappings
 */
class VodEpisode extends CActiveRecord
{
	const EPISODE_STATUS_ACTIVE = 1;
	const EPISODE_STATUS_PENDING = 2;
	const EPISODE_STATUS_REJECTED = 0;
	
	public $episodeFileName_low;
	public $episodeFileName_normal;
	public $episodeFileName_high;
	public $episodeFrom;
	public $episodeTo;
	public $width;
	public $height;
	public $bitRate;
	public $streamStatus;
	public $streamType;
	public $vod_asset_name;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodEpisode the static model class
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
		return 'vod_episode';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vod_asset_id, code_name, display_name, is_multibitrate', 'required'),
			array('vod_asset_id, status, episode_order, is_free, view_count, comment_count, favorite_count, vod_stream_count, like_count, dislike_count, duration, is_multibitrate, rating_count, using_duration', 'numerical', 'integerOnly'=>true),
			array('price, rating, price_download, price_gift', 'numerical'),
			array('code_name, display_name', 'length', 'max'=>200),
			array('tags', 'length', 'max'=>500),
			array('create_user_id, modify_user_id', 'length', 'max'=>11),
			array('description, create_date, modify_date, approve_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vod_asset_id, code_name, display_name, status, description, tags, episode_order, price, is_free, create_date, create_user_id, modify_date, modify_user_id, view_count, comment_count, favorite_count, vod_stream_count, like_count, dislike_count, duration, rating, is_multibitrate, price_download, price_gift, rating_count, using_duration, approve_date', 'safe', 'on'=>'search'),
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
			'downloadTokens' => array(self::HAS_MANY, 'DownloadToken', 'vod_episode_id'),
			'subscriberTransactions' => array(self::HAS_MANY, 'SubscriberTransaction', 'vod_episode_id'),
			'viewTokens' => array(self::HAS_MANY, 'ViewToken', 'vod_episode_id'),
			'vodAsset' => array(self::BELONGS_TO, 'VodAsset', 'vod_asset_id'),
			'createUser' => array(self::BELONGS_TO, 'AppUser', 'create_user_id'),
			'modifyUser' => array(self::BELONGS_TO, 'AppUser', 'modify_user_id'),
			'vodImages' => array(self::HAS_MANY, 'VodImage', 'vod_episode_id'),
			'vodStreams' => array(self::HAS_MANY, 'VodStream', 'vod_episode_id'),
			'vodSubscriberMappings' => array(self::HAS_MANY, 'VodSubscriberMapping', 'vod_episode_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vod_asset_id' => 'Tên series',
			'code_name' => 'Code Name',
			'display_name' => 'Tên tập phim',
			'status' => 'Trạng thái',
			'description' => 'Mô tả',
			'tags' => 'Tags',
			'episode_order' => 'Thứ tự tập',
			'price' => 'Giá',
			'is_free' => 'Miễn phí',
			'create_date' => 'Ngày tạo',
			'create_user_id' => 'Create User',
			'modify_date' => 'Ngày sửa',
			'modify_user_id' => 'Modify User',
			'view_count' => 'Lượt xem',
			'comment_count' => 'Lượt comment',
			'favorite_count' => 'Lượt yêu thích',
			'vod_stream_count' => 'Vod Stream Count',
			'like_count' => 'Like Count',
			'dislike_count' => 'Dislike Count',
			'duration' => 'Thời lượng',
			'rating' => 'Rating',
			'is_multibitrate' => 'Is Multibitrate',
			'price_download' => 'Price Download',
			'price_gift' => 'Price Gift',
			'rating_count' => 'Rating Count',
			'using_duration' => 'Using Duration',
			'approve_date' => 'Approve Date',
			'episodeFileName_low' => 'File chất lượng thấp',
			'episodeFileName_normal' => 'File chất lượng bình thường',
			'episodeFileName_high' => 'File chất lượng cao',
			'episodeFrom' => 'Từ tập',
			'episodeTo' => 'Đến tập',
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
		$criteria->compare('code_name',$this->code_name,true);
		$criteria->compare('display_name',$this->display_name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('episode_order',$this->episode_order);
		$criteria->compare('price',$this->price);
		$criteria->compare('is_free',$this->is_free);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('modify_date',$this->modify_date,true);
		$criteria->compare('modify_user_id',$this->modify_user_id,true);
		$criteria->compare('view_count',$this->view_count);
		$criteria->compare('comment_count',$this->comment_count);
		$criteria->compare('favorite_count',$this->favorite_count);
		$criteria->compare('vod_stream_count',$this->vod_stream_count);
		$criteria->compare('like_count',$this->like_count);
		$criteria->compare('dislike_count',$this->dislike_count);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('is_multibitrate',$this->is_multibitrate);
		$criteria->compare('price_download',$this->price_download);
		$criteria->compare('price_gift',$this->price_gift);
		$criteria->compare('rating_count',$this->rating_count);
		$criteria->compare('using_duration',$this->using_duration);
		$criteria->compare('approve_date',$this->approve_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}