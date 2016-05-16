<?php
/*
 * Phan report nay dc lam nhu sau:
 * - tu model User.php xac dinh danh sach cac group report cho phep role dc xem: 
 * 		+ show($group_id)
 * 		+ tuy theo group_id de lay danh sach cac report item: table report -> report_parent_id
 * - file view la index.php: content cua report lay tu model Report dua vao report id
 */

/**
 * This is the model class for table "report".
 *
 * The followings are the available columns in table 'report':
 * @property integer $id
 * @property string $report_name
 * @property integer $report_parent_id
 * @property integer $isReport
 * @property integer $isRoot
 * @property string $template_file
 * @property string $url
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property Report $reportParent
 * @property Report[] $reports
 * @property ReportParameter[] $reportParameters
 */
class Report extends CActiveRecord
{
    const TK_DOANH_THU = 1;
    const TK_TONG_THUE_BAO_KICH_HOAT = 2;
    const TK_SAN_LUONG_DICH_VU = 4;
    const TK_SAN_LUONG = 5;//2
    const TK_NOI_DUNG_UPLOAD = 8;
    const TK_NOI_DUNG_APPROVE = 9;
    const TK_TONG_DK_MOI = 11;
    const TK_MUA_PHIM = 18;
    const TK_XEM_PHIM = 19;
    const TK_TB_DK_SU_DUNG_DICH_VU = 12;
    const TK_DOANH_THU_NEW = 23;
    const TK_TI_LE_TRU_TIEN = 33;
    const TK_TRANG_THAI_NOI_DUNG = 36;
    const TK_THUE_BAO = 37;
    const TK_DANG_KY = 38;
    const TK_TB_SU_DUNG_DICH_VU = 39;
    const TK_MOBILE_ADS = 40;
//	const TK_SO_TB_LUY_KE = 4;

