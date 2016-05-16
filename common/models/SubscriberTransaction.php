<?php
/**
 * This is the model class for table "subscriber_transaction".
 *
 * The followings are the available columns in table 'subscriber_transaction':
 * @property string $id
 * @property integer $service_id
 * @property integer $vod_asset_id
 * @property integer $vod_episode_id
 * @property integer $subscriber_id
 * @property string $create_date
 * @property integer $status
 * @property string $service_number
 * @property string $description
 * @property double $cost
 * @property string $channel_type
 * @property string $event_id
 * @property integer $using_type
 * @property integer $purchase_type
 * @property string $error_code
 * @property string $req_id
 * @property string $vnp_username
 * @property string $vnp_ip
 *
 * The followings are the available model relations:
 * @property Service $service
 * @property Subscriber $subscriber
 * @property VodAsset $vodAsset
 * @property VodEpisode $vodEpisode
 */
class SubscriberTransaction extends CActiveRecord
{
	public $statusStr; //mapping tu status: 1 : thanh cong, 2 : that bai
	//doanh thu ngay hien tai
	public $revenueRegister;
	public $revenueExtend;
    public $revenueRetryExtend;
    public $revenueGifts;
    public $revenueRegister7;
    public $revenueExtend7;
    public $revenueRetryExtend7;
    public $revenueGift7;
    public $revenueRegisterVtv;
    public $revenueExtendVtv;
    public $revenueGiftVtv;
	public $revenueRetryExtendVtv;
	public $revenueTotal;
	public $revenue_total_charging;
	public $revenue_number_success;
	public $revenue_number_failed;
	public $revenueView;
    public $revenueDownload;
    public $revenueGift;

	//tong dk moi
	public $report_date;
	public $wap_service_1;
	public $sms_service_1;
	public $app_service_1;
	public $web_service_1;
	public $km_service_1;

    public $wap_service_7;
    public $sms_service_7;
    public $app_service_7;
    public $web_service_7;
    public $km_service_7;

    public $wap_service_30;
    public $sms_service_30;
    public $app_service_30;
    public $web_service_30;
    public $km_service_30;

