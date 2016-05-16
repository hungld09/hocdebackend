<?php

/**
 * This is the model class for table "subscriber".
 *
 * The followings are the available columns in table 'subscriber':
 * @property integer $id
 * @property string $subscriber_number
 * @property string $user_name
 * @property integer $status
 * @property string $status_log
 * @property string $email
 * @property string $full_name
 * @property string $password
 * @property string $last_login_time
 * @property integer $last_login_session
 * @property string $birthday
 * @property integer $sex
 * @property string $avatar_url
 * @property string $yahoo_id
 * @property string $skype_id
 * @property string $google_id
 * @property string $zing_id
 * @property string $facebook_id
 * @property string $create_date
 * @property string $modify_date
 * @property integer $client_app_type
 * @property integer $using_promotion
 * @property integer $reserve_column
 * @property integer $auto_recurring
 *
 * The followings are the available model relations:
 * @property DownloadToken[] $downloadTokens
 * @property MsisdnIp[] $msisdnIps
 * @property ServiceSubscriberMapping[] $serviceSubscriberMappings
 * @property SmsMessage[] $smsMessages
 * @property SubscriberActivityLog[] $subscriberActivityLogs
 * @property SubscriberFeedback[] $subscriberFeedbacks
 * @property SubscriberGroupMapping[] $subscriberGroupMappings
 * @property SubscriberNotificationFilter[] $subscriberNotificationFilters
 * @property SubscriberNotificationInbox[] $subscriberNotificationInboxes
 * @property SubscriberSession[] $subscriberSessions
 * @property SubscriberTransaction[] $subscriberTransactions
 * @property SubscriberUserActionLog[] $subscriberUserActionLogs
 * @property ViewToken[] $viewTokens
 * @property VodComment[] $vodComments
 * @property VodLikeDislike[] $vodLikeDislikes
 * @property VodRating[] $vodRatings
 * @property VodSearchHistory[] $vodSearchHistories
 * @property VodSubscriberFavorite[] $vodSubscriberFavorites
 * @property VodSubscriberMapping[] $vodSubscriberMappings
 */
class Subscriber extends CActiveRecord
{
	public $usingStatus;

    public $service_id;
	public $activated_date;
	public $subscriber_activated_count;

	public $error_message = ''; //dung trong actionCreate
	