    public $reportId;
    public $intervalId;
    public $from_date;
    public $to_date;
    public $from_date_db;
    public $to_date_db;
    public $content;
    public $arrReportRadButton;
    public $partnerId;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Report the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'report';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('report_name, isReport, isRoot, url', 'required'),
            array('report_parent_id, isReport, isRoot, type', 'numerical', 'integerOnly' => true),
            array('report_name, template_file, url', 'length', 'max' => 255),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, report_name, report_parent_id, isReport, isRoot, template_file, url, type', 'safe', 'on' => 'search'),
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
            'reportParent' => array(self::BELONGS_TO, 'Report', 'report_parent_id'),
            'reports' => array(self::HAS_MANY, 'Report', 'report_parent_id'),
            'reportParameters' => array(self::MANY_MANY, 'ReportParameter', 'report_parameter_mapping(report_id, parameter_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'report_name' => 'Report Name',
            'report_parent_id' => 'Report Parent',
            'isReport' => 'Is Report',
            'isRoot' => 'Is Root',
            'template_file' => 'Template File',
            'url' => 'Url',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('report_name', $this->report_name, true);
        $criteria->compare('report_parent_id', $this->report_parent_id);
        $criteria->compare('isReport', $this->isReport);
        $criteria->compare('isRoot', $this->isRoot);
        $criteria->compare('template_file', $this->template_file, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('type', $this->type);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    private function getLabelByAction($purchase_type)
    {
        switch ($purchase_type) {
            case 1:
                return "Đăng ký";
            case 2:
                return "Gia hạn";
            case 3:
                return "Hủy";
            case 4:
                return "Bị hủy";
            case 10:
                return "Truy thu";
            default:
                return "Hành động khác";
        }
    }

    private function getLabelByStatus($status)
    {
        switch ($status) {
            case 1:
                return "Thành công";
            case 2:
                return "Thất bại";
        }
    }

    public function getReportContent()
    {
        return $this->content;
    }

    public function setReportContent($showReport = false)
    {
        if ($showReport) {
            $this->content = $this->getContent($this->from_date_db, $this->to_date_db, $this->reportId, $this->partnerId);
        } else {
            $this->content = "";
        }
    }

    private function getContent($from_date, $to_date, $reportId, $partnerId)
    {
// 		$from_date = date('Y-m-d H:i:s', strtotime($from_date));
// 		$to_date = date('Y-m-d H:i:s', strtotime($to_date));
        switch ($reportId) {
            case self::TK_DOANH_THU:
                return self::getContent_tk_doanh_thu($from_date, $to_date);
            case self::TK_DOANH_THU_NEW:
                return self::getContent_tk_doanh_thu_new($from_date, $to_date);
            case self::TK_TI_LE_TRU_TIEN:
                return self::getContent_tk_ti_le_tru_tien($from_date, $to_date);
            case self::TK_TONG_THUE_BAO_KICH_HOAT:
                return self::getContent_tk_tong_thue_bao_kich_hoat($from_date, $to_date);
            case self::TK_SAN_LUONG_DICH_VU:
                return self::getContent_tk_san_luong_dich_vu($from_date, $to_date);
            case self::TK_TONG_DK_MOI:
                return self::getContent_tk_tong_dk_moi($from_date, $to_date);
            case self::TK_MUA_PHIM:
                return self::getContent_tk_mua_phim($from_date, $to_date);
            case self::TK_XEM_PHIM:
                return self::getContent_tk_xem_phim($from_date, $to_date);
            case self::TK_TB_DK_SU_DUNG_DICH_VU:
                return self::getContent_tb_dk_su_dung_dich_vu($from_date, $to_date);
            case self::TK_NOI_DUNG_UPLOAD:
                return self::getContent_tk_noi_dung_upload($from_date, $to_date);
            case self::TK_NOI_DUNG_APPROVE:
                return self::getContent_tk_noi_dung_duyet($from_date, $to_date);
            case self::TK_SAN_LUONG:
                return self::getContent_tk_san_luong($from_date, $to_date);
//			case self::TK_SO_TB_LUY_KE:
//				return self::getContent_tk_so_tb_luy_ke($from_date, $to_date);
            case self::TK_TRANG_THAI_NOI_DUNG:
                return self::getContent_tk_trang_thai_noi_dung($from_date, $to_date);
            case self::TK_THUE_BAO:
                return self::getContent_tk_thue_bao($from_date, $to_date);
            case self::TK_DANG_KY:
                return self::getContent_tk_dang_ky($from_date, $to_date);
            case self::TK_TB_SU_DUNG_DICH_VU:
                return self::getContent_tk_tb_su_dung_dich_vu($from_date, $to_date);
            case self::TK_MOBILE_ADS:
                return self::getContent_tk_mobile_ads($from_date, $to_date, $partnerId);
            default:
                return self::getContent_tk_san_luong($from_date, $to_date);
        }
    }

    private function getContent_tk_san_luong($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $last5Trans = SubscriberTransaction::model()->findAllBySql("select * from subscriber_transaction order by id desc limit 5");
        foreach ($last5Trans as $transaction) {
            $result .= "<tr>";
            $result .= "<td style=\"text-align: center\">" . $transaction->create_date . "</td><td style=\"text-align: center\">" . $this->getLabelByAction($transaction->purchase_type) . "</td><td style=\"text-align: center\">" . $transaction->description . "</td><td style=\"text-align: center\">" . $this->getLabelByStatus($transaction->status) . "</td>" . "<td style=\"text-align: center\">" . $transaction->channel_type . "</td>" . "<td style=\"text-align: right\">" . intval($transaction->cost) . "</td>";
            $result .= "</tr>";
        }
        $result .= "</table>";
        $result .= "<br/><br/>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_doanh_thu_new($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table  id=\"datatable\" class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead id=\"data.head\">";
        $result .= "<tr>";
        $result .= "<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Ngày</th>";
        $result .= "<th colspan=\"9\" style=\"text-align: center\">Doanh thu gói cước</th>";
        $result .= "<th rowspan=\"1\" style=\"text-align: center;vertical-align:middle;\"  width=\"12%\">Doanh thu bán lẻ</th>";
        $result .= "<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\"  width=\"6%\">Tổng doanh thu</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th colspan=\"3\" style=\"text-align: center\" width=\"6%\">GÓI NGÀY</th>";
        $result .= "<th colspan=\"3\" style=\"text-align: center\" width=\"6%\">GÓI TUẦN</th>";
        $result .= "<th colspan=\"3\" style=\"text-align: center\" width=\"6%\">GÓI VTV</th>";
        $result .= "<th colspan=\"1\" rowspan=\"2\" style=\"text-align: center\" width=\"6%\">XEM</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">ĐK mới</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Gia hạn</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Truy thu</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">ĐK mới</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Gia hạn</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Truy thu</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">ĐK mới</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Gia hạn</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Truy thu</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        $resultReport = Revenue::report($from_date, $to_date);
        $lstRevenue = $resultReport['data'];
//        echo '<pre>';var_dump($lstRevenue);die;
        $totalRegister = 0;
        $totalRegister7 = 0;
        $totalRegisterVtv = 0;
        $totalExtend = 0;
        $totalExtend7 = 0;
        $totalExtendVtv = 0;
        $totalRetryExtend = 0;
        $totalRetryExtend7 = 0;
        $totalRetryExtendVtv = 0;
        $totalAll = 0;
        $totalView = 0;

        $data = array();
        $content = array();
        for ($i = 0; $i < count($lstRevenue); $i++) {
            $date = date('d-m-Y', strtotime($lstRevenue[$i]['create_date']));
            if ($lstRevenue[$i]['service_id'] != null) {
                $data = (array($date => array($lstRevenue[$i]['service_id'] => array($lstRevenue[$i]['register'], $lstRevenue[$i]['extend'], $lstRevenue[$i]['retry_extend']))));
                $content = array_merge_recursive($content, $data);
            }
            if ($lstRevenue[$i]['service_id'] == null) {
                $data = (array($date => array(null => array($lstRevenue[$i]['view'], $lstRevenue[$i]['download'], $lstRevenue[$i]['gift']))));
                $content = array_merge_recursive($content, $data);
            }
        }
        foreach ($content as $date => $service) {
            $result .= "<tr>";
            $result .= "<td style=\"text-align: center\">" . $date . "</td>";
            $totalNotService = 0;
            $totalRevenue = 0;
            foreach ($service as $service_id => $value) {
//                echo '<pre>';var_dump($value);die;
                if ($service_id != null) {
                    $result .= "<td style=\"text-align: center\">" . number_format($value[0]) .
                        "</td><td style=\"text-align: center\">" . number_format($value[1]) .
                        "</td><td style=\"text-align: center\">" . number_format($value[2]) . "</td>";
                    $totalRevenue += $value[0] + $value[1] + $value[2];
                }
                if ($service_id == null) {
                    $totalNotService =$value[0];
                    $totalView += $totalNotService;
                }
            }
            $result .= "<td style=\"text-align: center\">" . number_format($totalNotService) . "</td>";
            $result .= "<td style=\"text-align: center\">" . number_format($totalRevenue) . "</td>";
            $result .= "</tr>";
        }
        $totalRevenue = 0;
        $totalRevenue7 = 0;
        $totalRevenueVtv = 0;
        foreach ($content as $date => $service) {
            foreach ($service as $service_id => $value) {
                switch ($service_id) {
                    case 4:
                        $totalRegister += $value[0];
                        $totalExtend += $value[1];
                        $totalRetryExtend += $value[2];
                        $totalRevenue += $value[0] + $value[1] + $value[2];
                        break;
                    case 5:
                        $totalRegister7 += $value[0];
                        $totalExtend7 += $value[1];
                        $totalRetryExtend7 += $value[2];
                        $totalRevenue7 += $value[0] + $value[1] + $value[2];
                        break;
                    case 6:
                        $totalRegisterVtv += $value[0];
                        $totalExtendVtv += $value[1];
                        $totalRetryExtendVtv += $value[2];
                        $totalRevenueVtv += $value[0] + $value[1] + $value[2];
                        break;
                    default:
                        break;
                }
                $totalAll += $value[0] + $value[1] + $value[2];
            }
        }
        //revenue ngay hien tai
        $subscriberTransaction = Revenue::revenueToday($from_date, $to_date);
        if (count($subscriberTransaction) > 0) {
            $totalRegister += $subscriberTransaction->revenueRegister;
            $totalExtend += $subscriberTransaction->revenueExtend;
            $totalRetryExtend += $subscriberTransaction->revenueRetryExtend;
            $totalRegister7 += $subscriberTransaction->revenueRegister7;
            $totalExtend7 += $subscriberTransaction->revenueExtend7;
            $totalRetryExtend7 += $subscriberTransaction->revenueRetryExtend7;
            $totalRegisterVtv += $subscriberTransaction->revenueRegisterVtv;
            $totalExtendVtv += $subscriberTransaction->revenueExtendVtv;
            $totalRetryExtendVtv += $subscriberTransaction->revenueRetryExtendVtv;
            $totalRevenueNow = $subscriberTransaction->revenueRegister + $subscriberTransaction->revenueExtend +
                $subscriberTransaction->revenueRegister7 + $subscriberTransaction->revenueExtend7 +
                $subscriberTransaction->revenueRegisterVtv + $subscriberTransaction->revenueExtendVtv;
            $totalRevenue += $subscriberTransaction->revenueRegister + $subscriberTransaction->revenueExtend + $subscriberTransaction->revenueRetryExtend;
            $totalRevenue7 += $subscriberTransaction->revenueRegister7 + $subscriberTransaction->revenueExtend7 + $subscriberTransaction->revenueRetryExtend7;
            $totalRevenueVtv += $subscriberTransaction->revenueRegisterVtv + $subscriberTransaction->revenueExtendVtv + $subscriberTransaction->revenueRetryExtendVtv;
            $totalAll += $totalRevenueNow;
            $totalView += $subscriberTransaction->revenueView;
            $result .= "<tr>";
            $result .= "<td style=\"text-align: center\">" . date('d-m-Y') . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueRegister) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueExtend) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueRetryExtend) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueRegister7) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueExtend7) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueRetryExtend7) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueRegisterVtv) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueExtendVtv) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueRetryExtendVtv) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueView) . "</td><td style=\"text-align: center\">" .
                number_format($totalRevenueNow) . "</td>";
            $result .= "</tr>";
        }
        $result .= "</tbody>";
        $result .= "<thead id=\"data.foot\">";
        $result .= "<tr>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\">Tổng</th>
			<th style=\"text-align: center\">" . number_format($totalRegister) . "</th>
			<th style=\"text-align: center\">" . number_format($totalExtend) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRetryExtend) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegister7) . "</th>
			<th style=\"text-align: center\">" . number_format($totalExtend7) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRetryExtend7) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterVtv) . "</th>
			<th style=\"text-align: center\">" . number_format($totalExtendVtv) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRetryExtendVtv) . "</th>
			<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\">" . number_format($totalView) . "</th>
			<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\">" . number_format($totalAll) . "</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th colspan=\"3\" style=\"text-align: center\">" . number_format($totalRevenue) . "</th>
			<th colspan=\"3\" style=\"text-align: center\">" . number_format($totalRevenue7) . "</th>
			<th colspan=\"3\" style=\"text-align: center\">" . number_format($totalRevenueVtv) . "</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_doanh_thu_new123($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\"  width=\"6%\">Ngày</th>";
        $result .= "<th colspan=\"3\" style=\"text-align: center\">Doanh thu gói cước</th>";
        $result .= "<th rowspan=\"1\" style=\"text-align: center;vertical-align:middle;\"  width=\"12%\">Doanh thu bán lẻ</th>";
        $result .= "<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\"  width=\"6%\">Tổng doanh thu</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th colspan=\"3\" style=\"text-align: center\" width=\"6%\">PHIM7</th>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\" width=\"6%\">xem</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">ĐK mới</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Gia hạn</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Truy thu</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        $resultReport = Revenue::model()->report($from_date, $to_date);
        $lstRevenue = $resultReport['data'];
        $totalRegister = 0;
        $totalExtend = 0;
        $totalRetryExtend = 0;
        $totalAll = 0;
        $data = array();
        $content = array();
        $totalView = 0;
        for ($i = 0; $i < count($lstRevenue); $i++) {
            $date = date('d-m-Y', strtotime($lstRevenue[$i]['create_date']));
            if ($lstRevenue[$i]['service_id'] == SERVICE_2) {
                $totalRegister += $lstRevenue[$i]['register'];
                $totalExtend += $lstRevenue[$i]['extend'];
                $totalRetryExtend += $lstRevenue[$i]['retry_extend'];
                $totalAll += $lstRevenue[$i]['register'] + $lstRevenue[$i]['extend'] + $lstRevenue[$i]['retry_extend'];
// 					echo $totalAll;
                $data = (array($date => array($lstRevenue[$i]['register'], $lstRevenue[$i]['extend'], $lstRevenue[$i]['retry_extend'])));
                $content = array_merge_recursive($content, $data);
            }
            if ($lstRevenue[$i]['service_id'] == null) {
                $totalView += $lstRevenue[$i]['view'];
                $totalAll += $lstRevenue[$i]['view'];
// 					echo $totalAll;
                $data = (array($date => array($lstRevenue[$i]['view'])));
                $content = array_merge_recursive($content, $data);
            }

        }
        foreach ($content as $key => $value) {
            $totalRevenue = $value[0] + $value[1] + $value[2] + $value[3];
            $result .= "<tr>";
            $result .= "<td style=\"text-align: center\">" . $key . "</td><td style=\"text-align: center\">" . number_format($value[0]) .
                "</td><td style=\"text-align: center\">" . number_format($value[1]) .
                "</td><td style=\"text-align: center\">" . number_format($value[2]) .
                "</td>" . "<td style=\"text-align: center\">" . number_format($value[3]) .
                "</td>" . "<td style=\"text-align: center\">" . number_format($totalRevenue) . "</td>";
            $result .= "</tr>";
        }
        //revenue ngay hien tai
        $subscriberTransaction = Revenue::model()->revenueToday($from_date, $to_date);
        if (count($subscriberTransaction) > 0) {
            $totalRegister += $subscriberTransaction->revenueRegister;
            $totalExtend += $subscriberTransaction->revenueExtend;
            $totalRetryExtend += $subscriberTransaction->revenueRetryExtend;
            $totalView += $subscriberTransaction->revenueView;
            $totalAll += $subscriberTransaction->revenueTotal;
            $result .= "<tr>";
            $result .= "<td style=\"text-align: center\">" . date('d-m-Y') . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueRegister) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueExtend) . "</td><td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueRetryExtend) . "</td>" . "<td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueView) . "</td>" . "<td style=\"text-align: center\">" .
                number_format($subscriberTransaction->revenueTotal) . "</td>";
            $result .= "</tr>";
        }
        $result .= "</tbody>";
        $result .= "<thead id=\"data.foot\">";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Tổng</th><th style=\"text-align: center\">" .
            number_format($totalRegister) . "</th><th style=\"text-align: center\">" .
            number_format($totalExtend) . "</th><th style=\"text-align: center\">" .
            number_format($totalRetryExtend) . "</th>" . "<th style=\"text-align: center\">" .
            number_format($totalView) . "</th>" . "<th style=\"text-align: center\">" .
            number_format($totalAll) . "</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_ti_le_tru_tien($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"10%\">Trừ tiền thành công</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"10%\">Trừ tiền thất bại</th>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center\" width=\"10%\">Tổng</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\" width=\"10%\">Số lượng</th>";
        $result .= "<th style=\"text-align: center\" width=\"10%\">Tỉ lệ (%)</th>";
        $result .= "<th style=\"text-align: center\" width=\"10%\">Số lượng</th>";
        $result .= "<th style=\"text-align: center\" width=\"10%\">Tỉ lệ (%)</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $charginReport = ChargingReport::model()->getReport_tk_ti_le_tru_tien($from_date, $to_date);
        $chargingReportToday = SubscriberTransaction::model()->getReport_tk_ti_le_tru_tien($from_date, $to_date);
        $totalSuccess = 0;
        $totalFailed = 0;
        if (count($charginReport) > 0) {
            $totalSuccess += $charginReport->total_charging_success;
            $totalFailed += $charginReport->total_charging_failed;
        }
        if (count($chargingReportToday) > 0) {
            $totalSuccess += $chargingReportToday->revenue_number_success;
            $totalFailed += $chargingReportToday->revenue_number_failed;
        }
        if ($totalSuccess + $totalFailed == 0) {
            $percentSuccess = 0;
            $percentFailed = 0;
        } else {
            $percentSuccess = $totalSuccess * 100 / ($totalSuccess + $totalFailed);
            $percentFailed = $totalFailed * 100 / ($totalSuccess + $totalFailed);
        }
        $result .= "<tr>";
        $result .= "<td style=\"text-align: center\">" . number_format($totalSuccess) . "</td><td style=\"text-align: center\">" . number_format($percentSuccess) . "</td><td style=\"text-align: center\">" . number_format($totalFailed) . "</td><td style=\"text-align: center\">" . number_format($percentFailed) . "</td><td style=\"text-align: center\">" . number_format($totalSuccess + $totalFailed) . "</td>";
        $result .= "</tr>";
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_tong_thue_bao_kich_hoat($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\" width=\"10%\">Ngày kích hoạt</th>";
        $result .= "<th style=\"text-align: center\" width=\"10%\">Số thuê bao</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $totalSubscriber = 0;
        $subscriberReport = Subscriber::getReport_tk_thue_bao_kick_hoat($from_date, $to_date);
        if (count($subscriberReport) > 0) {
            for ($i = 0; $i < count($subscriberReport); $i++) {
// 				$date = date('d-m-Y', strtotime($subscriberReport[$i]['activated_date']));
                $date = $subscriberReport[$i]['activated_date'];
                $totalSubscriber += $subscriberReport[$i]['subscriber_activated_count'];
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $date . "</td><td style=\"text-align: center\">" . number_format($subscriberReport[$i]['subscriber_activated_count']) . "</td>";
                $result .= "</tr>";
            }
        }
        $result .= "</tbody>";
        $result .= "</tbody>";
        $result .= "<thead id=\"data.foot\">";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Tổng</th><th style=\"text-align: center\">" . number_format($totalSubscriber) . "</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

//    private function getContent_tk_san_luong_dich_vu($from_date, $to_date)
//    {
//        $result = "<html><body>";
//        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
//        $result .= "<thead>";
//        $result .= "<tr>";
//        $result .= "<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Ngày</th>";
//        $result .= "<th colspan=\"8\" style=\"text-align: center\">PHIM7</th>";
//        $result .= "<th rowspan=\"2\" colspan=\"2\" style=\"text-align: center; vertical-align:middle;\">Xem phim tính phí</th>";
//        $result .= "<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Số thuê bao phát sinh cước</th>";
//        $result .= "</tr>";
//        $result .= "<tr>";
//        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Đăng kí</th>";
//        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Gia hạn</th>";
//        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Hủy</th>";
//        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Truy Thu</th>";
//        $result .= "</tr>";
//        $result .= "<tr>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Bị hủy</th>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Chủ động hủy</th>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
//        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
//        $result .= "</tr>";
//        $result .= "</thead>";
//        $result .= "<tbody id=\"data.body\">";
//        //data here
//        $totalRegisterSuccess = 0;
//        $totalRegisterFailed = 0;
//        $totalExtendSuccess = 0;
//        $totalExtendFailed = 0;
//        $totalAutoCancel = 0;
//        $totalManualCancel = 0;
//        $totalSubscriberCharging = 0;
//        $totalRetryExtendSuccess = 0;
//        $totalRetryExtendFailed = 0;
//        $totalPayPerSuccess = 0;
//        $totalPayPerFailed = 0;
//        $generalReport = GeneralReport::model()->getReport_tk_san_luong_dich_vu($from_date, $to_date);
//        $numberSubcriberCharging = 0;
//        if (count($generalReport) > 0) {
//            for ($i = 0; $i < count($generalReport); $i++) {
//                if ($generalReport[$i]['service_id'] == SERVICE_2) {
//                    $totalRegisterSuccess += $generalReport[$i]['register_success_count'];
//                    $totalRegisterFailed += $generalReport[$i]['register_fail_count'];
//                    $totalExtendSuccess += $generalReport[$i]['extend_success_count'];
//                    $totalExtendFailed += $generalReport[$i]['extend_fail_count'];
//                    $totalAutoCancel += $generalReport[$i]['auto_cancel_count'];
//                    $totalManualCancel += $generalReport[$i]['manual_cancel_count'];
//                    $totalRetryExtendSuccess += $generalReport[$i]['retry_extend_success_count'];
//                    $totalRetryExtendFailed += $generalReport[$i]['retry_extend_failed_count'];
//                    $numberSubcriberCharging += $generalReport[$i]['register_success_count'] + $generalReport[$i]['extend_success_count'] + $generalReport[$i]['retry_extend_success_count'];
//                    $totalSubscriberCharging += $numberSubcriberCharging;
//                    $date = date('d/m/Y', strtotime($generalReport[$i]['report_date']));
//                    $result .= "<tr>";
//                    $result .= "<td style=\"text-align: center\">" . $date . "</td>
//					<td style=\"text-align: center\">" . number_format($generalReport[$i]['register_success_count']) . "</td>
//					<td style=\"text-align: center\">" . number_format($generalReport[$i]['register_fail_count']) . "</td>
//					<td style=\"text-align: center\">" . number_format($generalReport[$i]['extend_success_count']) . "</td>
//					<td style=\"text-align: center\">" . number_format($generalReport[$i]['extend_fail_count']) . "</td>
//					<td style=\"text-align: center\">" . number_format($generalReport[$i]['auto_cancel_count']) . "</td>
//					<td style=\"text-align: center\">" . number_format($generalReport[$i]['manual_cancel_count']) . "</td>
//					<td style=\"text-align: center\">" . number_format($generalReport[$i]['retry_extend_success_count']) . "</td>
//					<td style=\"text-align: center\">" . number_format($generalReport[$i]['retry_extend_failed_count']) . "</td>";
//                }
//                if ($generalReport[$i]['using_type'] == USING_TYPE_WATCH) {
//                    $numberSubcriberCharging += $generalReport[$i]['pay_per_video_success_count'];
//                    $totalSubscriberCharging += $generalReport[$i]['pay_per_video_success_count'];
//                    $totalPayPerSuccess += $generalReport[$i]['pay_per_video_success_count'];
//                    $totalPayPerFailed += $generalReport[$i]['pay_per_video_fail_count'];
//                    $result .= "<td style=\"text-align: center\">" . number_format($generalReport[$i]['pay_per_video_success_count']) . "</td>
//						<td style=\"text-align: center\">" . number_format($generalReport[$i]['pay_per_video_fail_count']) . "</td>
//						<td style=\"text-align: center\">" . number_format($numberSubcriberCharging) . "</td>";
//                    $result .= "</tr>";
//                    $numberSubcriberCharging = 0;
//                }
//            }
//        }
//        $result .= "</tbody>";
//        $result .= "<thead id=\"data.foot\">";
//        $result .= "<tr>";
//        $result .= "<th style=\"text-align: center\">Tổng</th><th style=\"text-align: center\">" . number_format($totalRegisterSuccess) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterFailed) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalExtendSuccess) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalExtendFailed) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalAutoCancel) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalManualCancel) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRetryExtendSuccess) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRetryExtendFailed) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalPayPerSuccess) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalPayPerFailed) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalSubscriberCharging) . "</th>";
//        $result .= "</tr>";
//        $result .= "</thead>";
//        $result .= "</table>";
//        $result .= "</body></html>";
//        return $result;
//    }
    private function getContent_tk_san_luong_dich_vu($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table id=\"datatable\" class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead id=\"data.head\">";
        $result .= "<tr>";
        $result .= "<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Ngày</th>";
        $result .= "<th colspan=\"6\" style=\"text-align: center\">NGÀY</th>";
        $result .= "<th colspan=\"6\" style=\"text-align: center\">TUẦN</th>";
        $result .= "<th colspan=\"6\" style=\"text-align: center\">VTV</th>";
        $result .= "<th rowspan=\"2\" colspan=\"2\" style=\"text-align: center; vertical-align:middle;\">Xem phim tính phí</th>";
        $result .= "<th rowspan=\"3\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Số thuê bao phát sinh cước</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Đăng kí</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Gia hạn</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Hủy</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Đăng kí</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Gia hạn</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Hủy</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Đăng kí</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Gia hạn</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\" width=\"6%\">Hủy</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Bị hủy</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Chủ động hủy</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Bị hủy</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Chủ động hủy</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Bị hủy</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Chủ động hủy</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thành công</th>";
        $result .= "<th style=\"text-align: center\" width=\"6%\">Thất bại</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $totalRegisterSuccessPhim = 0;
        $totalRegisterSuccessPhim7 = 0;
        $totalRegisterSuccessPhim30 = 0;
        $totalRegisterFailedPhim = 0;
        $totalRegisterFailedPhim7 = 0;
        $totalRegisterFailedPhim30 = 0;
        $totalExtendSuccessPhim = 0;
        $totalExtendSuccessPhim7 = 0;
        $totalExtendSuccessPhim30 = 0;
        $totalExtendFailedPhim = 0;
        $totalExtendFailedPhim7 = 0;
        $totalExtendFailedPhim30 = 0;
        $totalAutoCancelPhim = 0;
        $totalAutoCancelPhim7 = 0;
        $totalAutoCancelPhim30 = 0;
        $totalManualCancelPhim = 0;
        $totalManualCancelPhim7 = 0;
        $totalManualCancelPhim30 = 0;
        $totalSubscriberCharging = 0;
        $totalRetryExtendSuccessPhim = 0;
        $totalRetryExtendSuccessPhim7 = 0;
        $totalRetryExtendSuccessPhim30 = 0;
        $totalRetryExtendFailedPhim = 0;
        $totalRetryExtendFailedPhim7 = 0;
        $totalRetryExtendFailedPhim30 = 0;
        $totalPayPerSuccess = 0;
        $totalPayPerFailed = 0;
        $generalReport = GeneralReport::getReport_tk_san_luong_dich_vu($from_date, $to_date);
        $numberSubcriberCharging = 0;
        if (count($generalReport) > 0) {
            for ($i = 0; $i < count($generalReport); $i++) {
                if ($generalReport[$i]['service_id'] == SERVICE_1) {
                    $totalRegisterSuccessPhim += $generalReport[$i]['register_success_count'];
                    $totalRegisterFailedPhim += $generalReport[$i]['register_fail_count'];
                    $totalExtendSuccessPhim += $generalReport[$i]['extend_success_count'];
                    $totalExtendFailedPhim += $generalReport[$i]['extend_fail_count'];
                    $totalAutoCancelPhim += $generalReport[$i]['auto_cancel_count'];
                    $totalManualCancelPhim += $generalReport[$i]['manual_cancel_count'];
                    $totalRetryExtendSuccessPhim += $generalReport[$i]['retry_extend_success_count'];
                    $totalRetryExtendFailedPhim += $generalReport[$i]['retry_extend_failed_count'];
                    $numberSubcriberCharging += $generalReport[$i]['register_success_count'] + $generalReport[$i]['extend_success_count'] + $generalReport[$i]['retry_extend_success_count'];
                    $date = date('d/m/Y', strtotime($generalReport[$i]['report_date']));
                    $result .= "<tr>";
                    $result .= "<td style=\"text-align: center\">" . $date . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['register_success_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['register_fail_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['extend_success_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['extend_fail_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['auto_cancel_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['manual_cancel_count']) . "</td>";
                }
                if ($generalReport[$i]['service_id'] == SERVICE_2) {
                    $totalRegisterSuccessPhim7 += $generalReport[$i]['register_success_count'];
                    $totalRegisterFailedPhim7 += $generalReport[$i]['register_fail_count'];
                    $totalExtendSuccessPhim7 += $generalReport[$i]['extend_success_count'];
                    $totalExtendFailedPhim7 += $generalReport[$i]['extend_fail_count'];
                    $totalAutoCancelPhim7 += $generalReport[$i]['auto_cancel_count'];
                    $totalManualCancelPhim7 += $generalReport[$i]['manual_cancel_count'];
                    $totalRetryExtendSuccessPhim7 += $generalReport[$i]['retry_extend_success_count'];
                    $totalRetryExtendFailedPhim7 += $generalReport[$i]['retry_extend_failed_count'];
                    $numberSubcriberCharging += $generalReport[$i]['register_success_count'] + $generalReport[$i]['extend_success_count'] + $generalReport[$i]['retry_extend_success_count'];
                    $result .= "<td style=\"text-align: center\">" . number_format($generalReport[$i]['register_success_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['register_fail_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['extend_success_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['extend_fail_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['auto_cancel_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['manual_cancel_count']) . "</td>";
                }
                if ($generalReport[$i]['service_id'] == SERVICE_3) {
                    $totalRegisterSuccessPhim30 += $generalReport[$i]['register_success_count'];
                    $totalRegisterFailedPhim30 += $generalReport[$i]['register_fail_count'];
                    $totalExtendSuccessPhim30 += $generalReport[$i]['extend_success_count'];
                    $totalExtendFailedPhim30 += $generalReport[$i]['extend_fail_count'];
                    $totalAutoCancelPhim30 += $generalReport[$i]['auto_cancel_count'];
                    $totalManualCancelPhim30 += $generalReport[$i]['manual_cancel_count'];
                    $totalRetryExtendSuccessPhim30 += $generalReport[$i]['retry_extend_success_count'];
                    $totalRetryExtendFailedPhim30 += $generalReport[$i]['retry_extend_failed_count'];
                    $numberSubcriberCharging += $generalReport[$i]['register_success_count'] + $generalReport[$i]['extend_success_count'] + $generalReport[$i]['retry_extend_success_count'];
                    $result .= "<td style=\"text-align: center\">" . number_format($generalReport[$i]['register_success_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['register_fail_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['extend_success_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['extend_fail_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['auto_cancel_count']) . "</td>
					<td style=\"text-align: center\">" . number_format($generalReport[$i]['manual_cancel_count']) . "</td>";
                }
                if ($generalReport[$i]['using_type'] == USING_TYPE_WATCH) {
                    $numberSubcriberCharging += $generalReport[$i]['pay_per_video_success_count'];
                    $totalSubscriberCharging += $numberSubcriberCharging;
                    $totalPayPerSuccess += $generalReport[$i]['pay_per_video_success_count'];
                    $totalPayPerFailed += $generalReport[$i]['pay_per_video_fail_count'];
                    $result .= "<td style=\"text-align: center\">" . number_format($generalReport[$i]['pay_per_video_success_count']) . "</td>
						<td style=\"text-align: center\">" . number_format($generalReport[$i]['pay_per_video_fail_count']) . "</td>
						<td style=\"text-align: center\">" . number_format($numberSubcriberCharging) . "</td>";
                    $result .= "</tr>";
                    $numberSubcriberCharging = 0;
                }
            }
        }
        $result .= "</tbody>";
        $result .= "<thead id=\"data.foot\">";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Tổng</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterSuccessPhim) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterFailedPhim) . "</th>
			<th style=\"text-align: center\">" . number_format($totalExtendSuccessPhim) . "</th>
			<th style=\"text-align: center\">" . number_format($totalExtendFailedPhim) . "</th>
			<th style=\"text-align: center\">" . number_format($totalAutoCancelPhim) . "</th>
			<th style=\"text-align: center\">" . number_format($totalManualCancelPhim) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterSuccessPhim7) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterFailedPhim7) . "</th>
			<th style=\"text-align: center\">" . number_format($totalExtendSuccessPhim7) . "</th>
			<th style=\"text-align: center\">" . number_format($totalExtendFailedPhim7) . "</th>
			<th style=\"text-align: center\">" . number_format($totalAutoCancelPhim7) . "</th>
			<th style=\"text-align: center\">" . number_format($totalManualCancelPhim7) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterSuccessPhim30) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterFailedPhim30) . "</th>
			<th style=\"text-align: center\">" . number_format($totalExtendSuccessPhim30) . "</th>
			<th style=\"text-align: center\">" . number_format($totalExtendFailedPhim30) . "</th>
			<th style=\"text-align: center\">" . number_format($totalAutoCancelPhim30) . "</th>
			<th style=\"text-align: center\">" . number_format($totalManualCancelPhim30) . "</th>
			<th style=\"text-align: center\">" . number_format($totalPayPerSuccess) . "</th>
			<th style=\"text-align: center\">" . number_format($totalPayPerFailed) . "</th>
			<th style=\"text-align: center\">" . number_format($totalSubscriberCharging) . "</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_tong_dk_moi1($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Ngày</th>";
        $result .= "<th colspan=\"4\" style=\"text-align: center\">PHIM7</th>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Tổng thuê bao</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WAP</th>";
        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">SMS</th>";
        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">APP</th>";
        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WEB</th>";
        //$result .="<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WEB</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $lstNewSubscriber = NewSubscriberReport::getReport_tk_tong_dk_moi($from_date, $to_date);
        $totalRegisterWap = 0;
        $totalRegisterSms = 0;
        $totalRegisterApp = 0;
        $totalRegisterWeb = 0;
        $totalRegister = 0;
        if (count($lstNewSubscriber) > 0) {
            for ($i = 0; $i < count($lstNewSubscriber); $i++) {
                if ($lstNewSubscriber[$i]['service_id'] == SERVICE_2) {
                    $numRegister = 0;
                    $totalRegisterWap += $lstNewSubscriber[$i]['register_wap'];
                    $totalRegisterSms += $lstNewSubscriber[$i]['register_sms'];
                    $totalRegisterApp += $lstNewSubscriber[$i]['register_app'];
                    $totalRegisterWeb += $lstNewSubscriber[$i]['register_web'];
                    $numRegister += $lstNewSubscriber[$i]['register_wap'] + $lstNewSubscriber[$i]['register_sms'] + $lstNewSubscriber[$i]['register_app'] + $lstNewSubscriber[$i]['register_web'];
                    $totalRegister += $numRegister;
                    $date = date('d/m/Y', strtotime($lstNewSubscriber[$i]['create_date']));
                    $result .= "<tr>";
                    $result .= "<td style=\"text-align: center\">" . $date . "</td>
					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_wap']) . "</td>
					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_sms']) . "</td>
					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_app']) . "</td>
					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_web']) . "</td>
					<td style=\"text-align: center\">" . number_format($numRegister) . "</td>";
                    $result .= "</tr>";
                }
            }
        }
        $lstNewSubscriberToday = SubscriberTransaction::getReport_tong_dk_moi($from_date, $to_date);
        if (count($lstNewSubscriberToday) > 0) {
            $numRegister = 0;
            $totalRegisterWap += $lstNewSubscriberToday['wap_service_7'];
            $totalRegisterSms += $lstNewSubscriberToday['sms_service_7'];
            $totalRegisterApp += $lstNewSubscriberToday['app_service_7'];
            $totalRegisterWeb += $lstNewSubscriberToday['web_service_7'];
            $numRegister += $lstNewSubscriberToday['wap_service_7'] + $lstNewSubscriberToday['sms_service_7'] + $lstNewSubscriberToday['app_service_7'] + $lstNewSubscriberToday['web_service_7'];
            $totalRegister += $numRegister;
            $result .= "<tr>";
            $result .= "<td style=\"text-align: center\">" . $lstNewSubscriberToday['report_date'] . "</td>
				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['wap_service_7']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['sms_service_7']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['app_service_7']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['web_service_7']) . "</td>
				<td style=\"text-align: center\">" . number_format($numRegister) . "</td>";
            $result .= "</tr>";
        }
        $result .= "</tbody>";
        $result .= "<thead id=\"data.foot\">";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Tổng</th><th style=\"text-align: center\">" . number_format($totalRegisterWap) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterSms) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterApp) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterWeb) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegister) . "</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_tong_dk_moi($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Ngày</th>";
        $result .= "<th colspan=\"5\" style=\"text-align: center\">PHIM7</th>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Tổng thuê bao</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WAP</th>";
        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">SMS</th>";
        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">APP</th>";
        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WEB</th>";
        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">API</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $lstNewSubscriber = NewSubscriberReport::getReport_tk_tong_dk_moi($from_date, $to_date);
        $totalRegisterWap = 0;
        $totalRegisterSms = 0;
        $totalRegisterApp = 0;
        $totalRegisterWeb = 0;
        $totalRegister = 0;
        $totalRegisterKm = 0;
        if (count($lstNewSubscriber) > 0) {
            for ($i = 0; $i < count($lstNewSubscriber); $i++) {
                if ($lstNewSubscriber[$i]['service_id'] == SERVICE_2) {
                    $numRegister = 0;
                    $totalRegisterWap += $lstNewSubscriber[$i]['register_wap'];
                    $totalRegisterSms += $lstNewSubscriber[$i]['register_sms'];
                    $totalRegisterApp += $lstNewSubscriber[$i]['register_app'];
                    $totalRegisterWeb += $lstNewSubscriber[$i]['register_web'];
                    $totalRegisterKm += $lstNewSubscriber[$i]['register_km'];
                    $numRegister += $lstNewSubscriber[$i]['register_wap'] + $lstNewSubscriber[$i]['register_sms'] + $lstNewSubscriber[$i]['register_app'] + $lstNewSubscriber[$i]['register_web'] + $lstNewSubscriber[$i]['register_km'];
                    $totalRegister += $numRegister;
                    $date = date('d/m/Y', strtotime($lstNewSubscriber[$i]['create_date']));
                    $result .= "<tr>";
                    $result .= "<td style=\"text-align: center\">" . $date . "</td>
					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_wap']) . "</td>
					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_sms']) . "</td>
					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_app']) . "</td>
					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_web']) . "</td>
					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_km']) . "</td>
					<td style=\"text-align: center\">" . number_format($numRegister) . "</td>";
                    $result .= "</tr>";
                }
            }
        }
        $lstNewSubscriberToday = SubscriberTransaction::getReport_tong_dk_moi($from_date, $to_date);
        if (count($lstNewSubscriberToday) > 0) {
            $numRegister = 0;
            $totalRegisterWap += $lstNewSubscriberToday['wap_service_7'];
            $totalRegisterSms += $lstNewSubscriberToday['sms_service_7'];
            $totalRegisterApp += $lstNewSubscriberToday['app_service_7'];
            $totalRegisterWeb += $lstNewSubscriberToday['web_service_7'];
            $totalRegisterKm += $lstNewSubscriberToday['km_service_7'];
            $numRegister += $lstNewSubscriberToday['wap_service_7'] + $lstNewSubscriberToday['sms_service_7'] + $lstNewSubscriberToday['app_service_7'] + $lstNewSubscriberToday['web_service_7'] + $lstNewSubscriberToday['km_service_7'];
            $totalRegister += $numRegister;
            $result .= "<tr>";
            $result .= "<td style=\"text-align: center\">" . $lstNewSubscriberToday['report_date'] . "</td>
				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['wap_service_7']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['sms_service_7']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['app_service_7']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['web_service_7']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['km_service_7']) . "</td>
				<td style=\"text-align: center\">" . number_format($numRegister) . "</td>";
            $result .= "</tr>";
        }
        $result .= "</tbody>";
        $result .= "<thead id=\"data.foot\">";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Tổng</th><th style=\"text-align: center\">" . number_format($totalRegisterWap) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterSms) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterApp) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterWeb) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegisterKm) . "</th>
			<th style=\"text-align: center\">" . number_format($totalRegister) . "</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

