<?php

class ReportLinkMediaController extends RController
{
//    const GROUP_DOANH_THU = 5;
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $ACTION_CLICK_MOBILE_ADS = 8;

    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
//			'Mobileads + accessControl', // perform access control for CRUD operations
            'rights',
        );
    }
//    public function filters()
//    {
//        return array(
//            'accessControl', // perform access control for CRUD operations
//            'postOnly + delete', // we only allow deletion via POST request
//        );
//    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('index','view'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('create','update','showDtLink','showcontent','configSharing','configSharingDel'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array(),
                'users'=>array('admin'),
            ),
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */

    public function actionShowDtLink()
    {
        $role = User::getRole(Yii::app()->user->id);
        if($role->name == User::ROLE_NAME_SYSTEM_ADMIN){
            $arrPartner = Partner::model()->findAll();
        }else{
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $arrPartner = Partner::model()->findAllByAttributes(array('id'=>$user['partner_id']));
        }
        $this->render('showDtLink', array(
            'arrPartner' => $arrPartner,
        ));
    }

    public function actionShowcontent()
    {
        if(isset($_POST['start']) && isset($_POST['end']) && isset($_POST['partnerId'])){
            $partner_id = $_POST['partnerId'];
            $arpartner = Partner::model()->findByPk($partner_id);
            $partnerCost = intval($arpartner['cost']);
            try{
                $birthdate = array_reverse(explode('/', $_POST['end']));
                $time = implode('-', $birthdate);
                $date = new DateTime($time);
                $end = $date->format('Y-m-d');

                $birthdate = array_reverse(explode('/', $_POST['start']));
                $time = implode('-', $birthdate);
                $date = new DateTime($time);
                $start = $date->format('Y-m-d');
                $content = array();
                while (strtotime($start) <= strtotime($end)) {
                    $tl_a = 1;
                    $tl_b = 1;
                    $tl_c = 1;
                    $tl_d = 1;
                    $configSharing = ConfigSharing::model()->findAllByAttributes(array('service_id'=>$partner_id));
                    foreach($configSharing as $date){
                        $startdate = date('Y-m-d', strtotime($date->start_date));
                        $enddate = date('Y-m-d', strtotime($date->end_date));
                        if(strtotime($startdate) <= strtotime($start) && strtotime($start) <= strtotime($enddate)){
                            $tl_a = $date->config_a / 100;
                            $tl_b = $date->config_b / 100;
                            $tl_c = $date->config_c / 100;
                            $tl_d = $date->config_d / 100;
                        }
                    }
                    if($start == date('Y-m-d')){
//                        echo 1;die;
                        $listData = SubscriberTransaction::model()->findAllBySql("select COUNT(subscriber_id) as total, purchase_type, cost, status FROM subscriber_transaction where  create_date between '$start 00:00:00' AND '$start 23:59:59' AND event_id = 'partner_$partner_id' group by purchase_type, cost, status");
                        $register_success_notfree = 0;
                        $register_success_free = 0;
                        $total_cancel = 0;
                        $recur_success = 0;
                        $recur_failed = 0;
                        foreach($listData as $item){
                            $cost = intval($item['cost']);
                            if($item['purchase_type'] == PURCHASE_TYPE_NEW && $cost > 0 && $item['status'] == 1){
                                $register_success_notfree += $item['total'];
                            }
                            if($item['purchase_type'] == PURCHASE_TYPE_NEW && $cost == 0 && $item['status'] == 1){
                                $register_success_free += $item['total'];
                            }
                            if($item['purchase_type'] == PURCHASE_TYPE_CANCEL && $item['status'] == 1){
                                $total_cancel += $item['total'];
                            }
                            if(($item['purchase_type'] == PURCHASE_TYPE_RECUR || $item['purchase_type'] == PURCHASE_TYPE_RETRY_EXTEND) && $item['status'] == 1){
                                $recur_success += $item['total'];
                            }
                            if(($item['purchase_type'] == PURCHASE_TYPE_RECUR || $item['purchase_type'] == PURCHASE_TYPE_RETRY_EXTEND) && $item['status'] == 0){
                                $recur_failed += $item['total'];
                            }
                        }
                        $yesterday = date('Y-m-d 00:00:00', (time() - 60*60*24));
                        $luyke = AdsReport::model()->findByAttributes(array('create_date' => $yesterday, 'partner_id' => $partner_id));
                        $cumulative_subscribers = ($luyke['cumulative_subscribers'] + (round(($register_success_free * $tl_a),0)) + (round(($register_success_notfree * $tl_a),0))) - (round(($total_cancel * $tl_b),0));
                        $data = (array(
                            $start => array(
                                /*Gói ngày*/
                                round(($register_success_notfree * $tl_a),0), //0 sl đăng ký mất phí
                                round(($total_cancel * $tl_b),0), //1 sl hủy
                                $cumulative_subscribers, //2 tb lũy kế
                                $luyke['cumulative_subscribers'] + 0, //3 sl gia hạn
                                round(($recur_success * $tl_d),0), //4 sl gia hạn tc
                                round(($recur_success * $tl_d),0) * $partnerCost, //5 dt gia hạn tc
                                round(($register_success_notfree * $tl_a),0) * $partnerCost, //6 dt dk mới
                                round(($register_success_free * $tl_a),0), //7 sl dk mới miễn phí
                            ))
                        );
                    }else{
                        $yesterday = date('Y-m-d 00:00:00', (strtotime($start) - 60*60*24));
                        $luyke = AdsReport::model()->findByAttributes(array('create_date' => $yesterday, 'partner_id' => $partner_id));
                        $model = AdsReport::model()->findByAttributes(
                            array(
                                'partner_id'=>$partner_id,
                            ),
                            array(
                                'condition'=>'DATE(create_date) = "'. $start . '"'
                            )
                        );
//                        echo $luyke['cumulative_subscribers'];echo '<br>';
//                        echo round(($model['register_success_notfree'] * $tl_a),0);echo '<br>';
//                        echo $luyke['cumulative_subscribers'];echo '<br>';

                        $data = (array(
                            $start => array(
                                round(($model['register_success_notfree'] * $tl_a),0), //0 sl đăng ký mất phí
                                round(($model['total_cancel'] * $tl_b),0), //1 sl hủy
                                ($luyke['cumulative_subscribers'] + round(($model['register_success_notfree'] * $tl_a),0) + round(($model['register_success_free'] * $tl_a),0)) - round(($model['total_cancel'] * $tl_b),0), //2 tb lũy kế
                                $luyke['cumulative_subscribers'] + 0, //3 sl gia hạn
                                round(($model['recur_success'] * $tl_d),0), //4 sl gia hạn tc
                                round(($model['recur_success'] * $tl_d),0) * $partnerCost, //5 dt gia hạn tc
                                round(($model['register_success_notfree'] * $tl_a),0) * $partnerCost, //6 dt dk mới
                                round(($model['register_success_free'] * $tl_a),0), //7 sl dk mới miễn phí
                            ))
                        );
                    }
                    $content = array_merge_recursive($content, $data);

                    $start = date('Y-m-d', strtotime('+1 days', strtotime($start)));
                }
                $this->renderPartial('_showcontent', array(
                    'model' => $content,
                ));
            }catch (Exception $e){

            }
        }else{
            Yii::app()->user->setFlash('response','Bạn chưa chọn ngày tháng');
            Yii::app()->end;
        }
    }

    public function actionConfigSharing() {
        $model = new ConfigSharing();
        $arrPartner = Partner::model()->findAll();
        $data = ConfigSharing::model()->findAll();
        if(isset($_POST['ConfigSharing'])){
            $birthdate = array_reverse(explode('/', $_POST['start']));
            $time = implode('-', $birthdate);
            $date = new DateTime($time);
            $start = $date->format('Y-m-d');

            $birthdate = array_reverse(explode('/', $_POST['end']));
            $time = implode('-', $birthdate);
            $date = new DateTime($time);
            $end = $date->format('Y-m-d');


            $model->attributes = $_POST['ConfigSharing'];
            $model->service_id = $_POST['partnerId'];
            $model->start_date = $start.' 00:00:00';
            $model->end_date = $end.' 23:59:59';
            $model->description = 'vtv';

            if($model->save()){
                $this->redirect(Yii::app()->createUrl('reportLinkMedia/configSharing'));
            }else{
                $error = $model->getErrors();
                foreach($error as $value){
                    foreach($value as $item){
                        Yii::app()->user->setFlash('_error_', $item);
                    }
                }
            }
        }

        $this->render('configSharing', array(
            'model' => $model,
            'data' => $data,
            'arrPartner' => $arrPartner,
        ));
    }

    public function actionConfigSharingDel() {
        if(isset($_REQUEST['id'])){
            $model = ConfigSharing::model()->findByPk($_REQUEST['id']);
            if($model->delete()){
                $this->redirect(Yii::app()->createUrl('reportLinkMedia/configSharing'));
            }else{
                $this->redirect(Yii::app()->createUrl('reportLinkMedia/configSharing'));
            }
        }else{
            $this->redirect(Yii::app()->createUrl('reportLinkMedia/configSharing'));
        }
    }

    public function actionShowDtLinkClevernet()
    {
        $role = User::getRole(Yii::app()->user->id);
        if($role->name == User::ROLE_NAME_SYSTEM_ADMIN){
            $arrPartner = Partner::model()->findAll();
        }else{
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $arrPartner = Partner::model()->findAllByAttributes(array('id'=>$user['partner_id']));
        }
        $this->render('showDtLinkClevernet', array(
            'arrPartner' => $arrPartner,
        ));
    }

    public function actionShowcontentClevernet()
    {
        if(isset($_POST['start']) && isset($_POST['end']) && isset($_POST['partnerId'])){
            $partnerId = $_POST['partnerId'];
            $arpartner = Partner::model()->findByPk($partnerId);
            $partnerCost = intval($arpartner['cost']);

            $birthdate = array_reverse(explode('/', $_POST['start']));
            $time = implode('-', $birthdate);
            $date = new DateTime($time);
            $from_date = $date->format('Y-m-d');

            $birthdate = array_reverse(explode('/', $_POST['end']));
            $time = implode('-', $birthdate);
            $date = new DateTime($time);
            $to_date = $date->format('Y-m-d');

            try{
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
                $result .= "<th style=\"text-align: center\">Số thuê bao lũy kế</th>";
                $result .= "<th style=\"text-align: center\">Số lượt gia hạn không thành công</th>";
                $result .= "<th style=\"text-align: center\">Số lượt gia hạn thành công</th>";
                $result .= "<th style=\"text-align: center\">Tổng doanh thu</th>";
                $result .= "</tr>";
                $result .= "</thead>";
                $result .= "<tbody id=\"data.body\">";
                $result_a = '';
                $result_c = '';

                //data here

                $adsReport = AdsReport::getReport_tk_mobile_ads($from_date, $to_date, $partnerId);
                if (count($adsReport) > 0) {
                    for ($i = 0; $i < count($adsReport); $i++) {
                        $date = date('d/m/Y', strtotime($adsReport[$i]['create_date']));

                        //ty le %
                        $tl_a = 1;
                        $tl_b = 1;
                        $tl_c = 1;
                        $tl_d = 1;
                        $tl_f = 1;
                        $tl_e = 1;
                        $configSharing = ConfigSharing::model()->findAllByAttributes(array('service_id'=>$partnerId));
                        foreach($configSharing as $date_tl){
                            $startdate = date('Y-m-d', strtotime($date_tl->start_date));
                            $enddate = date('Y-m-d', strtotime($date_tl->end_date));
                            if(strtotime($startdate) <= strtotime($from_date) && strtotime($to_date) <= strtotime($enddate)){
                                $tl_a = $date->config_a / 100;
                                $tl_b = $date->config_b / 100;
                                $tl_c = $date->config_c / 100;
                                $tl_d = $date->config_d / 100;
                                $tl_f = $date->config_f / 100;
                                $tl_e = $date->config_e / 100;
                            }
                        }
                        //end ty le %
                        if($date == date('d/m/Y')){
                            $startDate = CUtils::getStartDate($adsReport[$i]['create_date']);
                            $endDate = CUtils::getEndDate($adsReport[$i]['create_date']);
                            //count click
                            $not_coincide_ip = SubscriberActivityLog::model()->countBySql("select COUNT(DISTINCT(client_ip)) FROM subscriber_activity_log where request_date between '$startDate' and '$endDate' and action= ".$this->ACTION_CLICK_MOBILE_ADS." AND partner_id = ".$partnerId);
                            $count_identify = SubscriberActivityLog::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_activity_log where subscriber_id is not null and request_date between '$startDate' and '$endDate' and action= ".$this->ACTION_CLICK_MOBILE_ADS." AND partner_id = ".$partnerId);
                            $count_identify_not_coincide_ip = SubscriberActivityLog::model()->countBySql("select COUNT(DISTINCT client_ip) FROM subscriber_activity_log where subscriber_id is not null and request_date between '$startDate' and '$endDate' and action= ".$this->ACTION_CLICK_MOBILE_ADS." AND partner_id = ".$partnerId);
                            $count_cancel_after_one_cycle = ServiceSubscriberMapping::model()->countBySql("select COUNT(subscriber_id) FROM service_subscriber_mapping where service_id is not null AND is_active = 0 AND ADDDATE(DATE(create_date),14 ) > DATE(modify_date) and modify_date between '$startDate' and '$endDate'"." AND partner_id = ".$partnerId);
                            //end count click

                            $listData = SubscriberTransaction::model()->findAllBySql("select COUNT(subscriber_id) as total, purchase_type, cost, status FROM subscriber_transaction where  create_date between '$startDate' AND '$endDate' AND event_id = 'partner_$partnerId' group by purchase_type, cost, status");
                            $register_success_notfree = 0;
                            $register_success_free = 0;
                            $total_cancel = 0;
                            $recur_success = 0;
                            $recur_failed = 0;
                            foreach($listData as $item){
                                $cost = intval($item['cost']);
                                if($item['purchase_type'] == PURCHASE_TYPE_NEW && $cost > 0 && $item['status'] == 1){
                                    $register_success_notfree += $item['total'];
                                }
                                if($item['purchase_type'] == PURCHASE_TYPE_NEW && $cost == 0 && $item['status'] == 1){
                                    $register_success_free += $item['total'];
                                }
                                if($item['purchase_type'] == PURCHASE_TYPE_CANCEL && $item['status'] == 1){
                                    $total_cancel += $item['total'];
                                }
                                if(($item['purchase_type'] == PURCHASE_TYPE_RECUR || $item['purchase_type'] == PURCHASE_TYPE_RETRY_EXTEND) && $item['status'] == 1){
                                    $recur_success += $item['total'];
                                }
                                if(($item['purchase_type'] == PURCHASE_TYPE_RECUR || $item['purchase_type'] == PURCHASE_TYPE_RETRY_EXTEND) && $item['status'] == 0){
                                    $recur_failed += $item['total'];
                                }
                            }
                            $yesterday = date('Y-m-d 00:00:00', (time() - 60*60*24));
                            $luyke = AdsReport::model()->findByAttributes(array('create_date' => $yesterday, 'partner_id' => $partnerId));
                            $cumulative_subscribers = ($luyke['cumulative_subscribers'] + (round(($register_success_free * $tl_a),0)) + (round(($register_success_notfree * $tl_a),0))) - (round(($total_cancel * $tl_b),0));

                            $result_c .= "<tr>";
                            $result_c .= "<td style=\"text-align: center\">" . $date . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($not_coincide_ip*$tl_e),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($count_identify*$tl_e),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($count_identify_not_coincide_ip*$tl_e),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round((($register_success_notfree+$register_success_free)*$tl_a),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($count_cancel_after_one_cycle*$tl_b),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round($cumulative_subscribers,0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($recur_failed*$tl_f),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($recur_success*$tl_d),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format( ( round(($register_success_notfree*$tl_a),0) + round(($recur_success*$tl_d),0) )*$partnerCost ) . "</td>";
                            $result_c .= "</tr>";

                        }else{
                            //tinh luy ke
                            $yesterday = date('Y-m-d 00:00:00', (strtotime($date) - 60*60*24));
                            $dataluyke = AdsReport::model()->findByAttributes(array('create_date' => $yesterday, 'partner_id' => $partnerId));
                            $luyke = ($dataluyke['cumulative_subscribers'] + round(($adsReport[$i]['register_success_notfree'] * $tl_a),0) + round(($adsReport[$i]['register_success_free'] * $tl_a),0)) - round(($adsReport[$i]['total_cancel'] * $tl_b),0);
                            //end tinh luy ke
                            $result_b = "<tr>";
                            $result_b .= "<td style=\"text-align: center\">" . $date . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($adsReport[$i]['not_coincide_ip']*$tl_e),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($adsReport[$i]['identify']*$tl_e),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($adsReport[$i]['identify_not_coincide_ip']*$tl_e),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($adsReport[$i]['register_success']*$tl_a),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($adsReport[$i]['cancel_after_one_cycle']*$tl_b),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round($luyke,0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($adsReport[$i]['recur_failed']*$tl_f),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format(round(($adsReport[$i]['recur_success']*$tl_d),0)) . "</td>
                            <td style=\"text-align: center\">" . number_format( ( round(($adsReport[$i]['register_success_notfree']*$tl_a),0) + round(($adsReport[$i]['recur_success']*$tl_d),0) )*$partnerCost ) . "</td>";
                            $result_b .= "</tr>";
                            $result_a = $result_b.$result_a;
                        }
                    }
                }
                $result_a .= $result_c;
                $result .= $result_a;
                $result .= "</tbody>";
                $result .= "</table>";
                $result .= "</body></html>";
                $this->renderPartial('_showcontentClevernet', array(
                    'result' => $result,
                ));
            }catch (Exception $e){

            }
        }else{
            Yii::app()->user->setFlash('response','Bạn chưa chọn ngày tháng');
            Yii::app()->end;
        }
    }
}
