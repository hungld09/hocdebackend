<?php

/**
 * This is the model class for table "vod_asset".
 *
 * The followings are the available columns in table 'vod_asset':
 * @property integer $id
 * @property string $code_name
 * @property string $display_name
 * @property string $display_name_ascii
 * @property string $original_title
 * @property string $actors
 * @property string $director
 * @property string $tags
 * @property string $short_description
 * @property string $description
 * @property integer $view_count
 * @property integer $like_count
 * @property integer $dislike_count
 * @property double $rating
 * @property integer $rating_count
 * @property integer $comment_count
 * @property integer $favorite_count
 * @property integer $is_series
 * @property integer $episode_count
 * @property integer $duration
 * @property integer $is_multibitrate
 * @property integer $vod_stream_count
 * @property integer $is_free
 * @property double $price
 * @property double $price_download
 * @property double $price_gift
 * @property integer $image_count
 * @property string $expiry_date
 * @property integer $status
 * @property string $create_date
 * @property string $modify_date
 * @property string $create_user_id
 * @property string $modify_user_id
 * @property integer $honor
 * @property integer $min_app_version_platform_id
 * @property integer $content_provider_id
 * @property integer $using_duration
 * @property string $approve_date
 *
 * The followings are the available model relations:
 * @property DownloadToken[] $downloadTokens
 * @property SubscriberTransaction[] $subscriberTransactions
 * @property ViewToken[] $viewTokens
 * @property AppVersionPlatform $minAppVersionPlatform
 * @property AppUser $createUser
 * @property AppUser $modifyUser
 * @property ContentProvider $contentProvider
 * @property VodCategoryAssetMapping[] $vodCategoryAssetMappings
 * @property VodComment[] $vodComments
 * @property VodEpisode[] $vodEpisodes
 * @property VodImage[] $vodImages
 * @property VodLikeDislike[] $vodLikeDislikes
 * @property VodRating[] $vodRatings
 * @property VodStream[] $vodStreams
 * @property VodSubscriberFavorite[] $vodSubscriberFavorites
 * @property VodSubscriberMapping[] $vodSubscriberMappings
 */
class VodAsset extends CActiveRecord
{
	const VOD_STATUS_ACTIVE      = 1;
	const VOD_STATUS_INACTIVE    = 0;
	const VOD_STATUS_FOR_TEST    = 2;
	
	public $categories;
	public $packages;
	public $streamUrl;
	public $serverIP;
	public $fileName;
	public $width;
	public $height;
	public $bitRate;
	public $streamStatus;
	public $streamType;
	public $imageUrl;
	public $imageFileName;
	public $imageWidth;
	public $imageHeight;
	public $imageFileSize;
	public $imageFormat;
	public $imageTitle;
	public $imageStatus;
	public $imageType;
	
	//tk noi dung
	public $series_content_upload;
	public $not_series_content_upload;
	public $series_content_approve;
	public $not_series_content_approve;
	public $upload_date;
	public $approve_date;
	