//    private function getContent_tk_tong_dk_moi($from_date, $to_date)
//    {
//        $result = "<html><body>";
//        $result .= "<table id=\"datatable\" class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
//        $result .= "<thead id=\"data.head\">";
//        $result .= "<tr>";
//        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Ngày</th>";
//        $result .= "<th colspan=\"4\" style=\"text-align: center\">PHIM</th>";
//        $result .= "<th colspan=\"4\" style=\"text-align: center\">PHIM7</th>";
//        $result .= "<th colspan=\"4\" style=\"text-align: center\">PHIM30</th>";
//        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\"  width=\"10%\">Tổng thuê bao</th>";
//        $result .= "</tr>";
//        $result .= "<tr>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WAP</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">SMS</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">APP</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WEB</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WAP</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">SMS</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">APP</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WEB</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WAP</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">SMS</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">APP</th>";
//        $result .= "<th colspan=\"1\" style=\"text-align: center\" width=\"6%\">WEB</th>";
//        $result .= "</tr>";
//        $result .= "</thead>";
//        $result .= "<tbody id=\"data.body\">";
//        //data here
//        $lstNewSubscriber = NewSubscriberReport::getReport_tk_tong_dk_moi($from_date, $to_date);
//        $totalRegisterWapPhim = 0;
//        $totalRegisterWapPhim7 = 0;
//        $totalRegisterWapPhim30 = 0;
//        $totalRegisterSmsPhim = 0;
//        $totalRegisterSmsPhim7 = 0;
//        $totalRegisterSmsPhim30 = 0;
//        $totalRegisterAppPhim = 0;
//        $totalRegisterAppPhim7 = 0;
//        $totalRegisterAppPhim30 = 0;
//        $totalRegisterWebPhim = 0;
//        $totalRegisterWebPhim7 = 0;
//        $totalRegisterWebPhim30 = 0;
//        $totalRegisterPhim = 0;
//        $totalRegisterPhim7 = 0;
//        $totalRegisterPhim30 = 0;
//        $totalRegister = 0;
//
//        if (count($lstNewSubscriber) > 0) {
//            for ($i = 0; $i < count($lstNewSubscriber); $i++) {
//                if ($lstNewSubscriber[$i]['service_id'] == SERVICE_1) {
//                    $totalRegisterWapPhim += $lstNewSubscriber[$i]['register_wap'];
//                    $totalRegisterSmsPhim += $lstNewSubscriber[$i]['register_sms'];
//                    $totalRegisterAppPhim += $lstNewSubscriber[$i]['register_app'];
//                    $totalRegisterWebPhim += $lstNewSubscriber[$i]['register_web'];
//                    $totalRegisterPhim += $lstNewSubscriber[$i]['register_wap'] + $lstNewSubscriber[$i]['register_sms'] + $lstNewSubscriber[$i]['register_app'] + $lstNewSubscriber[$i]['register_web'];
//                    $numRegister += $lstNewSubscriber[$i]['register_wap'] + $lstNewSubscriber[$i]['register_sms'] + $lstNewSubscriber[$i]['register_app'] + $lstNewSubscriber[$i]['register_web'];
//                    $date = date('d/m/Y', strtotime($lstNewSubscriber[$i]['create_date']));
//                    $result .= "<tr>";
//                    $result .= "<td style=\"text-align: center\">" . $date . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_wap']) . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_sms']) . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_app']) . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_web']) . "</td>";
//                }
//                if ($lstNewSubscriber[$i]['service_id'] == SERVICE_2) {
//                    $numRegister = 0;
//                    $totalRegisterWapPhim7 += $lstNewSubscriber[$i]['register_wap'];
//                    $totalRegisterSmsPhim7 += $lstNewSubscriber[$i]['register_sms'];
//                    $totalRegisterAppPhim7 += $lstNewSubscriber[$i]['register_app'];
//                    $totalRegisterWebPhim7 += $lstNewSubscriber[$i]['register_web'];
//                    $totalRegisterPhim7 += $lstNewSubscriber[$i]['register_wap'] + $lstNewSubscriber[$i]['register_sms'] + $lstNewSubscriber[$i]['register_app'] + $lstNewSubscriber[$i]['register_web'];
//                    $numRegister += $lstNewSubscriber[$i]['register_wap'] + $lstNewSubscriber[$i]['register_sms'] + $lstNewSubscriber[$i]['register_app'] + $lstNewSubscriber[$i]['register_web'];
//                    $result .= "<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_wap']) . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_sms']) . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_app']) . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_web']) . "</td>";
//                }
//                if ($lstNewSubscriber[$i]['service_id'] == SERVICE_3) {
//                    $totalRegisterWapPhim30 += $lstNewSubscriber[$i]['register_wap'];
//                    $totalRegisterSmsPhim30 += $lstNewSubscriber[$i]['register_sms'];
//                    $totalRegisterAppPhim30 += $lstNewSubscriber[$i]['register_app'];
//                    $totalRegisterWebPhim30 += $lstNewSubscriber[$i]['register_web'];
//                    $totalRegisterPhim30 += $lstNewSubscriber[$i]['register_wap'] + $lstNewSubscriber[$i]['register_sms'] + $lstNewSubscriber[$i]['register_app'] + $lstNewSubscriber[$i]['register_web'];
//                    $numRegister += $lstNewSubscriber[$i]['register_wap'] + $lstNewSubscriber[$i]['register_sms'] + $lstNewSubscriber[$i]['register_app'] + $lstNewSubscriber[$i]['register_web'];
//                    $totalRegister += $numRegister;
//                    $result .= "<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_wap']) . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_sms']) . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_app']) . "</td>
//					<td style=\"text-align: center\">" . number_format($lstNewSubscriber[$i]['register_web']) . "</td>
//					<td style=\"text-align: center\">" . number_format($numRegister) . "</td>";
//                    $result .= "</tr>";
//                }
//            }
//        }
//        $lstNewSubscriberToday = SubscriberTransaction::getReport_tong_dk_moi($from_date, $to_date);
//        if (count($lstNewSubscriberToday) > 0) {
//            $numRegister = 0;
//            $totalRegisterWapPhim += $lstNewSubscriberToday['wap_service_1'];
//            $totalRegisterSmsPhim += $lstNewSubscriberToday['sms_service_1'];
//            $totalRegisterAppPhim += $lstNewSubscriberToday['app_service_1'];
//            $totalRegisterWebPhim += $lstNewSubscriberToday['web_service_1'];
//            $totalRegisterWapPhim7 += $lstNewSubscriberToday['wap_service_7'];
//            $totalRegisterSmsPhim7 += $lstNewSubscriberToday['sms_service_7'];
//            $totalRegisterAppPhim7 += $lstNewSubscriberToday['app_service_7'];
//            $totalRegisterWebPhim7 += $lstNewSubscriberToday['web_service_7'];
//            $totalRegisterWapPhim30 += $lstNewSubscriberToday['wap_service_30'];
//            $totalRegisterSmsPhim30 += $lstNewSubscriberToday['sms_service_30'];
//            $totalRegisterAppPhim30 += $lstNewSubscriberToday['app_service_30'];
//            $totalRegisterWebPhim30 += $lstNewSubscriberToday['web_service_30'];
//            $totalRegisterPhim += $lstNewSubscriberToday['wap_service_1'] + $lstNewSubscriberToday['sms_service_1'] + $lstNewSubscriberToday['app_service_1'] + $lstNewSubscriberToday['web_service_1'];
//            $totalRegisterPhim7 += $lstNewSubscriberToday['wap_service_7'] + $lstNewSubscriberToday['sms_service_7'] + $lstNewSubscriberToday['app_service_7'] + $lstNewSubscriberToday['web_service_7'];
//            $totalRegisterPhim30 += $lstNewSubscriberToday['wap_service_30'] + $lstNewSubscriberToday['sms_service_30'] + $lstNewSubscriberToday['app_service_30'] + $lstNewSubscriberToday['web_service_30'];
//            $numRegister += $lstNewSubscriberToday['wap_service_1'] + $lstNewSubscriberToday['sms_service_1'] + $lstNewSubscriberToday['app_service_1'] + $lstNewSubscriberToday['web_service_1'] +
//                $lstNewSubscriberToday['wap_service_7'] + $lstNewSubscriberToday['sms_service_7'] + $lstNewSubscriberToday['app_service_7'] + $lstNewSubscriberToday['web_service_7'] +
//                $lstNewSubscriberToday['wap_service_30'] + $lstNewSubscriberToday['sms_service_30'] + $lstNewSubscriberToday['app_service_30'] + $lstNewSubscriberToday['web_service_30'];
//            $totalRegister += $numRegister;
//            $result .= "<tr>";
//            $result .= "<td style=\"text-align: center\">" . $lstNewSubscriberToday['report_date'] . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['wap_service_1']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['sms_service_1']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['app_service_1']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['web_service_1']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['wap_service_7']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['sms_service_7']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['app_service_7']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['web_service_7']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['wap_service_30']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['sms_service_30']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['app_service_30']) . "</td>
//				<td style=\"text-align: center\">" . number_format($lstNewSubscriberToday['web_service_30']) . "</td>
//				<td style=\"text-align: center\">" . number_format($numRegister) . "</td>";
//            $result .= "</tr>";
//        }
//        $result .= "</tbody>";
//        $result .= "<thead id=\"data.foot\">";
//        $result .= "<tr>";
//        $result .= "<th rowspan=\"2\" style=\"text-align: center\">Tổng</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterWapPhim) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterSmsPhim) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterAppPhim) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterWebPhim) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterWapPhim7) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterSmsPhim7) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterAppPhim7) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterWebPhim7) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterWapPhim30) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterSmsPhim30) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterAppPhim30) . "</th>
//			<th style=\"text-align: center\">" . number_format($totalRegisterWebPhim30) . "</th>
//			<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\">" . number_format($totalRegister) . "</th>";
//        $result .= "</tr>";
//        $result .= "<tr>";
//        $result .= "<th colspan=\"4\" style=\"text-align: center\">" . number_format($totalRegisterPhim) . "</th>
//			<th colspan=\"4\" style=\"text-align: center\">" . number_format($totalRegisterPhim7) . "</th>
//			<th colspan=\"4\" style=\"text-align: center\">" . number_format($totalRegisterPhim30) . "</th>";
//        $result .= "</tr>";
//        $result .= "</thead>";
//        $result .= "</table>";
//        $result .= "</body></html>";
//        return $result;
//    }