	//tk noi dung
	public $total_view;
	public $total_money;
	public $count_sub;
    public $total;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubscriberTransaction the static model class
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
		return 'subscriber_transaction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
		array('subscriber_id, status, error_code', 'required'),
		array('service_id, vod_asset_id, vod_episode_id, subscriber_id, status, using_type, purchase_type', 'numerical', 'integerOnly'=>true),
		array('cost', 'numerical'),
		array('service_number', 'length', 'max'=>45),
		array('description', 'length', 'max'=>200),
		array('channel_type, event_id', 'length', 'max'=>10),
		array('error_code', 'length', 'max'=>20),
		array('create_date', 'safe'),
		// The following rule is used by search().
		// Please remove those attributes that should not be searched.
		array('id, service_id, vod_asset_id, vod_episode_id, subscriber_id, create_date, status, service_number, description, cost, channel_type, event_id, using_type, purchase_type, error_code', 'safe', 'on'=>'search'),
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
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
			'subscriber' => array(self::BELONGS_TO, 'Subscriber', 'subscriber_id'),
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
			'service_id' => 'Gói cước',
			'vod_asset_id' => 'Phim',
			'vod_episode_id' => 'Vod Episode',
			'subscriber_id' => 'Thuê bao',
			'create_date' => 'Thời điểm',
			'status' => 'Kết quả',
			'statusStr' => 'Kết quả',
			'service_number' => 'Service Number',
			'description' => 'Mô tả',
			'cost' => 'Cước phí',
			'channel_type' => 'Kênh',
			'event_id' => 'Event',
			'using_type' => 'Mục đích',
			'purchase_type' => 'Hình thức',
			'error_code' => 'Mã lỗi',
			'vnp_username' => 'UserName',
			'vnp_ip' => 'UserIP',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('vod_asset_id',$this->vod_asset_id);
		$criteria->compare('vod_episode_id',$this->vod_episode_id);
		$criteria->compare('subscriber_id',$this->subscriber_id);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('service_number',$this->service_number,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('channel_type',$this->channel_type,true);
		$criteria->compare('event_id',$this->event_id,true);
		$criteria->compare('using_type',$this->using_type);
		$criteria->compare('purchase_type',$this->purchase_type);
		$criteria->compare('error_code',$this->error_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getMaxTransactionId() {
		$result = Yii::app()->db->createCommand()
		->selectDistinct('t.id')
		->from('subscriber_transaction as t')
		->limit(0, 1)
		->order('t.id DESC')
		->queryScalar();
		if (!$result) {
			$result = 1;
		}
		return $result;
	}

	public static function getPurchaseTypeName($purchase_type) {
		switch($purchase_type) {
			case PURCHASE_TYPE_NEW:
				return "Mua mới";
			case PURCHASE_TYPE_RECUR:
				return "Gia hạn";
			case PURCHASE_TYPE_CANCEL:
				return "Tự hủy";
			case PURCHASE_TYPE_FORCE_CANCEL:
				return "Bị hủy";
			case PURCHASE_TYPE_RETRY_EXTEND:
				return "Truy thu";
// 			case PURCHASE_TYPE_PENDING:
// 				return "Tạm dừng";
// 			case PURCHASE_TYPE_RESTORE:
// 				return "Khôi phục";
		}
	}

	public function getUsingTypeStr() {
		switch($this->using_type) {
			case USING_TYPE_REGISTER:
				return "Đăng ký";
			case USING_TYPE_CHARGING_SMS:
				return "SMS";
			case USING_TYPE_DOWNLOAD:
				return "Mua để download";
			case USING_TYPE_EXTEND_TIME:
				return "Gia hạn";
			case USING_TYPE_RECEIVE_GIFT:
				return "Được tặng";
			case USING_TYPE_SEND_GIFT:
				return "Mua để tặng";
			case USING_TYPE_WATCH:
				return "Mua để xem";
		}
	}

	public function getPurchaseTypeStr() {
		return self::getPurchaseTypeName($this->purchase_type);
	}

	public function getStatusStr() {
		if($this->status == 1) {
			return "Thành công";
		}
		else {
			return "Thất bại";
		}
	}

	public function getReport_tk_ti_le_tru_tien($startDate, $endDate){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		if(CUtils::isToday($startDate, $endDate)){
			$today = date("Y-m-d H:i:s", time());
			$startDate = CUtils::getStartDate($today);
			$endDate = CUtils::getEndDate($today);
			$sqlString = "select ";
			$sqlString .= "(select count(`id`) from subscriber_transaction where status = 1 and create_date between '$startDate' and '$endDate' and cost > 0) as revenue_number_success,";
			$sqlString .= "(select count(`id`) from subscriber_transaction where status = 2 and create_date between '$startDate' and '$endDate' and cost > 0) as revenue_number_failed ";
			$sqlString .= "From subscriber_transaction where service_id =".SERVICE_2;
			$subscriberTransaction = SubscriberTransaction::model()->findBySql($sqlString, array());
			if($subscriberTransaction != NULL) {
				$subscriberTransaction->revenue_number_success = ($subscriberTransaction->revenue_number_success==null)?0:$subscriberTransaction->revenue_number_success;
				$subscriberTransaction->revenue_number_failed = ($subscriberTransaction->revenue_number_failed==null)?0:$subscriberTransaction->revenue_number_failed;
				$total = $subscriberTransaction->revenue_number_success + $subscriberTransaction->revenue_number_failed;
				$subscriberTransaction->revenue_total_charging = $total;
			}
			return $subscriberTransaction;
		}
	}
	public static function getReport_tong_dk_moi($startDate, $endDate){
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		$startDate = CUtils::getStartDate($startDate);
		$endDate = CUtils::getEndDate($endDate);
		if(CUtils::isToday($startDate, $endDate)){
			$today = date("Y-m-d H:i:s", time());
			$startDate = CUtils::getStartDate($today);
			$endDate = CUtils::getEndDate($today);
			$sqlString = "SELECT ";
			$sqlString .="DATE_FORMAT(DATE(st.create_date), '%d/%m/%Y') as report_date,";
			$sqlString .="SUM(if(st.service_id = ".SERVICE_2." && purchase_type = ".PURCHASE_TYPE_NEW." && using_type = ".USING_TYPE_REGISTER." && channel_type='WAP' , 1, 0)) As wap_service_7, ";
			$sqlString .="SUM(if(st.service_id = ".SERVICE_2." && purchase_type = ".PURCHASE_TYPE_NEW." && using_type = ".USING_TYPE_REGISTER." && channel_type='SMS' , 1, 0)) As sms_service_7,";
			$sqlString .="SUM(if(st.service_id = ".SERVICE_2." && purchase_type = ".PURCHASE_TYPE_NEW." && using_type = ".USING_TYPE_REGISTER." && channel_type='APP' , 1, 0)) As app_service_7,";
			$sqlString .="SUM(if(st.service_id = ".SERVICE_2." && purchase_type = ".PURCHASE_TYPE_NEW." && using_type = ".USING_TYPE_REGISTER." && channel_type='WEB' , 1, 0)) As web_service_7, ";
			$sqlString .="SUM(if(st.service_id = ".SERVICE_2." && purchase_type = ".PURCHASE_TYPE_NEW." && using_type = ".USING_TYPE_REGISTER." && channel_type='API' , 1, 0)) As km_service_7 ";
			$sqlString .="FROM subscriber_transaction st ";
			$sqlString .="WHERE (st.create_date BETWEEN '$startDate' AND '$endDate') AND (status = 1)";
			$sqlString .="GROUP BY DATE(st.create_date)";
			$subscriberTransaction = SubscriberTransaction::model()->findBySql($sqlString, array());
			return $subscriberTransaction;
		}
	}
	public static function getReport_tk_mua_phim($startDate, $endDate, $contentProviderId = null){
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
			$sqlString .="sum(cost) As total_money, ";
			$sqlString .="count(distinct subscriber_id) As count_sub ";
			$sqlString .="FROM subscriber_transaction st ";
			$sqlString .="WHERE (create_date BETWEEN '$startDate' AND '$endDate') AND (status = 1) AND purchase_type = 1 ";
			$sqlString .="AND vod_asset_id is not null AND vod_asset_id in (select id from vod_asset where content_provider_id = ".$contentProvider->id.")";
			$subscriberTransaction = SubscriberTransaction::model()->findBySql($sqlString, array());
			$data = array();
			if($subscriberTransaction != NULL) {
				$data = (array($contentProvider->display_name=>array($subscriberTransaction->total_view, $subscriberTransaction->count_sub, $subscriberTransaction->total_money)));
			}
			$result = array_merge($result,$data);
		}
		return $result;
	}
	
	public function getApplication() {
		try {
			$desc = $this->description;
			if(strpos($desc, '_app_') === FALSE) {
				return "vFilm";
			}
			else {
		// 		$trans->description = "_app_$application"."_trial_$trial"."_promotion_$promotion"."_note_$note";
				$start = strpos($desc, '_app_')+5;
		// 		echo " - $start -";
				if($start < 5) {
					return 'vFilm';
				}
				if(strlen($desc) < $start+1) {
					return 'vFilm';
				}
				$length = strpos($desc, '_', $start+1) - $start;
		// 		$length = strpos($desc, '_trial_') - $start;
				$result = substr($desc, $start, $length);
			}
			return $result;
		}
		catch(Exception $e) {
			return 'vFilm';
		}
	}
	
	public function getVnpUsername() {
		if(!isset($this->vnp_username)) {
			return 'vFilm_system';
		}
		return $this->vnp_username;
	}
	
	public function getVnpUserIp() {
		if(!isset($this->vnp_ip)) {
			return '113.185.0.153';
		}
		return $this->vnp_ip;
	}
}