	//tk trang thai noi dung
	public $count_asset_active;
	public $count_asset_not_active;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VodAsset the static model class
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
		return 'vod_asset';
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
			array('view_count, like_count, dislike_count, rating_count, comment_count, favorite_count, is_series, episode_count, duration, is_multibitrate, vod_stream_count, is_free, image_count, status, honor, min_app_version_platform_id, content_provider_id, using_duration', 'numerical', 'integerOnly'=>true),
			array('rating, price, price_download, price_gift', 'numerical'),
			array('code_name, display_name, display_name_ascii, director', 'length', 'max'=>200),
			array('original_title, tags, short_description, actors', 'length', 'max'=>500),
			array('create_user_id, modify_user_id', 'length', 'max'=>11),
			array('description, expiry_date, create_date, modify_date, approve_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code_name, display_name, display_name_ascii, original_title, tags, short_description, description, view_count, like_count, dislike_count, rating, rating_count, comment_count, favorite_count, is_series, episode_count, duration, is_multibitrate, vod_stream_count, is_free, price, price_download, price_gift, image_count, expiry_date, status, create_date, modify_date, create_user_id, modify_user_id, honor, min_app_version_platform_id, content_provider_id, using_duration, approve_date', 'safe', 'on'=>'search'),
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
			'downloadTokens' => array(self::HAS_MANY, 'DownloadToken', 'vod_asset_id'),
			'subscriberTransactions' => array(self::HAS_MANY, 'SubscriberTransaction', 'vod_asset_id'),
			'viewTokens' => array(self::HAS_MANY, 'ViewToken', 'vod_asset_id'),
			'minAppVersionPlatform' => array(self::BELONGS_TO, 'AppVersionPlatform', 'min_app_version_platform_id'),
			'createUser' => array(self::BELONGS_TO, 'AppUser', 'create_user_id'),
			'modifyUser' => array(self::BELONGS_TO, 'AppUser', 'modify_user_id'),
			'contentProvider' => array(self::BELONGS_TO, 'ContentProvider', 'content_provider_id'),
			'vodCategoryAssetMappings' => array(self::HAS_MANY, 'VodCategoryAssetMapping', 'vod_asset_id'),
			'vodComments' => array(self::HAS_MANY, 'VodComment', 'vod_asset_id'),
			'vodEpisodes' => array(self::HAS_MANY, 'VodEpisode', 'vod_asset_id'),
			'vodImages' => array(self::HAS_MANY, 'VodImage', 'vod_asset_id'),
			'vodLikeDislikes' => array(self::HAS_MANY, 'VodLikeDislike', 'vod_asset_id'),
			'vodRatings' => array(self::HAS_MANY, 'VodRating', 'vod_asset_id'),
			'vodStreams' => array(self::HAS_MANY, 'VodStream', 'vod_asset_id'),
			'vodSubscriberFavorites' => array(self::HAS_MANY, 'VodSubscriberFavorite', 'vod_asset_id'),
			'vodSubscriberMappings' => array(self::HAS_MANY, 'VodSubscriberMapping', 'vod_asset_id'),
			