//    private function getContent_tb_dk_su_dung_dich_vu($from_date, $to_date)
//    {
//        $result = "<html><body>";
//        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
//        $result .= "<thead>";
//        $result .= "<tr>";
//        $result .= "<th style=\"text-align: center\"  width=\"40%\">Ngày</th>";
//        $result .= "<th style=\"text-align: center\">PHIM7</th>";
//        $result .= "</tr>";
//        $result .= "</thead>";
//        $result .= "<tbody id=\"data.body\">";
//        //data here
//        $lstSubscriberUseService = ServiceSubscriberReport::model()->getReport_tb_dk_su_dung_dich_vu($from_date, $to_date);
//        if (count($lstSubscriberUseService) > 0) {
//            for ($i = 0; $i < count($lstSubscriberUseService); $i++) {
//                $date = date('d/m/Y', strtotime($lstSubscriberUseService[$i]['create_date']));
//                $result .= "<tr>";
//                $result .= "<td style=\"text-align: center\">" . $date . "</td>
//				<td style=\"text-align: center\">" . number_format($lstSubscriberUseService[$i]['phim7']) . "</td>";
//                $result .= "</tr>";
//            }
//        }
//        $result .= "</tbody>";
//        $result .= "</table>";
//        $result .= "</body></html>";
//        return $result;
//    }
    private function getContent_tb_dk_su_dung_dich_vu($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table id=\"datatable\" class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead id=\"data.head\">";
        $result .= "<tr>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\"  width=\"12%\">Ngày</th>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\">NGÀY</th>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\">TUẦN</th>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center;vertical-align:middle;\">VTV</th>";
        $result .= "<th colspan=\"3\" style=\"text-align: center\">Gia hạn lỗi</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">NGÀY</th>";
        $result .= "<th style=\"text-align: center\">TUẦN</th>";
        $result .= "<th style=\"text-align: center\">VTV</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $lstSubscriberUseService = ServiceSubscriberReport::getReport_tb_dk_su_dung_dich_vu($from_date, $to_date);
        if (count($lstSubscriberUseService) > 0) {
            for ($i = 0; $i < count($lstSubscriberUseService); $i++) {
                $date = date('d/m/Y', strtotime($lstSubscriberUseService[$i]['create_date']));
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $date . "</td>
				<td style=\"text-align: center\">" . number_format($lstSubscriberUseService[$i]['phim']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstSubscriberUseService[$i]['phim7']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstSubscriberUseService[$i]['phim30']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstSubscriberUseService[$i]['failed_extend_phim']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstSubscriberUseService[$i]['failed_extend_phim7']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstSubscriberUseService[$i]['failed_extend_phim30']) . "</td>";
                $result .= "</tr>";
            }
        }
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_noi_dung_upload($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\"  width=\"25%\">Ngày</th>";
        $result .= "<th style=\"text-align: center\">Phim lẻ</th>";
        $result .= "<th style=\"text-align: center\">Phim bộ</th>";
        $result .= "<th style=\"text-align: center\">Tổng nội dung upload</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $user = User::model()->findByPk(Yii::app()->user->id);
        $lstContent = VodAsset::getReport_tk_noi_dung_upload($from_date, $to_date, $user->content_provider_id);
        $total = 0;
        $totalContentSeries = 0;
        $totalContentNotSeries = 0;
        if (count($lstContent) > 0) {
            for ($i = 0; $i < count($lstContent); $i++) {
                $totalSeries = 0;
                $totalNotSeries = 0;
                $totalContent = 0;
                $totalSeries += $lstContent[$i]['series_content_upload'];
                $totalNotSeries += $lstContent[$i]['not_series_content_upload'];
                $totalContent += $lstContent[$i]['series_content_upload'] + $lstContent[$i]['not_series_content_upload'];
                $totalContentSeries += $lstContent[$i]['series_content_upload'];
                $totalContentNotSeries += $lstContent[$i]['not_series_content_upload'];
                $total += $totalSeries + $totalNotSeries;
                $date = DateTime::createFromFormat('d/m/Y', $lstContent[$i]['upload_date']);
                $startDate = CUtils::getStartDate($date->format('Y-m-d'));
                $endDate = CUtils::getEndDate($date->format('Y-m-d'));
                $url = Yii::app()->baseUrl . "/vodAsset/viewContent?startDate=" . $startDate . "&endDate=" . $endDate . "&upload=true";
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $lstContent[$i]['upload_date'] . "</td>
				<td style=\"text-align: center\">" . number_format($lstContent[$i]['not_series_content_upload']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstContent[$i]['series_content_upload']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalContent) . "</td>";
                $result .= "</tr>";
//				<td style=\"text-align: center\">"."<a href=\"$url\">".number_format($totalContent)."</a>"."</td>";
            }
        }
        $result .= "</tbody>";
        $result .= "<thead id=\"data.foot\">";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Tổng</th>
			<th style=\"text-align: center\">" . number_format($totalContentNotSeries) . "</th>
			<th style=\"text-align: center\">" . number_format($totalContentSeries) . "</th>
			<th style=\"text-align: center\">" . number_format($total) . "</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_noi_dung_duyet($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\"  width=\"25%\">Ngày</th>";
        $result .= "<th style=\"text-align: center\">Phim lẻ</th>";
        $result .= "<th style=\"text-align: center\">Phim bộ</th>";
        $result .= "<th style=\"text-align: center\">Tổng nội dung duyệt</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $user = User::model()->findByPk(Yii::app()->user->id);
        $lstContent = VodAsset::getReport_tk_noi_dung_duyet($from_date, $to_date, $user->content_provider_id);
        $total = 0;
        $totalContentSeries = 0;
        $totalContentNotSeries = 0;
        if (count($lstContent) > 0) {
            for ($i = 0; $i < count($lstContent); $i++) {
                $totalSeries = 0;
                $totalNotSeries = 0;
                $totalContent = 0;
                $totalSeries += $lstContent[$i]['series_content_approve'];
                $totalNotSeries += $lstContent[$i]['not_series_content_approve'];
                $totalContent += $lstContent[$i]['series_content_approve'] + $lstContent[$i]['not_series_content_approve'];
                $totalContentSeries += $lstContent[$i]['series_content_approve'];
                $totalContentNotSeries += $lstContent[$i]['not_series_content_approve'];
                $total += $totalSeries + $totalNotSeries;
                $date = DateTime::createFromFormat('d/m/Y', $lstContent[$i]['upload_date']);
                $startDate = CUtils::getStartDate($date->format('Y-m-d'));
                $endDate = CUtils::getEndDate($date->format('Y-m-d'));
                $url = Yii::app()->baseUrl . "/vodAsset/viewContent?startDate=" . $startDate . "&endDate=" . $endDate . "&upload=flase";
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $lstContent[$i]['approve_date'] . "</td>
				<td style=\"text-align: center\">" . number_format($lstContent[$i]['not_series_content_approve']) . "</td>
				<td style=\"text-align: center\">" . number_format($lstContent[$i]['series_content_approve']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalContent) . "</td>";
                $result .= "</tr>";
//				<td style=\"text-align: center\">"."<a href=\"$url\">".number_format($totalContent)."</a>"."</td>";
            }
        }
        $result .= "</tbody>";
        $result .= "<thead id=\"data.foot\">";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Tổng</th>
			<th style=\"text-align: center\">" . number_format($totalContentNotSeries) . "</th>
			<th style=\"text-align: center\">" . number_format($totalContentSeries) . "</th>
			<th style=\"text-align: center\">" . number_format($total) . "</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_mua_phim($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\"  width=\"25%\">Nhà cung cấp</th>";
        $result .= "<th style=\"text-align: center\">Số lượt mua</th>";
        $result .= "<th style=\"text-align: center\">Số lượng thuê bao</th>";
        $result .= "<th style=\"text-align: center\">Doanh thu</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $user = User::model()->findByPk(Yii::app()->user->id);
        $reportContent = SubscriberTransaction::getReport_tk_mua_phim($from_date, $to_date, $user->content_provider_id);
        if (count($reportContent) > 0) {
            foreach ($reportContent as $provider => $value) {
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $provider . "</td>
				<td style=\"text-align: center\">" . number_format($value[0]) . "</td>
				<td style=\"text-align: center\">" . number_format($value[1]) . "</td>
				<td style=\"text-align: center\">" . number_format($value[2]) . "</td>";
                $result .= "</tr>";
            }
        }
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_xem_phim($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\"  width=\"25%\">Nhà cung cấp</th>";
        $result .= "<th style=\"text-align: center\">Số lượt xem</th>";
        $result .= "<th style=\"text-align: center\">Số lượng thuê bao</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $user = User::model()->findByPk(Yii::app()->user->id);
        $reportContent = VodView::getReport_tk_xem_phim($from_date, $to_date, $user->content_provider_id);
        if (count($reportContent) > 0) {
            foreach ($reportContent as $provider => $value) {
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $provider . "</td>
				<td style=\"text-align: center\">" . number_format($value[0]) . "</td>
				<td style=\"text-align: center\">" . number_format($value[1]) . "</td>";
                $result .= "</tr>";
            }
        }
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_trang_thai_noi_dung($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\"  width=\"25%\">Nhà cung cấp</th>";
        $result .= "<th style=\"text-align: center\">Đang sử dụng</th>";
        $result .= "<th style=\"text-align: center\">Ngưng sử dụng</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $user = User::model()->findByPk(Yii::app()->user->id);
        $reportContent = VodAsset::getReport_tk_trang_thai_noi_dung($from_date, $to_date, $user->content_provider_id);
        if (count($reportContent) > 0) {
            foreach ($reportContent as $provider => $value) {
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $provider . "</td>
				<td style=\"text-align: center\">" . number_format($value[0]) . "</td>
				<td style=\"text-align: center\">" . number_format($value[1]) . "</td>";
                $result .= "</tr>";
            }
        }
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_thue_bao($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\"  >Ngày</th>";
        $result .= "<th style=\"text-align: center\">Số TB hoạt động</th>";
        $result .= "<th style=\"text-align: center\">Số TB đăng ký thành công</th>";
        $result .= "<th style=\"text-align: center\">Số TB cần gia hạn</th>";
        $result .= "<th style=\"text-align: center\">Số TB gia hạn thành công</th>";
        $result .= "<th style=\"text-align: center\">Tổng số TB hủy</th>";
        $result .= "<th style=\"text-align: center\">Tổng số TB bị hủy</th>";
        $result .= "<th style=\"text-align: center\">Tổng số TB tự hủy</th>";
        $result .= "<th style=\"text-align: center\">Tổng số cần gia hạn tiếp</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $totalReport = TotalReport::getReport_tk_thue_bao($from_date, $to_date);
        if (count($totalReport) > 0) {
            for ($i = 0; $i < count($totalReport); $i++) {
                $date = date('d/m/Y', strtotime($totalReport[$i]['create_date']));
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $date . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_dang_kich_hoat']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_dk_moi_trong_ngay']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_can_gia_han']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_gia_han_tc']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_huy_dv']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_bi_huy']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_huy_dv'] - $totalReport[$i]['tong_so_tb_bi_huy']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_can_truy_thu']) . "</td>";
                $result .= "</tr>";
            }
        }
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_dang_ky($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center\">Ngày</th>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center\">Tổng lượt đăng ký</th>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center\">Tổng số TB đk Free</th>";
        $result .= "<th colspan=\"5\" style=\"text-align: center\">Tổng số TB đăng ký thành công</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Đk mất cước</th>";
        $result .= "<th style=\"text-align: center\">Qua SMS</th>";
        $result .= "<th style=\"text-align: center\">Qua Wap</th>";
        $result .= "<th style=\"text-align: center\">Qua App</th>";
        $result .= "<th style=\"text-align: center\">Qua Mobile Adds</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $totalReport = TotalReport::getReport_tk_thue_bao($from_date, $to_date);
        if (count($totalReport) > 0) {
            for ($i = 0; $i < count($totalReport); $i++) {
                $date = date('d/m/Y', strtotime($totalReport[$i]['create_date']));
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $date . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['so_luot_dk_tb_moi']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['so_tb_dk_ctkm_phim7']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_dk_moi_trong_ngay'] - $totalReport[$i]['so_tb_dk_ctkm_phim7']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['so_tb_dk_qua_sms']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['so_tb_dk_qua_wap']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['so_tb_dk_qua_app']) . "</td>
				<td style=\"text-align: center\">" . number_format(0) . "</td>";
                $result .= "</tr>";
            }
        }
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_tb_su_dung_dich_vu($from_date, $to_date)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th rowspan=\"2\" style=\"text-align: center\">Ngày</th>";
        $result .= "<th colspan=\"2\" style=\"text-align: center\">Tổng số TB sử dụng dịch vụ</th>";
        $result .= "</tr>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">TB đk gói cước</th>";
        $result .= "<th style=\"text-align: center\">TB không đk gói cước</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $totalReport = TotalReport::getReport_tk_thue_bao($from_date, $to_date);
        if (count($totalReport) > 0) {
            for ($i = 0; $i < count($totalReport); $i++) {
                $date = date('d/m/Y', strtotime($totalReport[$i]['create_date']));
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $date . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_dk_truy_cap']) . "</td>
				<td style=\"text-align: center\">" . number_format($totalReport[$i]['tong_so_tb_chua_dk_truy_cap']) . "</td>";
                $result .= "</tr>";
            }
        }
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_mobile_ads1($from_date, $to_date, $partnerId)
    {
        if ($partnerId == null) return;
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Ngày</th>";
        $result .= "<th style=\"text-align: center\">Số lượt click</th>";
        $result .= "<th style=\"text-align: center\">Số lượt click không trùng IP</th>";
        $result .= "<th style=\"text-align: center\">Số lượt click nhận diện được</th>";
        $result .= "<th style=\"text-align: center\">Số lượt click nhận diện được không trùng IP</th>";
        $result .= "<th style=\"text-align: center\">Số lượt đăng ký thành công</th>";
        $result .= "<th style=\"text-align: center\">Số lượt hủy sau 1 chu kỳ</th>";
        $result .= "<th style=\"text-align: center\">Số lượt gia hạn đến 3 chu kỳ cước</th>";
        $result .= "<th style=\"text-align: center\">Số lượt gia hạn không thành công</th>";
//    				$result .="<th style=\"text-align: center\">Doanh thu đăng ký</th>"; 
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $activityLog = SubscriberActivityLog::getReport_tk_mobile_ads($from_date, $to_date, $partnerId);
        $ssm = ServiceSubscriberMapping::getReport_tk_mobile_ads_register($from_date, $to_date, $partnerId);
        $ssm1 = ServiceSubscriberMapping::getReport_tk_mobile_ads_cycle($from_date, $to_date, $partnerId);

        $date = date('Y-m-d', strtotime($from_date));
        $endDate = date('Y-m-d', strtotime($to_date));
        //				$date = date('d/m/Y', strtotime($activityLog[$i]['report_date']));
        while (strtotime($date) <= strtotime($endDate)) {
            $is_activityLog = false;
            $is_ssm = false;
            $is_ssm1 = false;
            $result .= "<tr>";
            $result .= "<td style=\"text-align: center\">" . date('d/m/Y', strtotime($date)) . "</td>";
            if (count($activityLog) > 0) {
                for ($i = 0; $i < count($activityLog); $i++) {
                    if (strtotime($date) == strtotime($activityLog[$i]['report_date'])) {
                        $is_activityLog = true;
                        $result .= "<td style=\"text-align: center\">" . number_format($activityLog[$i]['total_click']) . "</td>
							<td style=\"text-align: center\">" . number_format($activityLog[$i]['not_coincide_ip']) . "</td>
							<td style=\"text-align: center\">" . number_format($activityLog[$i]['count_subscriber']) . "</td>
							<td style=\"text-align: center\">" . number_format($activityLog[$i]['count_ip_not_coincide']) . "</td>";
                    }
                }
                if (!$is_activityLog) {
                    $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>
						<td style=\"text-align: center\">" . number_format(0) . "</td>
						<td style=\"text-align: center\">" . number_format(0) . "</td>
						<td style=\"text-align: center\">" . number_format(0) . "</td>";
                }
            } else {
                $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>
						<td style=\"text-align: center\">" . number_format(0) . "</td>
						<td style=\"text-align: center\">" . number_format(0) . "</td>
						<td style=\"text-align: center\">" . number_format(0) . "</td>";
            }
            if (count($ssm) > 0) {
                for ($i = 0; $i < count($ssm); $i++) {
                    if (strtotime($date) === strtotime($ssm[$i]['report_date'])) {
                        $is_ssm = true;
                        $result .= "<td style=\"text-align: center\">" . number_format($ssm[$i]['count_register']) . "</td>";
                    }
                }
                if (!$is_ssm) {
                    $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>";
                }
            } else {
                $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>";
            }
            if (count($ssm1) > 0) {
                for ($i = 0; $i < count($ssm1); $i++) {
                    if (strtotime($date) === strtotime($ssm1[$i]['report_date'])) {
                        $is_ssm = true;
                        $result .= "<td style=\"text-align: center\">" . number_format($ssm1[$i]['count_cancel_after_one_cycle']) . "</td>";
                        $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>";
                        $result .= "<td style=\"text-align: center\">" . number_format($ssm1[$i]['count_recur_failed']) . "</td>";
                    }
                }
                if (!$is_ssm) {
                    $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>";
                    $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>";
                    $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>";
                }
            } else {
                $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>";
                $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>";
                $result .= "<td style=\"text-align: center\">" . number_format(0) . "</td>";
            }
            $result .= "</tr>";
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }

    private function getContent_tk_mobile_ads($from_date, $to_date, $partnerId)
    {
        $result = "<html><body>";
        $result .= "<table class=\"table table-striped table-bordered table-condensed table-hover\"; border = 1; cellpadding=0; cellspacing=1; width=70%; text-align:center>";
        $result .= "<thead>";
        $result .= "<tr>";
        $result .= "<th style=\"text-align: center\">Ngày</th>";
        $result .= "<th style=\"text-align: center\">Số lượt click không trùng IP</th>";
        $result .= "<th style=\"text-align: center\">Số lượt click nhận diện được</th>";
        $result .= "<th style=\"text-align: center\">Số lượt click nhận diện được không trùng IP</th>";
        $result .= "<th style=\"text-align: center\">Số lượt đăng ký thành công</th>";
        $result .= "<th style=\"text-align: center\">Số lượt hủy sau 1 chu kỳ</th>";
        $result .= "<th style=\"text-align: center\">Số lượt gia hạn đến 3 chu kỳ cước</th>";
        $result .= "<th style=\"text-align: center\">Số lượt gia hạn không thành công</th>";
        $result .= "<th style=\"text-align: center\">Số lượt gia hạn thành công</th>";
        $result .= "<th style=\"text-align: center\">Tổng doanh thu</th>";
        $result .= "</tr>";
        $result .= "</thead>";
        $result .= "<tbody id=\"data.body\">";
        //data here
        $adsReport = AdsReport::getReport_tk_mobile_ads($from_date, $to_date, $partnerId);
        if (count($adsReport) > 0) {
            for ($i = 0; $i < count($adsReport); $i++) {
                $date = date('d/m/Y', strtotime($adsReport[$i]['create_date']));
                $result .= "<tr>";
                $result .= "<td style=\"text-align: center\">" . $date . "</td>
				<td style=\"text-align: center\">" . number_format($adsReport[$i]['not_coincide_ip']) . "</td>
				<td style=\"text-align: center\">" . number_format($adsReport[$i]['identify']) . "</td>
				<td style=\"text-align: center\">" . number_format($adsReport[$i]['identify_not_coincide_ip']) . "</td>
				<td style=\"text-align: center\">" . number_format($adsReport[$i]['register_success']) . "</td>
				<td style=\"text-align: center\">" . number_format($adsReport[$i]['cancel_after_one_cycle']) . "</td>
				<td style=\"text-align: center\">" . number_format($adsReport[$i]['recur_after_three_cycle']) . "</td>
				<td style=\"text-align: center\">" . number_format($adsReport[$i]['recur_failed']) . "</td>
				<td style=\"text-align: center\">" . number_format($adsReport[$i]['recur_success']) . "</td>
				<td style=\"text-align: center\">" . number_format($adsReport[$i]['revenue']) . "</td>";
                $result .= "</tr>";
            }
        }
        $result .= "</tbody>";
        $result .= "</table>";
        $result .= "</body></html>";
        return $result;
    }
}