	//form dang ky dich vu subscriber
	public $message;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Subscriber the static model class
	 */
	const WIFI_PASSWORD_VALID = 0;
	const WIFI_PASSWORD_INVALID = 1;
	const WIFI_PASSWORD_EXPIRED = 2;
	const STATUS_WHITE_LIST = 10;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'subscriber';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_name', 'required'),
			array('status, last_login_session, sex, client_app_type, using_promotion, reserve_column', 'numerical', 'integerOnly'=>true),
			array('subscriber_number', 'length', 'max'=>45),
			array('user_name, email', 'length', 'max'=>100),
			array('full_name, password', 'length', 'max'=>200),
			array('avatar_url, yahoo_id, skype_id, google_id, zing_id, facebook_id', 'length', 'max'=>255),
			array('status_log, last_login_time, birthday, create_date, modify_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subscriber_number, user_name, status, status_log, email, full_name, password, last_login_time, last_login_session, birthday, sex, avatar_url, yahoo_id, skype_id, google_id, zing_id, facebook_id, create_date, modify_date, client_app_type, using_promotion, reserve_column', 'safe', 'on'=>'search'),
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
			'downloadTokens' => array(self::HAS_MANY, 'DownloadToken', 'subscriber_id'),
			'msisdnIps' => array(self::HAS_MANY, 'MsisdnIp', 'subscriber_id'),
			'serviceSubscriberMappings' => array(self::HAS_MANY, 'ServiceSubscriberMapping', 'subscriber_id'),
			'smsMessages' => array(self::HAS_MANY, 'SmsMessage', 'subscriber_id'),
			'subscriberActivityLogs' => array(self::HAS_MANY, 'SubscriberActivityLog', 'subscriber_id'),
			'subscriberFeedbacks' => array(self::HAS_MANY, 'SubscriberFeedback', 'subscriber_id'),
			'subscriberGroupMappings' => array(self::HAS_MANY, 'SubscriberGroupMapping', 'subscriber_id'),
			'subscriberNotificationFilters' => array(self::HAS_MANY, 'SubscriberNotificationFilter', 'subscriber_id'),
			'subscriberNotificationInboxes' => array(self::HAS_MANY, 'SubscriberNotificationInbox', 'subscriber_id'),
			'subscriberSessions' => array(self::HAS_MANY, 'SubscriberSession', 'subscriber_id'),
			'subscriberTransactions' => array(self::HAS_MANY, 'SubscriberTransaction', 'subscriber_id'),
			'subscriberUserActionLogs' => array(self::HAS_MANY, 'SubscriberUserActionLog', 'subscriber_id'),
			'viewTokens' => array(self::HAS_MANY, 'ViewToken', 'subscriber_id'),
			'vodComments' => array(self::HAS_MANY, 'VodComment', 'subscriber_id'),
			'vodLikeDislikes' => array(self::HAS_MANY, 'VodLikeDislike', 'subscriber_id'),
			'vodRatings' => array(self::HAS_MANY, 'VodRating', 'subscriber_id'),
			'vodSearchHistories' => array(self::HAS_MANY, 'VodSearchHistory', 'subscriber_id'),
			'vodSubscriberFavorites' => array(self::HAS_MANY, 'VodSubscriberFavorite', 'subscriber_id'),
			'vodSubscriberMappings' => array(self::HAS_MANY, 'VodSubscriberMapping', 'subscriber_id'),
			'subscriberServices' => array(self::MANY_MANY, 'Service', 'service_subscriber_mapping(subscriber_id, service_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'subscriber_number' => 'Số điện thoại',
			'user_name' => 'User Name',
			'status' => 'Trạng thái',
			'status_log' => 'Status Log',
			'email' => 'Email',
			'full_name' => 'Full Name',
			'password' => 'Password',
			'last_login_time' => 'Last Login Time',
			'last_login_session' => 'Last Login Session',
			'birthday' => 'Birthday',
			'sex' => 'Sex',
			'avatar_url' => 'User Agent',
			'yahoo_id' => 'Thông tin thiết bị',
			'skype_id' => 'Skype',
			'google_id' => 'Google',
			'zing_id' => 'Zing',
			'facebook_id' => 'Facebook',
			'create_date' => 'Ngày đăng ký',
			'modify_date' => 'Modify Date',
			'client_app_type' => 'Loại client',
			'using_promotion' => 'Using Promotion',
			'reserve_column' => 'Reserve Column',
			'usingStatus' => 'Trạng thái',
			'auto_recurring' => 'Tự động gia hạn',
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
		$criteria->compare('subscriber_number',$this->subscriber_number,true);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('status_log',$this->status_log,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('last_login_time',$this->last_login_time,true);
		$criteria->compare('last_login_session',$this->last_login_session);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('avatar_url',$this->avatar_url,true);
		$criteria->compare('yahoo_id',$this->yahoo_id,true);
		$criteria->compare('skype_id',$this->skype_id,true);
		$criteria->compare('google_id',$this->google_id,true);
		$criteria->compare('zing_id',$this->zing_id,true);
		$criteria->compare('facebook_id',$this->facebook_id,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('modify_date',$this->modify_date,true);
		$criteria->compare('client_app_type',$this->client_app_type);
		$criteria->compare('using_promotion',$this->using_promotion);
		$criteria->compare('reserve_column',$this->reserve_column);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getSubscriberTransactionsHistory($from_date, $to_date, $page, $pageSize) {
		$transactions = Yii::app()->db->createCommand()
		->select("*")
		->from("subscriber_transaction")
		->where("status=1 AND cost != 100 AND subscriber_id=:subs_id AND create_date>=:from AND create_date<=:to", array(
				':subs_id' => $this->id,
				':from'    => $from_date,
				':to'      => $to_date))
				->limit($pageSize, $page * $pageSize)
				->order("create_date DESC")
				->queryAll();
	
		$total = Yii::app()->db->createCommand()
		->select("count(*)")
		->from("subscriber_transaction")
		->where("status=1 AND cost != 100 AND subscriber_id=:subs_id AND create_date>=:from AND create_date<=:to", array(
				':subs_id' => $this->id,
				':from'    => $from_date,
				':to'      => $to_date))
				->queryScalar();
	
		//error_log("got " . count($transactions) . " this page, $total records");
	
		return array(
				'total_result'  => $total,
				'page_number'   => $page,
				'page_size'     => $pageSize,
				'subscriber_id' => $this->id,
				'total_page'    => intval($total / $pageSize) + 1,
				'data'          => $transactions
		);
	}
	
	public static function newSubscriber($msisdn) {
		$subscriber = Subscriber::model()->findByAttributes(array("subscriber_number" => $msisdn));
		if($subscriber != NULL) {
			return $subscriber;
		}
		
		$aDate = new DateTime();
		$subscriber = new Subscriber();
	
		$subscriber->subscriber_number = $msisdn;
		$subscriber->user_name = $msisdn;
		$subscriber->status = 1;
		$subscriber->create_date = $aDate->format('Y-m-d H:i:s');
		$subscriber->modify_date = $aDate->format('Y-m-d H:i:s');
	
		if($subscriber->save()) {
			return $subscriber;
		}
		return null;
	}
	
	public function newTransaction($channel_type, $using_type, $purchase_type, $service = null, $asset = null, $time = null) {
		if($time == null){
			$aDate = new DateTime();
		}else{
			$aDate = new DateTime($time);
		}
		$subscriberTransaction = new SubscriberTransaction;
	
		if ($service != null) {
			$subscriberTransaction->service_id = $service->id;
		}
		if ($asset != null) {
			$subscriberTransaction->vod_asset_id = $asset->id;
		}
	
		$subscriberTransaction->subscriber_id = $this->id;
		$subscriberTransaction->create_date = $aDate->format("Y-m-d H:i:s");
		$subscriberTransaction->status = 1; // status dung lam gi khi co error_code?
	
		if ($using_type == 1) { // dang ky dich vu
			if ($purchase_type == 2) { // gia han
				$subscriberTransaction->description = isset($service) ? $service->display_name : "";
			} else {
				$subscriberTransaction->description = isset($service) ? $service->display_name : "";
			}
			$subscriberTransaction->cost = isset($service) ? $service->price : 0;
		} else if ($using_type == 2) { // mua phim
			$subscriberTransaction->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberTransaction->cost = isset($asset) ? $asset->price : 0;
		} else if ($using_type == 3) { // tai phim
			$subscriberTransaction->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberTransaction->cost = isset($asset) ? $asset->price_download : 0;
		} else if ($using_type == 4) { // tang phim
			$subscriberTransaction->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberTransaction->cost = isset($asset) ? $asset->price_gift : 0;
		} else if ($using_type == USING_TYPE_RECEIVE_GIFT) { // duoc tang phim
			$subscriberTransaction->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberTransaction->cost = 0;
		} else if ($using_type == USING_TYPE_CHARGING_SMS){
			$subscriberTransaction->cost = 100;
			$subscriberTransaction->description = "sms";
		} else {
			$subscriberTransaction->cost = 0;
		}
	
		$subscriberTransaction->channel_type = $channel_type; // WEB, WAP, SMS, APP, ...
	
		//TODO:event_id dung lam gi?
		//$subscriberTransaction->event_id = '';
		$subscriberTransaction->using_type = $using_type;//0: mua dich vu, 1: mua phim, 2: tai phim, 3: tang phim
		$subscriberTransaction->purchase_type = $purchase_type; //0: mua moi, 1: gia han, 2: chu dong huy, 3: bi huy
		$subscriberTransaction->error_code = "UNKNOWN";
		$subscriberTransaction->save();
	
		return $subscriberTransaction;
	}
	
	public function newExtendTimeTransaction($subscriber, $channel_type, $duration, $price, $charging_code) {
		$subscriberTransaction = new SubscriberTransaction;
		$subscriberTransaction->using_type = USING_TYPE_EXTEND_TIME;
		$subscriberTransaction->purchase_type = SubscriberTransaction::PURCHASE_TYPE_EXTEND_TIME;
		$subscriberTransaction->cost = $price;
		$subscriberTransaction->error_code = $charging_code;
		if($charging_code == "0") {
			$subscriberTransaction->status = 1;
		}
		else {
			$subscriberTransaction->status = 2;
		}
		$subscriberTransaction->create_date = new CDbExpression("NOW()");
		$subscriberTransaction->subscriber_id = $subscriber->id;
		$subscriberTransaction->description = "Gia han $duration ph";
		$subscriberTransaction->save();
	
		return $subscriberTransaction;
	}
	
	public function newOrder($channel_type, $using_type, $purchase_type, $service = null, $asset = null, $status = 2, $productOrderKey = null) {
		$aDate = new DateTime();
		$subscriberOrder = new SubscriberOrder();
	
		if ($service != null) {
			$subscriberOrder->service_id = $service->id;
		}
		if ($asset != null) {
			$subscriberOrder->vod_asset_id = $asset->id;
		}
	
		$subscriberOrder->subscriber_id = $this->id;
		$subscriberOrder->create_date = $aDate->format("Y-m-d H:i:s");
		$subscriberOrder->status = $status; // status dung lam gi khi co error_code?
	
		if ($using_type == 1) { // dang ky dich vu
			if ($purchase_type == 2) { // gia han
				$subscriberOrder->description = isset($service) ? "Gia han ".$service->display_name : "";
			} else {
				$subscriberOrder->description = isset($service) ? "Dang ky ".$service->display_name : "";
			}
			$subscriberOrder->cost = isset($service) ? $service->price : 0;
		} else if ($using_type == 2) { // mua phim
			$subscriberOrder->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberOrder->cost = isset($asset) ? $asset->price : 0;
		} else if ($using_type == 3) { // tai phim
			$subscriberOrder->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberOrder->cost = isset($asset) ? $asset->price_download : 0;
		} else if ($using_type == 4) { // tang phim
			$subscriberOrder->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberOrder->cost = isset($asset) ? $asset->price_gift : 0;
		} else if ($using_type == 4) { // duoc tang phim
			$subscriberOrder->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberOrder->cost = 0;
		} else {
			$subscriberOrder->cost = 0; //vi du using_type == 0 -> huy dich vu
                        $subscriberOrder->description = isset($service) ? "Huy ".$service->display_name : "";
		}
	
		$subscriberOrder->channel_type = $channel_type; // WEB, WAP, SMS, APP, ...
	
		//TODO:event_id dung lam gi?
		//$subscriberOrder->event_id = '';
		$subscriberOrder->using_type = $using_type;//0: mua dich vu, 1: mua phim, 2: tai phim, 3: tang phim
		$subscriberOrder->purchase_type = $purchase_type; //0: mua moi, 1: gia han, 2: chu dong huy, 3: bi huy
		if($status != 1) {
                    $subscriberOrder->error_code = "ERROR";
                }
                else {
                    $subscriberOrder->error_code = "SUCCESS";
                }
		$subscriberOrder->product_order_key = $productOrderKey;
		$subscriberOrder->save();
	
		return $subscriberOrder;
	}
	
	public function newRequest($channel_type, $using_type, $purchase_type, $service = null, $asset = null, $status = 2) {
		$aDate = new DateTime();
		$subscriberRequest = new SubscriberRequest();
	
		if ($service != null) {
			$subscriberRequest->service_id = $service->id;
		}
		if ($asset != null) {
			$subscriberRequest->vod_asset_id = $asset->id;
		}
	
		$subscriberRequest->subscriber_id = $this->id;
		$subscriberRequest->create_date = $aDate->format("Y-m-d H:i:s");
		$subscriberRequest->status = $status; // status dung lam gi khi co error_code?
	
		if ($using_type == 1) { // dang ky dich vu
			if ($purchase_type == 2) { // gia han
				$subscriberRequest->description = isset($service) ? $service->display_name : "";
			} else {
				$subscriberRequest->description = isset($service) ? $service->display_name : "";
			}
			$subscriberRequest->cost = isset($service) ? $service->price : 0;
		} else if ($using_type == 2) { // mua phim
			$subscriberRequest->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberRequest->cost = isset($asset) ? $asset->price : 0;
		} else if ($using_type == 3) { // tai phim
			$subscriberRequest->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberRequest->cost = isset($asset) ? $asset->price_download : 0;
		} else if ($using_type == 4) { // tang phim
			$subscriberRequest->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberRequest->cost = isset($asset) ? $asset->price_gift : 0;
		} else if ($using_type == 4) { // duoc tang phim
			$subscriberRequest->description = "Phim" . (isset($asset) ? " " . $asset->display_name . " [".$asset->id."]" : "");
			$subscriberRequest->cost = 0;
		} else {
			$subscriberRequest->cost = 0; //vi du using_type == 0 -> huy dich vu
		}
	
		$subscriberRequest->channel_type = $channel_type; // WEB, WAP, SMS, APP, ...
	
		//TODO:event_id dung lam gi?
		//$subscriberRequest->event_id = '';
		$subscriberRequest->using_type = $using_type;//0: mua dich vu, 1: mua phim, 2: tai phim, 3: tang phim
		$subscriberRequest->purchase_type = $purchase_type; //0: mua moi, 1: gia han, 2: chu dong huy, 3: bi huy
		$subscriberRequest->error_code = "UNKNOWN";
		$subscriberRequest->save();
	
		return $subscriberRequest;
	}
	
	public function addService($service,$partner_id = NULL, $using_type = USING_TYPE_REGISTER, $time = null) {
		if($time == null){
			$aDate = new DateTime();
			$eDate = new DateTime();
		}else{
			$aDate = new DateTime($time);
			$eDate = new DateTime($time);
		}
		if (isset($service->using_days) && $service->using_days > 0) {
			$eDate->add(DateInterval::createFromDateString($service->using_days . ' days'));
		}
		
		$extendPendingSsm = ServiceSubscriberMapping::model()->findByAttributes(array("subscriber_id" => $this->id, "is_active" => ServiceSubscriberMapping::SERVICE_STATUS_EXTEND_PENDING));
		if($extendPendingSsm != NULL) {
			$extendPendingSsm->is_active = ServiceSubscriberMapping::SERVICE_STATUS_INACTIVE;
			$extendPendingSsm->modify_date = new CDbExpression("NOW()");
			$extendPendingSsm->update();
		}
		
		$subscriberService = new ServiceSubscriberMapping;
		$subscriberService->service_id = $service->id;
		$subscriberService->subscriber_id = $this->id;
		$subscriberService->activate_date = $aDate->format("Y-m-d H:i:s");
		$subscriberService->expiry_date = $eDate->format("Y-m-d H:i:s");
		$subscriberService->is_active = ServiceSubscriberMapping::SERVICE_STATUS_ACTIVE;
		$subscriberService->create_date = $aDate->format("Y-m-d H:i:s");
		$subscriberService->is_deleted = 0;
		$subscriberService->view_count = 0;
		$subscriberService->download_count = 0;
		$subscriberService->gift_count = 0;
		$subscriberService->partner_id = $partner_id;
		$subscriberService->watching_time = $service->free_duration;
		$subscriberService->sent_notification = 0;
		$subscriberService->save();
	
		return $subscriberService;
	}
	
	public function cancelService($smap, $channel_type, $time = null, $error_code = CPS_OK) {
		if($time == null){
			$aDate = new DateTime();
		}else{
			$aDate = new DateTime($time);
		}
		$transaction = new SubscriberTransaction();
		$transaction->service_id = $smap->service->id;
		$transaction->subscriber_id = $this->id;
		$transaction->create_date = $aDate->format("Y-m-d H:i:s");
		$transaction->description = $smap->service->display_name;
		$transaction->cost = 0;
		$transaction->channel_type = $channel_type;
		//TODO:event_id dung lam gi?
		//$transaction->event_id = '';
		$transaction->using_type = 0; //cu cho bang zero, chi check purchase_type
		$transaction->purchase_type = 3; //huy dich vu
		$transaction->error_code = $error_code;
		if($error_code == CPS_OK) {
			$transaction->status = 1; // status dung lam gi khi co error_code?
			$smap->is_active = ServiceSubscriberMapping::SERVICE_STATUS_INACTIVE;
			$smap->is_deleted = 1;
			$smap->watching_time = 0;
	        $smap->modify_date = new CDbExpression('NOW()');
			$smap->update();
		}
		else {
			$transaction->status = 2;
		}
		$transaction->save();
	}
	
	public function pendingService($smap, $channel_type, $time = null) {
		if($time == null){
			$aDate = new DateTime();
		}else{
			$aDate = new DateTime($time);
		}
		$transaction = new SubscriberTransaction();
		$transaction->service_id = $smap->service->id;
		$transaction->subscriber_id = $this->id;
		$transaction->create_date = $aDate->format("Y-m-d H:i:s");
		$transaction->status = 1; // status dung lam gi khi co error_code?
		$transaction->description = $smap->service->display_name;
		$transaction->cost = 0;
		$transaction->channel_type = $channel_type;
		//TODO:event_id dung lam gi?
		//$transaction->event_id = '';
		$transaction->using_type = 0; //cu cho bang zero, chi check purchase_type
		$transaction->purchase_type = SubscriberTransaction::PURCHASE_TYPE_PENDING; //pending dich vu
		$transaction->error_code = CPS_OK;
		$transaction->save();
		$smap->is_active = ServiceSubscriberMapping::SERVICE_STATUS_PENDING;
        $smap->modify_date = new CDbExpression('NOW()');
		$smap->update();
	}
	
	public function restoreService($smap, $channel_type, $time = null) {
		if($time == null){
			$aDate = new DateTime();
		}else{
			$aDate = new DateTime($time);
		}
		$transaction = new SubscriberTransaction();
		$transaction->service_id = $smap->service->id;
		$transaction->subscriber_id = $this->id;
		$transaction->create_date = $aDate->format("Y-m-d H:i:s");
		$transaction->status = 1; // status dung lam gi khi co error_code?
		$transaction->description = $smap->service->display_name;
		$transaction->cost = 0;
		$transaction->channel_type = $channel_type;
		//TODO:event_id dung lam gi?
		//$transaction->event_id = '';
		$transaction->using_type = 0; //cu cho bang zero, chi check purchase_type
		$transaction->purchase_type = SubscriberTransaction::PURCHASE_TYPE_RESTORE; //pending dich vu
		$transaction->error_code = CPS_OK;
		$transaction->save();
		$smap->is_active = ServiceSubscriberMapping::SERVICE_STATUS_ACTIVE;
		$smap->sent_notification = 0;
        $smap->modify_date = new CDbExpression('NOW()');
		$smap->update();
	}
	
	public function addVodAsset($vod, $using_type, $debit = true) {
		$aDate = new DateTime();

		//Add 2 ngay cho film mua
		$eDate = new DateTime();
		$eDate->add(DateInterval::createFromDateString('1 days'));

		$vs = new VodSubscriberMapping();
		
		$vs->vod_asset_id = $vod->id;
		$vs->subscriber_id = $this->id;
		$vs->description = "";
		$vs->activate_date = $aDate->format("Y-m-d H:i:s");
		$vs->expiry_date = $eDate->format("Y-m-d H:i:s");
		$vs->is_active = 1;
		$vs->create_date = $aDate->format("Y-m-d H:i:s");
		$vs->is_deleted = 0;
		$vs->using_type = $using_type;
		$vs->save();
		return $vs;
	}
	
	public function hasVodAsset($vod, $using_type) {
		$vs = VodSubscriberMapping::model()->findByAttributes(array(
				"subscriber_id" => $this->id,
				"vod_asset_id"  => $vod->id,
				"using_type"    => $using_type,
				"is_active"     => 1,
				"is_deleted"    => 0));

		//Check expiry date cua film
		if(isset($vs)){
			$current = time();
			if(strtotime($vs->expiry_date) < $current){
				$vs->is_active = 0;
				$vs->update();
				return FALSE;
			}else{
				return TRUE;
			}
		}else{
			return FALSE;
		}
		
		return FALSE;
		//return isset($vs) ? $vs : FALSE;
	}
	
	public static function getAutoRecurringSubscribers() {
		$timestamp = time() + 6 * 60 * 60; // next 1/2 days
		$subscribers = Yii::app()->db->createCommand()
			->select("ssm.id, ssm.subscriber_id, ssm.service_id, ssm.expiry_date, UNIX_TIMESTAMP(ssm.expiry_date) AS expiry_ts, ssm.sent_notification, ssm.recur_retry_times, sub.subscriber_number , sub.auto_recurring, s.code_name, s.display_name, s.price, s.using_days")
			->from("subscriber sub")
			->join("service_subscriber_mapping ssm", "sub.id=ssm.subscriber_id")
			->join("service s", "ssm.service_id=s.id")
			->where("sub.auto_recurring=1 AND ssm.is_active=1 AND ssm.is_deleted=0 AND ((ssm.expiry_date BETWEEN NOW() AND FROM_UNIXTIME(:timestamp)) OR ssm.recur_retry_times > 0)", array(':timestamp' => $timestamp))
			->queryAll();
		return $subscribers;
	}
	
	public function purchaseVideo($asset_id) {
		$asset = VodAsset::model()->findByPk($asset_id);
		if ($asset) {
				
		} else {
				
		}
	}
	
	public function purchaseVideoEpisode($episode_id) {
	
	}
	
	public function purchaseDownload($asset_id) {
	
	}
	
	public function purchaseGift($asset_id, $dst_subscriber) {
	
	}
	
	public function inactiveOtherServices() {
		$arrSsm = ServiceSubscriberMapping::model()->findAllByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1));
		foreach($arrSsm as $ssm) {
			$ssm->is_active = 0;
			$ssm->update();
		}
	}
	
	public function isUsingService() {
		$ssm = ServiceSubscriberMapping::model()->findByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1, 'is_deleted' => 0));
		if($ssm != NULL) {
//			if($ssm->service->code_name == "PHIM"){
//				if(strtotime($ssm->expiry_date) < time()) {
//					$ssm->is_active = 0;
//					$ssm->is_deleted = 1;
//					$ssm->update();
//					return false;
//				}
//			}
			return true;
		}
		return false;
	}

    public function isUsingService2($serviceId) {
        $ssm = ServiceSubscriberMapping::model()->findByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1, 'is_deleted' => 0, 'service_id' => $serviceId));
        if($ssm != NULL) {
//			if($ssm->service->code_name == "PHIM"){
//				if(strtotime($ssm->expiry_date) < time()) {
//					$ssm->is_active = 0;
//					$ssm->is_deleted = 1;
//					$ssm->update();
//					return false;
//				}
//			}
            return true;
        }
        return false;
    }
	
	public function getFreeWatchingTime() {
		$ssm = ServiceSubscriberMapping::model()->findByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1));
		if($ssm == NULL) {
			return 0;
		}
		return $ssm->watching_time;
	}
	
	public static function getAutoRecurringSubscribersByThread($thread_pool = 1, $thread_index = 0) {
		$timestamp = time() + 3 * 60 * 60; // next 3 tieng
		$firstTime = time() - 24*60*60; // Lui lai 1 ngay
		$lastModifyDate = date('Y-m-d H:i:s', time()-21*3600);
		
		$subscribers = Yii::app()->db->createCommand()
		// 			->select("ssm.id, ssm.subscriber_id, ssm.service_id, ssm.expiry_date, UNIX_TIMESTAMP(ssm.expiry_date) AS expiry_ts, ssm.sent_notification, ssm.recur_retry_times, sub.subscriber_number , sub.auto_recurring, s.code_name, s.display_name, s.price, s.using_days")
		->select("ssm.id, ssm.subscriber_id, ssm.service_id, ssm.expiry_date, ssm.modify_date, UNIX_TIMESTAMP(ssm.expiry_date) AS expiry_ts, ssm.sent_notification, ssm.recur_retry_times, sub.subscriber_number , sub.auto_recurring")
		->from("subscriber sub")
		->join("service_subscriber_mapping ssm", "sub.id=ssm.subscriber_id")
		// 			->join("service s", "ssm.service_id=s.id")
		->where("(ssm.id % $thread_pool = $thread_index) AND sub.auto_recurring=1 AND ssm.is_active=1 AND ((ssm.expiry_date BETWEEN FROM_UNIXTIME(:firsttime) AND FROM_UNIXTIME(:timestamp)) or (ssm.recur_retry_times > 0 AND (ssm.modify_date < '$lastModifyDate' OR ssm.modify_date is null)))", array(':timestamp' => $timestamp,':firsttime'=>$firstTime))
		->order("ssm.recur_retry_times")
		->queryAll();
		return $subscribers;
	}
	
	public function generateWifiPassword() {
		$password = CUtils::randomString(4, "1234567890");
		$this->password = $password;
		$expiryTime = date("d/m/Y H:i:s", time()+86400);
		$this->last_login_time = date("Y:m:d H:i:s", time()+86400);
		$content = "Mat khau de dang nhap wifi tren vFilm la: " . $password . ". Mat khau co co hieu luc den ".$expiryTime;
		$mt = VinaphoneController::sendSms($this->subscriber_number, $content);
		if($mt->mt_status != 0) {
			return -1;
		}
		
		$this->update();
		return 1;
	}
	
	public function loginByWifiPassword($password) {
		$status = Subscriber::WIFI_PASSWORD_VALID;
		$session_id = -1;
		if($this->password == $password) {
			if(strtotime($this->last_login_time) > time()) {
				$session = SubscriberSession::createNewSession($this->id);
				$status = Subscriber::WIFI_PASSWORD_VALID;
				$session_id = $session->session_id; 
			}
			else {
				$status = Subscriber::WIFI_PASSWORD_EXPIRED; 
			}
		}
		else {
			$status = Subscriber::WIFI_PASSWORD_INVALID;
		}
		$result = array('status' => $status, 'session_id' => $session_id);
		return $result;
	}
	
	public function getErrorMessage($error_code) {
		switch($error_code) {
			case Subscriber::WIFI_PASSWORD_EXPIRED:
				return "Mật khẩu đã hết hạn sử dụng";
			case Subscriber::WIFI_PASSWORD_INVALID:
				return "Mật khẩu không đúng";
			case Subscriber::WIFI_PASSWORD_VALID:
				return "Đăng nhập thành công";
		}
	}
	
	public function getFakeSubscriber() {
		$subscriber = Subscriber::model()->findByPk(1);
		if($subscriber == NULL) {
			$subscriber = self::newSubscriber('84986636879');
		}
		return $subscriber;
	}
	
	public function getIsUsingService() {
		$ssm = ServiceSubscriberMapping::model()->findByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1));
		if($ssm == NULL) {
			return false;
		}
		return true;
	}
	
	public function getUsingServiceStatus() {
		if($this->isUsingService()) {
			return "Đang sử dụng";
		}
		return "Ngừng sử dụng";
	}
	
	public function getClientType() {
		switch($this->client_app_type) {
			case 1:
				return "WAP";
			case 1:
				return "Android";
			case 1:
				return "iOS";
		}
	}
	
	public function getUsingServiceStr() {
		$ssm = ServiceSubscriberMapping::model()->findByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1));
		if($ssm == NULL) {
			return "Ngừng sử dụng";
		}
		$result = $ssm->service->code_name." - Ngày hết hạn: ".$ssm->expiry_date;
		if($ssm->recur_retry_times > 0) {
			$result .= " (nợ cước)"; 
		}
		 