			'vodCategories' => array(self::MANY_MANY, 'VodCategory', 'vod_category_asset_mapping(vod_asset_id, vod_category_id)'),
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
			'display_name' => 'Tên phim',
			'original_title' => 'Tên gốc',
			'actors' => 'Diễn viên',
 			'director' => 'Đạo diễn',
			'tags' => 'Tags',
			'short_description' => 'Mô tả ngắn',
			'description' => 'Mô tả',
			'view_count' => 'View Count',
			'like_count' => 'Like Count',
			'dislike_count' => 'Dislike Count',
			'rating' => 'Rating',
			'rating_count' => 'Rating Count',
			'comment_count' => 'Comment Count',
			'favorite_count' => 'Favorite Count',
			'is_series' => 'Phim bộ',
			'episode_count' => 'Số tập phim',
			'duration' => 'Thời lượng',
			'is_multibitrate' => 'Is Multibitrate',
			'vod_stream_count' => 'Vod Stream Count',
			'is_free' => 'Miễn phí',
			'price' => 'Giá',
			'price_download' => 'Price Download',
			'price_gift' => 'Price Gift',
			'image_count' => 'Image Count',
			'expiry_date' => 'Ngày hết hạn',
			'status' => 'Status',
			'create_date' => 'Ngày tạo',
			'modify_date' => 'Ngày sửa',
			'create_user_id' => 'Create User',
			'modify_user_id' => 'Modify User',
			'honor' => 'Honor',
			'min_app_version_platform_id' => 'Min App Version Platform',
			'content_provider_id' => 'Content Provider',
			'using_duration' => 'Using Duration',
			'approve_date' => 'Approve Date',
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
		$criteria->compare('display_name_ascii',$this->display_name_ascii,true);
		$criteria->compare('original_title',$this->original_title,true);
		$criteria->compare('tags',$this->tags,true);
		$criteria->compare('short_description',$this->short_description,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('view_count',$this->view_count);
		$criteria->compare('like_count',$this->like_count);
		$criteria->compare('dislike_count',$this->dislike_count);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('rating_count',$this->rating_count);
		$criteria->compare('comment_count',$this->comment_count);
		$criteria->compare('favorite_count',$this->favorite_count);
		$criteria->compare('is_series',$this->is_series);
		$criteria->compare('episode_count',$this->episode_count);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('is_multibitrate',$this->is_multibitrate);
		$criteria->compare('vod_stream_count',$this->vod_stream_count);
		$criteria->compare('is_free',$this->is_free);
		$criteria->compare('price',$this->price);
		$criteria->compare('price_download',$this->price_download);
		$criteria->compare('price_gift',$this->price_gift);
		$criteria->compare('image_count',$this->image_count);
		$criteria->compare('expiry_date',$this->expiry_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('modify_date',$this->modify_date,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('modify_user_id',$this->modify_user_id,true);
		$criteria->compare('honor',$this->honor);
		$criteria->compare('min_app_version_platform_id',$this->min_app_version_platform_id);
		$criteria->compare('content_provider_id',$this->content_provider_id);
		$criteria->compare('using_duration',$this->using_duration);
		$criteria->compare('approve_date',$this->approve_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getRelatedVODs($order, $page_no, $page_size) {
        $where = '(status = 1) ';
        if ($this->id != null) {
			$where .= ' AND id !=' . $this->id . ' ';
        }
        
//        if (!empty ($keyword)) {
//            $where .= "AND (t.display_name_ascii LIKE '%$keyword%' OR t.tags_ascii LIKE '%$keyword%') ";
//        }
        
        $catids = '';
        foreach ($this->vodCategories as $cat) {
            $catids .= $cat->id . ",";
        }
        if (!empty($catids)) {
            $catids = substr($catids, 0, strlen($catids)-1);
            $where .= " AND id in (select vod_asset_id from  vod_category_asset_mapping where vod_category_id in (" .
                    "$catids)) ";
        }


        //TODO: co the dung ActiveRecord o day ko??
        
        $result = Yii::app()->db->createCommand()
                ->selectDistinct('t.id,t.price,t.price_download,t.price_gift,t.create_date,t.modify_date,t.short_description,t.description,t.view_count,t.like_count,t.dislike_count,t.rating,t.rating_count,t.comment_count,t.favorite_count,t.display_name,t.original_title,t.duration,t.is_free, is_series, t.episode_count')
                ->from('vod_asset t')
                ->where($where) 
                ->limit($page_size, $page_no * $page_size)
                ->order($order)
                ->queryAll();
        $total_result = Yii::app()->db->createCommand()
                ->select('count(id)')
                ->from('vod_asset as t')
                ->where($where) 
                ->queryScalar();
        //echo count($result);
        //CVarDumper::dump($result);
        
        //Yii::app()->end();
        
        return array(
            'total_result'=>$total_result,
            'page_number'=>$page_no,
            'page_size'=>$page_size,
            'vod'=>$this->id,
            'total_page'=>($total_result - ($total_result % $page_size))/$page_size + (($total_result % $page_size ===0)?0:1),
            'data'=>$result
        );
    }
    
    /**
     * neu ko truyen cat_id thi co the dung AR, truy van dc ca image lan categories trong mot query, tra ve dang AR
     * @param type $order
     * @param type $page_no
     * @param type $page_size
     * @param type $keyword 
     */
    public static function findVODs2($order, $page_no, $page_size, $keyword) {
                    
        $criteria = new CDbCriteria();
        $criteria->with=array('vodCategories', 'vodImages');
        
        $criteria->addCondition('(status = 1)');
        
        if (!empty($order)) {
            $criteria->order = $order;
        }
        if (!empty($keyword)) {
        	$keyword = mysql_escape_string($keyword);
            $criteria->addCondition("t.display_name_ascii LIKE '%$keyword%' OR t.tags_ascii LIKE '%$keyword%'");
        }

        $total_result = VodAsset::model()->count($criteria);

        $criteria->offset = $page_no * $page_size;
        $criteria->limit = $page_size;
        //CVarDumper::dump($criteria);
        //Yii::app()->end();
        $result = VodAsset::model()->findAll($criteria);

        return array(
            'total_result'=>$total_result,
            'keyword'=>$keyword,
            'page_number'=>$page_no,
            'page_size'=>$page_size,
            'category'=>$category_id,
            'total_page'=>($total_result - ($total_result % $page_size))/$page_size + (($total_result % $page_size ===0)?0:1),
            'data'=>$result
        );
    }
    
    /**
     *
     * @param integer $vod_id
     * @return VodImage [] 
     */
    public static function getVODImages($vod_id){
        return VodImage::model()->findAllByAttributes(array("vod_asset_id"=>$vod_id));
    }
    
    /**
     * Check vod have trailer
     * 
     */
    
    public function haveTrailer(){
    	$streams = $this->vodStreams;
    	foreach ($streams as $stream){
    		if($stream->stream_type == 2){
    			return true;
    		}
    	}
    	return false;
    }
    
    /**
     *
     * @param integer $vod_id
     * @return VodCategory [] 
     */
    public static function getVODCategories($vod_id){
        return VodCategory::model()->with(array(
            'vodCategoryAssetMappings' => array(
                'select'=>false,
                'joinType'=>'INNER JOIN',
                'condition'=>"vodCategoryAssetMappings.vod_asset_id=$vod_id"
            ),
            ))->findAll();
    }
    
    /**
     *
     * @param type $page_no
     * @param type $page_size
     * @return VodComment[]
     */
    public function getComments($page_no, $page_size) {
        $criteria = new CDbCriteria();
       
        $criteria->condition = 'vod_asset_id = :vodid';
        $criteria->params = array(':vodid'=>$this->id); 
        $criteria->order = 'create_date DESC'; 

        $total_result = VodComment::model()->count($criteria);

        $criteria->offset = $page_no * $page_size;
        $criteria->limit = $page_size;
        //CVarDumper::dump($criteria);
        //Yii::app()->end();
        $result = VodComment::model()->findAll($criteria);
        
        return array(
            'total_result'=>$total_result,
            'page_number'=>$page_no,
            'page_size'=>$page_size,
            'total_page'=>($total_result - ($total_result % $page_size))/$page_size + (($total_result % $page_size ===0)?0:1),
            'data'=>$result
        );
    }
    
    public function getDetailInfoOfSerie($vodId) {
        $asset = VodAsset::model()->findByPk($vodId);
        /* @var $vod VodAsset */
        if (empty ($asset)) {
            return 0;
        }
        $info['view_count'] = 0;
        $info['like_count'] = 0;
        $info['dislike_count'] = 0;
        /* @var $vod VodAsset */
        foreach ($asset->vodEpisodes as $episode) {
            if($episode == null) return 0;
            /* @var $episode VodEpisode */
            if($episode->status==1) {
                $info['view_count'] += $episode->view_count;
                $info['like_count'] += $episode->like_count;
                $info['dislike_count'] += $episode->dislike_count;
            }
        }
        return $info;
    }
    
    /**
     * tim VOD theo category va tu khoa, tra ve dang mang thong thuong
     * @param type $category_id
     * @param type $order
     * @param type $page_no
     * @param type $page_size
     * @param type $keyword
     * @return type
     */
    public static function findVODs($category_id, $order, $page_no, $page_size, $keyword, $actors, $director, $original_title, $id = -1, $status = 1,$content_provider_id = -1) {
    	if($id != -1) {
    		$where = "id = ".$id;
    	}
    	else {
    		if($status > -1) {
    			$where = "(status = ".$status.")";
    		}
    		else {
    			$where = "(status > ".$status.")";
    		}

    		if($content_provider_id > 0) {
    			$where = "(content_provider_id = ".$content_provider_id.")";
    		}

    		if (!empty ($keyword)) {
    			$where .= "AND (t.display_name LIKE '%$keyword%' OR t.display_name LIKE '%$keyword%' OR t.tags LIKE '%$keyword%') ";
    		}

    		if (!empty ($actors)) {
    			$where .= "AND (t.actors LIKE '%$actors%') ";
    		}

    		if (!empty ($director)) {
    			$where .= "AND (t.director LIKE '%$director%') ";
    		}

    		if (!empty ($original_title)) {
    			$where .= "AND (t.original_title LIKE '%$original_title%') ";
    		}
    
    		if ($category_id != null) {
    			$categoryObj = VodCategory::model()->findByPk($category_id);
    			if($categoryObj != NULL) {
    				$path = $categoryObj->path;
    				$where .= " AND id in (select vod_asset_id from  vod_category_asset_mapping where vod_category_id in (".
    						"select id from vod_category where concat('/',path,'/') like '/$path/%')) ";
    			}
    		}
    	}
    
    	//TODO: co the dung ActiveRecord o day ko??
    
    	$result = Yii::app()->db->createCommand()
    	->selectDistinct('t.id,t.create_date,t.view_count,t.like_count,t.dislike_count,t.rating,t.rating_count,t.comment_count,t.favorite_count,t.display_name,t.duration, t.status, t.view_count, t.actors, t.director,t.original_title, t.modify_date, t.release_date, t.modify_user_id,t.content_provider_id')
    	->from('vod_asset as t')
    	->where($where)
    	->limit($page_size, $page_no * $page_size)
    	->order($order)
    	->queryAll();
    	$total_result = Yii::app()->db->createCommand()
    	->select('count(id)')
    	->from('vod_asset as t')
    	->where($where)
    	->queryScalar();
    	//echo count($result);
    	//CVarDumper::dump($result);
    
    	//Yii::app()->end();
    
    	return array(
			'total_result'=>$total_result,
			'keyword'=>$keyword,
			'page_number'=>$page_no,
			'page_size'=>$page_size,
			'category'=>$category_id,
			'total_page'=>($total_result - ($total_result % $page_size))/$page_size + (($total_result % $page_size ===0)?0:1),
			'data'=>$result
    	);
    }
    
    // tuong tu findVODs, chi khac la nhieu categories cung luc - dang test
    public static function findVOD1s($categories, $order, $page_no, $page_size, $keyword, $actors, $director,$original_title, $id = -1, $status = 1) {
    	if($id != -1) {
    		$where = "id = ".$id;
    	}
    	else {
    		if($status > -1) {
    			$where = "(status = ".$status.")";
    		}
    		else {
    			$where = "(status > ".$status.")";
    		}

    		if($content_provider_id > 0) {
    			$where = "(content_provider_id = ".$content_provider_id.")";
    		}
    
    		$s = "";
    		foreach($categories as $category_id) {
    			$categoryObj = VodCategory::model()->findByPk($category_id);
    			$path = '';
    			if($categoryObj != NULL) {
    				$path = $categoryObj->path;
    			}
    			if($path == '') continue;
    			$s .= "(concat('/',path,'/') like '/$path/%') or ";
    		}
    
    		$newLen = strlen($s)- 4; // remove 4 symbol: ' or ' o cuoi string
    		$s = substr($s, 0, $newLen);
    		//            echo $s;
    		$where .= " AND id in (select vod_asset_id from  vod_category_asset_mapping where vod_category_id in (".
    				"select id from vod_category where ".$s."))";
    	}
    
    
    	//TODO: co the dung ActiveRecord o day ko??
    
    	$result = Yii::app()->db->createCommand()
    	->selectDistinct('t.id,t.create_date,t.view_count,t.like_count,t.dislike_count,t.rating,t.rating_count,t.comment_count,t.favorite_count,t.display_name,t.duration, t.status, t.view_count, t.actors, t.director,t.original_title, t.modify_date, t.release_date, t.modify_user_id, t.content_provider_id')
    	->from('vod_asset as t')
    	->where($where)
    	->limit($page_size, $page_no * $page_size)
    	->order($order)
    	->queryAll();
    	//        echo "page_size = $page_size - page_no = $page_no";
    	$total_result = Yii::app()->db->createCommand()
    	->select('count(id)')
    	->from('vod_asset as t')
    	->where($where)
    	->queryScalar();
    
    	return array(
    			'total_result'=>$total_result,
    			'keyword'=>$keyword,
    			'page_number'=>$page_no,
    			'page_size'=>$page_size,
    			'category'=>$category_id,
    			'total_page'=>($total_result - ($total_result % $page_size))/$page_size + (($total_result % $page_size ===0)?0:1),
    			'data'=>$result
    	);
    }
    
    public static function createJsonNewsList($res) {
    	$result = array();
    	foreach ($res['data'] as $vodAsset) {
    		$vodAssetNode = array();
    		$vodAssetNode['id'] = CHtml::encode($vodAsset['id']);
    		$vodAssetNode['create_date'] = CHtml::encode($vodAsset['create_date']);
    		$vodAssetNode['view_count'] = CHtml::encode($vodAsset['view_count']);
    		$vodAssetNode['comment_count'] = CHtml::encode($vodAsset['comment_count']);
    		$vodAssetNode['like_count'] = CHtml::encode($vodAsset['like_count']);
    		$vodAssetNode['dislike_count'] = CHtml::encode($vodAsset['dislike_count']);
    		$vodAssetNode['rating'] = CHtml::encode($vodAsset['rating']);
    		$vodAssetNode['rating_count'] = CHtml::encode($vodAsset['rating_count']);
    		$vodAssetNode['display_name'] = $vodAsset['display_name'];
    
    		$imageUrl = "";
    		$image = Image::model()->findByAttributes(array("vod_asset_id"=>$vodAsset["id"]));
    		if($image != NULL) {
    			$imageUrl = $image->url;
    			if(strpos($imageUrl, 'http') === false) {
    				$imageUrl = SERVER_URL.$imageUrl;
    			}
    		}
    		$vodAssetNode['image'] = CHtml::encode($imageUrl);
    		// 			$vodAssetNode['short_description'] = $vodAsset['short_description'];
    
    		$result[] = $vodAssetNode;
    	}
    	return $result;
    }
    
    public function getFirstImage($id) {
    	$image = Image::model()->findBySql("select * from image where vod_asset_id = $id order by id desc limit 1");
    	$result = "";
    	if ($image != null){
    		if(strpos($image->url, 'http') === false) {
    			$result = SERVER_URL.$image->url;
    		}
    		else {
    			$result = $image->url;
    		}
    	}
    	return $result;
    }
    public static function getReport_tk_noi_dung_upload($startDate, $endDate, $contentProviderId = null){
    	$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$sqlString = "SELECT DATE_FORMAT(DATE(va.create_date), '%d/%m/%Y') AS upload_date,
									SUM(if(va.is_series = 1, 1, 0)) AS series_content_upload,
									SUM(if(va.is_series = 0 , 1, 0)) AS not_series_content_upload
									FROM vod_asset va 
									where (create_date between '$startDate' AND '$endDate')";
    	if($contentProviderId != null){
			$sqlString .= " AND content_provider_id = ".$contentProviderId;
		}
		$sqlString .=" GROUP BY DATE(va.create_date)";
		
		$lstContent = VodAsset::model()->findAllBySql($sqlString, array());
		return $lstContent;
    }
    public static function getReport_tk_noi_dung_duyet($startDate, $endDate, $contentProviderId = null){
    	$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$sqlString = "SELECT DATE_FORMAT(DATE(va.create_date), '%d/%m/%Y') AS approve_date,
									SUM(if(va.is_series = 1, 1, 0)) AS series_content_approve,
									SUM(if(va.is_series = 0 , 1, 0)) AS not_series_content_approve 
									FROM vod_asset va 
									where (approve_date between '$startDate' AND '$endDate')";
    	if($contentProviderId != null){
			$sqlString .= " AND content_provider_id = ".$contentProviderId;
		}
		$sqlString .=" GROUP BY DATE(va.approve_date)";
		
		$lstContent = VodAsset::model()->findAllBySql($sqlString, array());
		return $lstContent;
    }
    
	public static function getReport_tk_trang_thai_noi_dung($startDate, $endDate, $contentProviderId = null){
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
			$sqlString .="SUM(if(status = 1 , 1, 0)) As count_asset_active,";
			$sqlString .="SUM(if(status = 2 , 1, 0)) As count_asset_not_active ";
			$sqlString .="FROM vod_asset st ";
			$sqlString .="WHERE (content_provider_id = ".$contentProvider['id'].")";
			$content = VodAsset::model()->findBySql($sqlString, array());
			$data = (array($contentProvider->display_name=>array($content->count_asset_active, $content->count_asset_not_active)));
			$result = array_merge($result,$data);
		}
		return $result;
	}
}
