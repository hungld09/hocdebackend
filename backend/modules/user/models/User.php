<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE=0;
	const STATUS_ACTIVE=1;
	const STATUS_BANNED=-1;
	
	//TODO: Delete for next version (backward compatibility)
	const STATUS_BANED=-1;

	const ROLE_NAME_SYSTEM_ADMIN = "System Admin";
	const ROLE_NAME_SERVICE_ADMIN = "Service Admin";
	const ROLE_NAME_SUBSCRIBER_SUPPORT = "Subscriber Support";
	const ROLE_NAME_MARKETING = "Marketing";
	const ROLE_NAME_CONTENT_ADMIN = "Content Admin";
	const ROLE_NAME_WHITE_LIST_ADMIN = "White List Admin";
	const ROLE_NAME_KPI = "KPI";
	const ROLE_NAME_CONTENT_PROVIDER = "Content Provider";
    const ROLE_NAME_CSKH_ADMIN = "cskh admin";
    const ROLE_NAME_SUPPORT_CSKH = "Support cskh";
    const ROLE_REPOST_DK = "reportMobileAds";
    const ROLE_REPOST_VTV = "vtv";
    const ROLE_REPOST_DK5 = "dk5";
	/**
	 * The followings are the available columns in table 'users':
	 * @var integer $id
	 * @var string $username
	 * @var string $password
	 * @var string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @var integer $lastvisit
	 * @var integer $superuser
	 * @var integer $status
     * @var timestamp $create_at
     * @var timestamp $lastvisit_at
	 * @var integer $role_id
	 * @var integer $content_provider_id
	 */

	const ROLE_ID_ADMIN = 1;
	const ROLE_ID_SERVICE_ADMIN = 2;
	const ROLE_ID_SUPPORTER = 3;
	const ROLE_ID_MARKETING = 4;
	const ROLE_ID_SECRETARY = 5;
	const ROLE_ID_MONITOR = 6;
	const ROLE_ID_CONTENT_ADMIN = 7;
	const ROLE_ID_CONTENT_MONITOR = 8;
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		return Yii::app()->getModule('user')->tableUsers;
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.CConsoleApplication
		return ((get_class(Yii::app())=='CConsoleApplication' || (get_class(Yii::app())!='CConsoleApplication' && Yii::app()->getModule('user')->isAdmin()))?array(
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE,self::STATUS_ACTIVE,self::STATUS_BANNED)),
			array('superuser', 'in', 'range'=>array(0,1)),
            array('create_at', 'default', 'value' => date('Y-m-d H:i:s'), 'setOnEmpty' => true, 'on' => 'insert'),
            array('lastvisit_at', 'default', 'value' => '0000-00-00 00:00:00', 'setOnEmpty' => true, 'on' => 'insert'),
			array('username, email, superuser, status', 'required'),
			array('superuser, status, content_provider_id', 'numerical', 'integerOnly'=>true),
			array('id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, content_provider_id', 'safe', 'on'=>'search'),
		):((Yii::app()->user->id==$this->id)?array(
			array('username, email', 'required'),
			array('username', 'length', 'max'=>20, 'min' => 3,'message' => UserModule::t("Incorrect username (length between 3 and 20 characters).")),
			array('email', 'email'),
			array('username', 'unique', 'message' => UserModule::t("This user's name already exists.")),
			array('username', 'match', 'pattern' => '/^[A-Za-z0-9_]+$/u','message' => UserModule::t("Incorrect symbols (A-z0-9).")),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
        $relations = Yii::app()->getModule('user')->relations;
        if (!isset($relations['profile']))
            $relations['profile'] = array(self::HAS_ONE, 'Profile', 'user_id');
        return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => UserModule::t("Id"),
			'username'=>UserModule::t("username"),
			'password'=>UserModule::t("password"),
			'verifyPassword'=>UserModule::t("Retype Password"),
			'email'=>UserModule::t("E-mail"),
			'verifyCode'=>UserModule::t("Verification Code"),
			'activkey' => UserModule::t("activation key"),
			'createtime' => UserModule::t("Registration date"),
			'create_at' => UserModule::t("Registration date"),
			
			'lastvisit_at' => UserModule::t("Last visit"),
			'superuser' => UserModule::t("Superuser"),
			'status' => UserModule::t("Status"),
			'content_provider_id' => UserModule::t("Content Provider"),
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactive'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANNED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'id, username, password, email, activkey, create_at, lastvisit_at, superuser, status, content_provider_id',
            ),
        );
    }
	
	public function defaultScope()
    {
        return CMap::mergeArray(Yii::app()->getModule('user')->defaultScope,array(
            'alias'=>'user',
            'select' => 'user.id, user.username, user.email, user.create_at, user.lastvisit_at, user.superuser, user.status, user.content_provider_id',
        ));
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => UserModule::t('Not active'),
				self::STATUS_ACTIVE => UserModule::t('Active'),
				self::STATUS_BANNED => UserModule::t('Banned'),
			),
			'AdminStatus' => array(
				'0' => UserModule::t('No'),
				'1' => UserModule::t('Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}
	
	public static function lstProvider(){
		$result = array();
		$lstProvider = ContentProvider::model()->findAllByAttributes(array("status"=>1));
		foreach ($lstProvider as $provider){
			$_item = array($provider->id=>$provider->display_name);
			$result += $_item;
		}
		return $result;
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
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('activkey',$this->activkey);
        $criteria->compare('create_at',$this->create_at);
        $criteria->compare('lastvisit_at',$this->lastvisit_at);
        $criteria->compare('superuser',$this->superuser);
        $criteria->compare('status',$this->status);
        $criteria->compare('content_provider_id',$this->content_provider_id);

        $roles=Rights::getAssignedRoles(Yii::app()->user->id); // check for single role
        foreach($roles as $role) {
        	if($role->name === 'Service Admin') //neu la role Quan ly dich vu thi chi show ra role Subscriber Support (co role_id = 3) (table AuthItem)
        	{
        		$criteria->compare('role_id',3);
        	}
        	break; //FIXME: tam thoi moi user chi co 1 role thoi
        }
        
        return new CActiveDataProvider(get_class($this), array(
            'criteria'=>$criteria,
        	'pagination'=>array(
				'pageSize'=>Yii::app()->getModule('user')->user_page_size,
			),
        ));
    }

    public function getCreatetime() {
        return strtotime($this->create_at);
    }

    public function setCreatetime($value) {
        $this->create_at=date('Y-m-d H:i:s',$value);
    }

    public function getLastvisit() {
        return strtotime($this->lastvisit_at);
    }

    public function setLastvisit($value) {
        $this->lastvisit_at=date('Y-m-d H:i:s',$value);
    }

    public static function getArrayMenu2($userId = null) {
    $result = array();

//     	$roles=Rights::getAssignedRoles($userId); // check for single role
    $role=self::getRole($userId); // check for single role
    if($role == NULL) {
        return $result;
    }
//     	foreach($roles as $role) {
    switch($role->name) {
        case self::ROLE_NAME_CSKH_ADMIN:
            $result = '1';
            break;

        case self::ROLE_NAME_SUPPORT_CSKH:
            $result = '2';
            break;

    }
// 	    	break; //FIXME: tam thoi moi user chi co 1 role thoi
//     	}

    return $result;
}
    
    public static function getArrayMenu($userId = null) {
    	$result = array();
    	$result = array(
		    			array('label'=>'Đăng nhập', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest),
		    			array('label'=>Yii::t('app','Đăng xuất').' ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest),
		    	);

////     	$roles=Rights::getAssignedRoles($userId); // check for single role
    	$role=self::getRole($userId); // check for single role
    	if($role == NULL) {
    		return $result;
    	}
    	
    	$arrCategoryManager = array('label'=>'Quản lý danh mục','url'=>'#', 'items'=>array(
    			array('label'=>'Danh sách','url'=>Yii::app()->createUrl('vodCategory/admin')),
    			array('label'=>'Tạo danh mục mới','url'=>Yii::app()->createUrl('vodCategory/create')),
    	));
    	$arrCategoryList = array('label'=>'Quản lý danh mục','url'=>'#', 'items'=>array(
    			array('label'=>'Danh sách','url'=>Yii::app()->createUrl('vodCategory/admin')),
    	));
    	$arrVodAssetManager = array('label'=>'Quản lý phim','url'=>'#', 'items'=>array(
    			array('label'=>'Danh sách phim','url'=>Yii::app()->createUrl('vodAsset/admin')),
    			array('label'=>'Tạo phim mới','url'=>Yii::app()->createUrl('vodAsset/create')),
    	));
    	$arrVodAssetList = array('label'=>'Quản lý phim','url'=>'#', 'items'=>array(
    			array('label'=>'Danh sách phim','url'=>Yii::app()->createUrl('vodAsset/admin')),
    	));
    	$arrSubManager = array('label'=>'Quản lý thuê bao','url'=>'#', 'items'=>array(
    			array('label'=>'Danh sách thuê bao','url'=>Yii::app()->createUrl('subscriber/admin')),
    			array('label'=>'Danh sách feedback','url'=>Yii::app()->createUrl('subscriberFeedback/admin')),
    	));
        $arrPush = array('label'=>'Push SMS','url'=>'#', 'items'=>array(
                    array('label'=>'Push Sms', 'url'=>Yii::app()->createUrl('pushsms/index')),
                    array('label'=>'Thong ke push sms', 'url'=>Yii::app()->createUrl('pushsms/toolsms')),
        ));
    	$arrSpecialSubManager = array('label'=>'Thuê bao miễn phí','url'=>Yii::app()->createUrl('subscriber/adminWhiteList'));
    	$arrSystemUserManager = array('label'=>Yii::t('app','Quản trị'), 'url'=>array('/rights'));
    	$arrSystemUserManager = array('label'=>'Quản trị','url'=>'#', 'items'=>array(
    			array('label'=>'Danh sách người dùng', 'url'=>array('/user/admin')),
    			array('label'=>'Phân quyền', 'url'=>array('/rights')),
//    			array('label'=>'Banner', 'url'=>array('/banner/admin')),
    	));
        $arrBannerList = array('label'=>'Quản lý banner','url'=>'#', 'items'=>array(
            array('label'=>'Banner','url'=>Yii::app()->createUrl('banner/admin')),
        ));
        $arrShowDtVtv = array('label'=>'Thống kê gói vtv','url'=>Yii::app()->createUrl('report/showDtVtv'));
        $arrShowDtDk5 = array('label'=>'Thống kê link truyền thông dk5','url'=>Yii::app()->createUrl('reportLinkMedia/showDtLink'));
    	
    	$reportDoanhthu = array('label'=>'Doanh thu', 'url'=>Yii::app()->createUrl('report/show/group_id/'.ReportController::GROUP_DOANH_THU));
    	$reportSanluong = array('label'=>'Sản lượng', 'url'=>Yii::app()->createUrl('report/show/group_id/'.ReportController::GROUP_SAN_LUONG));
    	$reportNoidung = array('label'=>'Nội dung', 'url'=>Yii::app()->createUrl('report/show/group_id/'.ReportController::GROUP_NOI_DUNG));
    	$reportMonitor = array('label'=>'Monitor', 'url'=>Yii::app()->createUrl('report/monitor'));
        $configsharing = array('label'=>'Cài đặt % vtv', 'url'=>Yii::app()->createUrl('report/configSharing'));

        $arrLinkAdminManager = array('label' => 'TK truyền thông', 'url' => '#', 'items' => array(
            array('label' => 'Cài đặt %', 'url' => array('/reportLinkMedia/configSharing')),
            array('label' => 'Thống kê', 'url' => array('/reportLinkMedia/showDtLink')),
            array('label' => 'Thống kê Clevernet', 'url' => array('/reportLinkMedia/showDtLinkClevernet')),
        ));

    	$arrLogin = array('label'=>'Đăng nhập', 'url'=>array('/user/login'), 'visible'=>Yii::app()->user->isGuest);
    	$arrLogout = array('label'=>Yii::t('app','Đăng xuất').' ('.Yii::app()->user->name.')', 'url'=>array('/user/logout'), 'visible'=>!Yii::app()->user->isGuest); 
    	$arrProfile = array('label'=>'Profile', 'url'=>array('/user/profile'), 'visible'=>!Yii::app()->user->isGuest);

//     	foreach($roles as $role) {
    		switch($role->name) {
    			case self::ROLE_NAME_SYSTEM_ADMIN:
    				$arrReport = array('label'=>'Báo cáo thống kê', 'url'=>'#', 'items' => array(
                        $reportDoanhthu,
                        $reportSanluong,
                        $reportNoidung,
                        $reportMonitor,
                        $configsharing,
                        $arrShowDtVtv,
                        $arrLinkAdminManager,
    				));
                    $arrSubManager = array('label'=>'Quản lý thuê bao','url'=>'#', 'items'=>array(
                        array('label'=>'Danh sách thuê bao','url'=>Yii::app()->createUrl('subscriber/admin')),
                        array('label'=>'Danh sách feedback','url'=>Yii::app()->createUrl('subscriberFeedback/admin')),
                        $arrPush
                    ));
    				$result = array($arrBannerList, $arrCategoryManager, $arrVodAssetManager, $arrSubManager, $arrReport, $arrSystemUserManager, $arrLogin, $arrProfile, $arrLogout);
    				break;
    				
    			case self::ROLE_NAME_SERVICE_ADMIN:
    				$result = array($arrSubManager, $arrSystemUserManager, $arrLogin, $arrProfile, $arrLogout);
    				break;

                case self::ROLE_REPOST_VTV:
                    $result = array($arrShowDtVtv, $arrLogout);
                    break;

                case self::ROLE_REPOST_DK5:
                    $result = array($arrShowDtDk5, $arrLogout);
                    break;

                case self::ROLE_NAME_WHITE_LIST_ADMIN:
    				$result = array($arrSubManager, $arrSpecialSubManager, $arrLogin, $arrProfile, $arrLogout);
    				break;
    				
    			case self::ROLE_NAME_SUBSCRIBER_SUPPORT:
    				$result = array($arrSubManager, $arrLogin, $arrProfile, $arrLogout);
    				break;
    				
    			case self::ROLE_NAME_MARKETING:
    				$arrReport = array('label'=>'Báo cáo thống kê', 'url'=>'#', 'items' => array(
     						$reportDoanhthu,
    						$reportSanluong,
    						$reportNoidung,
    						$reportMonitor,
    				));
    				$result = array($arrBannerList, $arrCategoryManager, $arrVodAssetManager, $arrSubManager, $arrReport, $arrLogin, $arrProfile, $arrLogout);
    				break;
    			case self::ROLE_NAME_KPI:
    				$arrReport = array('label'=>'Báo cáo thống kê', 'url'=>'#', 'items' => array(
    						$reportDoanhthu,
    						$reportSanluong,
//     						$reportNoidung,
    				));
    				$result = array($arrReport, $arrLogin, $arrProfile, $arrLogout);
    				break;
    			case self::ROLE_NAME_CONTENT_PROVIDER:
    				$arrReport = array('label'=>'Báo cáo thống kê', 'url'=>'#', 'items' => array(
    						$reportNoidung,
    				));
    				$result = array($arrReport, $arrLogin, $arrProfile, $arrLogout);
    				break;
    			case self::ROLE_NAME_CONTENT_ADMIN:
    				$result = array($arrCategoryManager, $arrVodAssetManager, $arrLogin, $arrProfile, $arrLogout);
    				break;
                case self::ROLE_REPOST_DK:
                    $result = array($reportSanluong, $arrLogin, $arrProfile, $arrLogout);
                    break;
    		}
// 	    	break; //FIXME: tam thoi moi user chi co 1 role thoi
//     	}
    	
    	return $result;
    }

    public static function isAdmin($userId) {
    	$roles=Rights::getAssignedRoles($userId); // check for single role
    	foreach($roles as $role) {
    		if($role->name == self::ROLE_NAME_SYSTEM_ADMIN) {
    			return true;		
    		}
    	}
    	return false;
    }

    public static function getRole($userId) {
    	$role = Rights::get1stAssignedRole($userId); // check for single role
//     	return NULL;
   		return $role;
    }
    
    public static function getRoleLevel($userId) {
    	$role = Rights::get1stAssignedRole($userId);
    	if($role != NULL) {
    		return $role->level;
    	}
    	return 0;
    }
}