// 		$result = "Đang sử dụng - ".$ssm->service->code_name."Ngày hết hạn";
		return $result;
	}
    public function getUsingServiceStr1() {
        $ssm = ServiceSubscriberMapping::model()->findByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1));
        if($ssm == NULL) {
            return "Hết hạn";
        }
        $result = $ssm->service->code_name." - Ngày hết hạn: ".$ssm->expiry_date;
        if($ssm->recur_retry_times > 0) {
            $result .= " (nợ cước)";
        }

// 		$result = "Đang sử dụng - ".$ssm->service->code_name."Ngày hết hạn";
        return $result;
    }

    public function getUsingServiceStr2($service_id) {
        $ssm = ServiceSubscriberMapping::model()->findByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1, 'service_id'=>$service_id));
        if($ssm == NULL) {
            return "Không hoạt động";
        }else{
            return "Hoạt động";
        }
    }

    public function getUsingDateService($service_id) {
        $ssm = ServiceSubscriberMapping::model()->findByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1, 'service_id'=>$service_id));
        if($ssm != NULL) {
            $result = date('d/m/Y', strtotime($ssm->create_date));
            return $result;
        }else{
            $result = '';
            return $result;
        }
    }

    public function getUsingDateService2($service_id) {
        $ssm = ServiceSubscriberMapping::model()->findByAttributes(array('subscriber_id' => $this->id, 'is_active' => 1, 'service_id'=>$service_id));
        if($ssm != NULL) {
            $result = date('d/m/Y', strtotime($ssm->expiry_date));
            return $result;
        }else{
            $result = '';
            return $result;
        }
    }
	
	public function getSubscriberLink() {
		$link = "<a href='". Yii::app()->baseUrl ."/subscriber/".$this->id."'>".$this->subscriber_number."</a>";
		return $link;
	}
	

	public static function getReport_tk_thue_bao_kick_hoat($startDate, $endDate){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$sqlString = "SELECT ";
		$sqlString .=	"DATE_FORMAT(DATE(create_date), '%d/%m/%Y') AS activated_date, ";
		$sqlString .= "COUNT(subscriber_number) AS subscriber_activated_count "; 
		$sqlString .= "FROM subscriber WHERE status = 1 AND create_date BETWEEN '$startDate' AND '$endDate' GROUP BY DATE(create_date)";
		$subscriber = Subscriber::model()->findAllBySql($sqlString, array());
		return $subscriber;
	}
	public function getStatusLabel() {
		if($this->status == 1) {
			return "Thuê bao bình thường";
		}
		else if($this->status == self::STATUS_WHITE_LIST) {
			return "Thuê bao miễn phí";
		}
	}

	public function getAutoRecurringLabel() {
		if($this->auto_recurring == 1) {
			return "Có";
		}
		else if($this->auto_recurring == 0) {
			return "Không";
		}
	}
}
