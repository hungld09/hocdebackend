<?php

/**
 * This is the model class for table "vod_image".
 *
 * The followings are the available columns in table 'vod_image':
 * @property integer $id
 * @property integer $vod_asset_id
 * @property integer $vod_episode_id
 * @property string $url
 * @property string $title
 * @property integer $width
 * @property integer $height
 * @property integer $file_size
 * @property string $format
 * @property string $create_user_id
 * @property string $create_date
 * @property integer $status
 * @property integer $image_type
 * @property integer $image_size_type
 * @property integer $orientation
 *
 * The followings are the available model relations:
 * @property AppUser $createUser
 * @property VodAsset $vodAsset
 * @property VodEpisode $vodEpisode
 */
class VodImage extends CActiveRecord
{
	const ORIENTATION_PORTRAIT = 1;
	const ORIENTATION_LANDSCAPE = 2;
	/**
	 * This is the attribute holding the uploaded picture
	 * @var CUploadedFile
	 */
	public $picture;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodImage the static model class
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
		return 'vod_image';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('url', 'required'),
			array('vod_asset_id, vod_episode_id, width, height, file_size, status, image_type, image_size_type, orientation', 'numerical', 'integerOnly'=>true),
			array('url', 'length', 'max'=>500),
			array('title', 'length', 'max'=>300),
			array('format', 'length', 'max'=>40),
			array('create_user_id', 'length', 'max'=>11),
			array('create_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vod_asset_id, vod_episode_id, url, title, width, height, file_size, format, create_user_id, create_date, status, image_type, image_size_type, orientation', 'safe', 'on'=>'search'),
			array('picture', 'length', 'max' => 255, 'tooLong' => '{attribute} is too long (max {max} chars).', 'on' => 'upload'),
			array('picture', 'file', 'types' => 'jpg,gif,png', 'maxSize' => 1024 * 1024 * 2, 'tooLarge' => 'Size should be less then 2MB !!!', 'on' => 'upload'),
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
			'url' => 'Url',
			'title' => 'Title',
			'width' => 'Width',
			'height' => 'Height',
			'file_size' => 'File Size',
			'format' => 'Format',
			'create_user_id' => 'Create User',
			'create_date' => 'Create Date',
			'status' => 'Status',
			'image_type' => 'Image Type',
			'image_size_type' => 'Image Size Type',
			'orientation' => 'Orientation',
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
		$criteria->compare('url',$this->url,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('width',$this->width);
		$criteria->compare('height',$this->height);
		$criteria->compare('file_size',$this->file_size);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('image_type',$this->image_type);
		$criteria->compare('image_size_type',$this->image_size_type);
		$criteria->compare('orientation',$this->orientation);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getListImages($vod_asset_id) {
		$criteria=new CDbCriteria;
		if($vod_asset_id != NULL) {
			$criteria->compare('vod_asset_id',$vod_asset_id);
		}
		$model = new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	
		return $model;
	}
	
	public function getUrl() {
		if(strpos($this->url, 'http') === false) {
			$result = Yii::app()->baseUrl.'/files/'.$this->url;
		}
		else {
			$result = $this->url;
		}
		return $result;
	}
	
	public function getWidth() {
		$width = 0;
		$imageSize = getimagesize('/var/www/html/vfilmbackend/backend/www/files/'.$this->url);
		if(count($imageSize) > 0) {
			$width = $imageSize[0];
		}
		return $width;
	}

	public function getHeight() {
		$height = 0;
		$imageSize = getimagesize('/var/www/html/vfilmbackend/backend/www/files/'.$this->url);
		if(count($imageSize) > 0) {
			$height = $imageSize[1];
		}
		return $height;
	}
	
	public function getImageSize() { //return array: index 0 : width, index 1 : height
		$imageSize = getimagesize('/var/www/html/vfilmbackend/backend/www/files/'.$this->url);
		return $imageSize;		
	}
	
}