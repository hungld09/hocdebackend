<?php

class NewReportCommand extends CConsoleCommand
{
	public $USING_CANCEL = 0;
	public $USING_SERVICE = 1;
	public $USING_VIEW = 2;
	public $USING_DOWNLOAD = 3;
	public $USING_GIFT = 4;
	public $USING_RECEIVE = 5;

	public $PHIM = 4;
    public $PHIM7 = 5;
    public $PHIM30 = 6;

	public $USING_TYPE_SERVICE = 1;
	public $USING_TYPE_VIEW = 2;
	public $USING_TYPE_DOWNLOAD = 3;
	public $USING_TYPE_GIFT = 4;
	public $USING_TYPE_RECEIVE_GIFT = 5;

	public $PURCHASE_TYPE_REGISTER = 1;
	public $PURCHASE_TYPE_EXTEND = 2;
	public $PURCHASE_TYPE_CANCEL = 3;
	public $PURCHASE_TYPE_AUTO_CANCEL = 4;
	public $PURCHASE_TYPE_RETRY_EXTEND = 10; //truy thu

	public $SERVICE_2 = 5;
	
	public $ACTION_CLICK_MOBILE_ADS = 8;

	public function responseError($error_no, $error_code, $message) {
		echo "error_no = $error_no - error_code = $error_code - message = $message";
		//        echo($error_code." *** ".$message);
		// 		header("Content-type: text/xml; charset=utf-8");
		// 		$xmlDoc = new DOMDocument();
		// 		$xmlDoc->encoding = "UTF-8";
		// 		$xmlDoc->version = "1.0";


		// 		$root = $xmlDoc->appendChild($xmlDoc->createElement("response"));
		// 		$root->appendChild($xmlDoc->createElement("error_no", $error_no));
		// 		$root->appendChild($xmlDoc->createElement("error_code", $error_code));
		// 		$root->appendChild($xmlDoc->createElement("error_message", CHtml::encode($message)));

		// 		echo $xmlDoc->saveXML();
		Yii::app()->end();
	}

	//chay 3 tieng 1 lan, chay truoc khi chay command extend cua subscriberCommand (project vFilm). Thong ke xem co bao nhieu thue bao can gia han - truy thu
	//job nay dua vao table service_subscriber_mapping, fai chay dung thoi diem, qua roi thi thoi
	public function actionCreateReportBeforeExtend() {
		$lastCycleTime = date('Y-m-d H'); //chi dung de chan ko chay report nay nhieu lan thoi
		$tmpReport = ExtendTransactionReport::model()->findBySql("select * from extend_transaction_report where create_date > '$lastCycleTime'");
		if($tmpReport != null) {
			$this->responseError(1,1, "Report for this cycle had been created");
		}

		$currentTime = date('Y-m-d H:i:s');
		$currentDate = date('Y-m-d');

		$nextCycleTime = date('Y-m-d H:i:s', time() + 3*3600 + 300); //job nay chay truoc khi gia han 5 phut nen + 300 s

		//list can gia han *** begin
		$criteria7CanGiaHan=new CDbCriteria;
		$criteria7CanGiaHan->distinct = true;
		$criteria7CanGiaHan->select = 'id';
		$criteria7CanGiaHan->addCondition('t.expiry_date < "'.$nextCycleTime.'"');
		$criteria7CanGiaHan->addCondition('t.is_active = 1');
		$criteria7CanGiaHan->addCondition('t.recur_retry_times = 0');
		$criteria7CanGiaHan->addCondition('t.service_id = "'.$this->PHIM7.'"');
		$phim7CanGiaHan = ServiceSubscriberMapping::model()->findAll($criteria7CanGiaHan);
		echo " ***CanGiaHan PHIM7: ".sizeof($phim7CanGiaHan);
		//list can gia han *** end

		//list can truy thu *** begin
		$lastModifyDate = date('Y-m-d H:i:s', time()-21*3600 + 300);
		$criteria7CanTruyThu=new CDbCriteria;
		$criteria7CanTruyThu->distinct = true;
		$criteria7CanTruyThu->select = 'id';
		$criteria7CanTruyThu->addCondition('t.service_id = "'.$this->PHIM7.'"');
		$criteria7CanTruyThu->addCondition('t.modify_date <  "'.$lastModifyDate.'" or t.modify_date is null');
		$criteria7CanTruyThu->addCondition('t.is_active = 1');
		$criteria7CanTruyThu->addCondition('t.recur_retry_times > 0');
		$phim7CanTruyThu = ServiceSubscriberMapping::model()->findAll($criteria7CanTruyThu);
		echo " ***TruyThu PHIM7: ".sizeof($phim7CanTruyThu);
		//list can truy thu *** end

		//luu vao report: insert to table extend_transaction_report
		$report7CanGiaHan = new ExtendTransactionReport();
		$report7CanGiaHan->service_id = $this->PHIM7;
		$report7CanGiaHan->subscriber_count = sizeof($phim7CanGiaHan);
		$report7CanGiaHan->create_date = date('Y-m-d H', time()+3600); //chay truoc khi run cronjob gia han 5 phut, +1 tieng roi lay tron thi thanh gio gia han luon. Vi du 2h55 -> 3h
		$report7CanGiaHan->extend_type = ExtendTransactionReport::EXTEND_TYPE_CAN_GIA_HAN;
		if(!$report7CanGiaHan->save()) {
			print_r($report7CanGiaHan->getErrors());
		}

		$report7CanTruyThu = new ExtendTransactionReport();
		$report7CanTruyThu->service_id = $this->PHIM7;
		$report7CanTruyThu->subscriber_count = sizeof($phim7CanTruyThu);
		$report7CanTruyThu->create_date = date('Y-m-d H', time()+3600); //chay truoc khi run cronjob gia han 5 phut, +1 tieng roi lay tron thi thanh gio gia han luon. Vi du 2h55 -> 3h
		$report7CanTruyThu->extend_type = ExtendTransactionReport::EXTEND_TYPE_CAN_TRUY_THU;
		if(!$report7CanTruyThu->save()) {
			print_r($report7CanTruyThu->getErrors());
		}
	}

	//thong ke daily so thue bao can gia han - can truy thu
	//chay luc 2h40
	//TODO: create table luu cai nay
	public function actionCreateDailyReportBeforeExtend($startDay_str = '', $endDay_str = '') {
		if($startDay_str == '') {
			$startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
		}
		if($endDay_str == '') {
			$endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7); //them 7 tieng de tranh truong hop bi sai gio tren server
		}
		//     	echo $startDay_str;
		//     	echo " *** ".$endDay_str;

		$startDay = strtotime($startDay_str);
		$endDay = strtotime($endDay_str);

		$reportBeforeExtend = BeforeExtendReport::model()->findByAttributes(array('create_date' => $startDay_str));
		if($reportBeforeExtend != NULL) {
			echo "report for $startDay_str has been created. Exit \n";
			return;
		}

		$arrReportCanGiaHan = ExtendTransactionReport::model()->findAllBySql("select * from extend_transaction_report where create_date between '$startDay_str' and '$endDay_str'");
		$countCanGiaHan = 0;
		$count7CanGiaHan = 0;
		$count30CanGiaHan = 0;
		$countCanTruyThu = 0;
		$count7CanTruyThu = 0;
		$count30CanTruyThu = 0;
		foreach($arrReportCanGiaHan as $report) {
			if($report->extend_type == ExtendTransactionReport::EXTEND_TYPE_CAN_GIA_HAN) {
				if($report->service_id == $this->PHIM7) {
					$count7CanGiaHan += $report->subscriber_count;
				}
			}
			else if($report->extend_type == ExtendTransactionReport::EXTEND_TYPE_CAN_TRUY_THU) {
				if($report->service_id == $this->PHIM7) {
					$count7CanTruyThu += $report->subscriber_count;
				}
			}
		}
		echo $count7CanGiaHan."\n";
		echo $count7CanTruyThu."\n";

		$reportBeforeExtend = new BeforeExtendReport();
		$reportBeforeExtend->create_date = $startDay_str;
		$reportBeforeExtend->can_gia_han_phim7 = $count7CanGiaHan;
		$reportBeforeExtend->can_truy_thu7 = $count7CanTruyThu;
		if(!$reportBeforeExtend->save()) {
			print_r($reportBeforeExtend->getErrors());
			echo "Create report beforeExtend for $startDay_str failed";
			return;
		}
		echo "Create report beforeExtend for $startDay_str successfully";
	}

	//thong ke theo tung ngay, nen startDay_str & endDay_str la 0h cua 2 ngay ltiep
	//thong ke so luot tru tien thanh cong - that bai
	//chay luc 2h41
	public function actionCreateChargingReport($startDay_str = '', $endDay_str = '') {
		if($startDay_str == '') {
			$startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
            $date = new DateTime(date('Y-m-d'));
            $process_date = date('Y-m-d', (time() - 60*60*15));
		}
        else{
           $date = new DateTime($startDay_str);
            $process_date = $date->format('Y-m-d');
        }
		if($endDay_str == '') {
			$endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7); //them 7 tieng de tranh truong hop bi sai gio tren server
		}
		//     	echo $startDay_str;
		//     	echo " *** ".$endDay_str;

		$startDay = strtotime($startDay_str);
		$endDay = strtotime($endDay_str);

		$reportCharging = ChargingReport::model()->findByAttributes(array('create_date' => $startDay_str));
		if($reportCharging != NULL) {
			echo "report for $startDay_str has been created. Exit \n";
			// 			return;
		}
		$countSuccessCharging = SubscriberTransaction::model()->countBySql("select count(*) from subscriber_transaction where date(create_date) = '$process_date' and status = 1 and cost > 0");
		$countFailedCharging = SubscriberTransaction::model()->countBySql("select count(*) from subscriber_transaction where date(create_date) = '$process_date' and status = 2");
// 		$countVMSSuccessCharging = SubscriberTransaction::model()->countBySql("select count(*) from subscriber_transaction where create_date between '$startDay_str' and '$endDay_str' and (status = 1 or error_code = 'CPS-1001' or error_code = 'CPS-1004' or error_code = 'CPS-1007' or error_code = 'CPE-0001' or error_code = 'CPE-0002')");
		$totalCharingCount = $countSuccessCharging + $countFailedCharging;
// 		$countVMSFailedCharging = $totalCharingCount - $countVMSSuccessCharging;
		echo "countSuccessCharging = $countSuccessCharging; countFailedCharging = $countFailedCharging \n";

		// 		Giao dich thành công + không đủ tiền + Giao dịch mã lỗi CPS-1004 + Giao dịch mã lỗi Mã lỗi CPS-1007+ Giao dịch mã CPE-0001/CPE-0002


		$reportCharging = new ChargingReport();
		$reportCharging->create_date = $startDay_str;
		$reportCharging->charging_success = $countSuccessCharging;
		$reportCharging->charging_failed = $countFailedCharging;
// 		$reportCharging->vms_charging_success = $countVMSSuccessCharging;
// 		$reportCharging->vms_charging_failed = $countVMSFailedCharging;
		$reportCharging->save();

		// 		VFILM_SUM_CHARGE_TODAY:  970222
		// 		VFILM_SUCCESSED_CHARGE_TODAY:  970092
		// 		VFILM_FAILED_CHARGE_TODAY:  130
		// 		VFILM_DATE_KPI:  15/07/2013 00:50:02
		// 		VFILM_KPI_CSR:  0.9998
		//tao file text VFILM_tên_chi_tieu_KPI.yyyymmdd luu thong tin KPI charging
        $date1 = date('Y-m-d');
		echo "create charging report for $startDay_str , process_date :$process_date, ht: $date1  successfully \n";
	}

	private function uploadToFtpServer($file, $remote_file, $ftp_server, $ftp_user_name, $ftp_user_pass) {
		// set up basic connection
		$conn_id = ftp_connect($ftp_server);

		// login with username and password
		$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

		// upload a file
		if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
			echo "successfully uploaded $file\n";
			exit;
		} else {
			echo "There was a problem while uploading $file\n";
			exit;
		}
		// close the connection
		ftp_close($conn_id);
	}

	private function writeDataToFile($Data, $fileName) {
		$Handle = fopen($fileName, 'w');
		fwrite($Handle, $Data);
		fclose($Handle);
	}


	//thong ke theo tung ngay, nen startDay_str & endDay_str la 0h cua 2 ngay ltiep
	//from new_subscriber_report to errorcode_report
	//chay luc 2h42
	public function actionCreateErrorCodeReport($startDay_str = '', $endDay_str = '') {
		if($startDay_str == '') {
			$startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
		}
		if($endDay_str == '') {
			$endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7); //them 7 tieng de tranh truong hop bi sai gio tren server
		}
		//     	echo $startDay_str;
		//     	echo " *** ".$endDay_str;

		$startDay = strtotime($startDay_str);
		$endDay = strtotime($endDay_str);

		$reportCharging = ErrorcodeReport::model()->findByAttributes(array('create_date' => $startDay_str));
		if($reportCharging != NULL) {
			echo "report for $startDay_str has been created. Exit \n";
			return;
		}
		// 		$arrErrorCode = array('CPE-0001','CPE-0002','CPE-0010','CPE-0011','CPE-0012','CPE-0020','CPE-0300','CPE-0301','CPE-0302','CPE-0312','CPE-0400','CPE-0401','CPE-0402','CPE-1002','CPS-1001','CPS-1004','CPS-1007','CPS-0000', 'ERROR');
		$queryString = "select error_code, count(error_code) as count from subscriber_transaction where cost > 0 and create_date between '$startDay_str' and '$endDay_str' group by error_code";
		$connection = Yii::app()->db;
		$command = $connection->createCommand($queryString);
		$rows=$command->queryAll();
		// 		echo count($rows);
		// 		print_r($rows); return;
		foreach($rows as $row) {
			$errorReport = new ErrorcodeReport();
			$errorReport->error_code = $row['error_code'];
			$errorReport->number_error = $row['count'];
			$errorReport->create_date = $startDay_str;
			if(!$errorReport->save()) {
				print_r($errorReport->getErrors());
			}
		}
		echo "create error code report for $startDay_str successfully \n";
	}

	//from vod_view to view_channel_type_report
	//chay luc 2h43
	public function actionCreateVodViewReport($startDay_str = '', $endDay_str = '') {
		if($startDay_str == '') {
			$startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
		}
		if($endDay_str == '') {
			$endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7); //them 7 tieng de tranh truong hop bi sai gio tren server
		}
		//     	echo $startDay_str;
		//     	echo " *** ".$endDay_str;

		$startDay = strtotime($startDay_str);
		$endDay = strtotime($endDay_str);

		$reportNewSub = ViewChannelTypeReport::model()->findByAttributes(array('create_date' => $startDay_str));
		if($reportNewSub != NULL) {
			echo "report for $startDay_str has been created. Exit \n";
			return;
		}

		$queryString = "SELECT DATE_FORMAT(DATE(vv.create_date), '%d/%m/%Y')," .
				"(SELECT COUNT(DISTINCT subscriber_id) " .
				"FROM vod_view where `reserve_col` = 1 AND vod_asset_id is not null AND DATE(create_date) = DATE(vv.create_date)) as COUNT_SUB_WAP,".
				"(SELECT COUNT(DISTINCT subscriber_id) " .
				"FROM vod_view where `reserve_col` = 2 AND vod_asset_id is not null AND DATE(create_date) = DATE(vv.create_date)) as COUNT_SUB_AAP,".
				"SUM(if(reserve_col = 1 and vod_asset_id is not null, 1, 0)) AS COUNT_VIEW_WAP,".
				"SUM(if(reserve_col = 2 and vod_asset_id is not null, 1, 0)) AS COUNT_VIEW_AAP ".
				"FROM vod_view vv ".
				"WHERE (create_date between '$startDay_str' and '$endDay_str') ".
				"GROUP BY DATE(create_date)";

		// 		| DATE_FORMAT(DATE(vv.create_date), '%d/%m/%Y') | COUNT_SUB_WAP | COUNT_SUB_AAP | COUNT_VIEW_WAP | COUNT_VIEW_AAP |
		// 		+-----------------------------------------------+---------------+---------------+----------------+----------------+
		// 		| 08/10/2013                                    |          1611 |           146 |           4894 |            321 |

		// 		echo $queryString."\n"; return;
		$connection = Yii::app()->db;
		$command = $connection->createCommand($queryString);
		// 		echo "\n $queryString \n";
		$rows=$command->queryAll();
		foreach($rows as $row) {
			$vvReport = new ViewChannelTypeReport();
			$vvReport->create_date = $startDay_str;
			// 			* @property integer $subscriber_wap
			// 			* @property integer $subscriber_app
			// 			* @property integer $view_wap
			// 			* @property integer $view_app
			$vvReport->subscriber_wap = $row['COUNT_SUB_WAP'];
			$vvReport->subscriber_app = $row['COUNT_SUB_AAP'];
			$vvReport->view_wap = $row['COUNT_VIEW_WAP'];
			$vvReport->view_app = $row['COUNT_VIEW_AAP'];
			$vvReport->save();
		}

		echo "create error code report for $startDay_str successfully \n";
	}

	//from subscriber_transaction to new_subscriber_report: thong ke so thue bao dang ky moi hang ngay
	//chay luc 2h44
    /*public function actionCreateNewSubscriberReport($startDay_str = '', $endDay_str = '') {
        if($startDay_str == '') {
            $startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
        }
        if($endDay_str == '') {
            $endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7);
        }
        //     	echo $startDay_str;
        //     	echo " *** ".$endDay_str;

        $startDay = strtotime($startDay_str);
        $endDay = strtotime($endDay_str);

        $reportNewSub = NewSubscriberReport::model()->findByAttributes(array('create_date' => $startDay_str));
        if($reportNewSub != NULL) {
            echo "report for $startDay_str has been created. Exit \n";
            return;
        }

        $queryString = "SELECT ".
            "DATE_FORMAT(DATE(st.create_date), '%d/%m/%Y') as transaction_date,".
            "SUM(if(st.service_id = " . $this->PHIM . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='WAP', 1, 0)) AS WAP_SERVICE_1,".
            "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='WAP' , 1, 0)) As WAP_SERVICE_7,".
            "SUM(if(st.service_id = " . $this->PHIM30 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='WAP' , 1, 0)) As WAP_SERVICE_30,".
            "SUM(if(st.service_id = " . $this->PHIM . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='SMS', 1, 0)) AS SMS_SERVICE_1,".
            "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='SMS' , 1, 0)) As SMS_SERVICE_7,".
            "SUM(if(st.service_id = " . $this->PHIM30 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='SMS' , 1, 0)) As SMS_SERVICE_30, ".
//				"SUM(if(st.service_id = " . $this->PHIM . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && st.description like '%KM%' && channel_type='SMS', 1, 0)) AS KM_SERVICE_1,".
//				"SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && st.description like '%KM%' && channel_type='SMS' , 1, 0)) As KM_SERVICE_7,".
//				"SUM(if(st.service_id = " . $this->PHIM30 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && st.description like '%KM%' && channel_type='SMS' , 1, 0)) As KM_SERVICE_30, ".
            "SUM(if(st.service_id = " . $this->PHIM . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && st.cost = 0 && channel_type='SMS', 1, 0)) AS KM_SERVICE_1,".
            "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && st.cost = 0 && channel_type='SMS' , 1, 0)) As KM_SERVICE_7,".
            "SUM(if(st.service_id = " . $this->PHIM30 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && st.cost = 0 && channel_type='SMS' , 1, 0)) As KM_SERVICE_30, ".
            "SUM(if(st.service_id = " . $this->PHIM . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='APP', 1, 0)) AS APP_SERVICE_1,".
            "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='APP' , 1, 0)) As APP_SERVICE_7,".
            "SUM(if(st.service_id = " . $this->PHIM30 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='APP' , 1, 0)) As APP_SERVICE_30,".
            "SUM(if(st.service_id = " . $this->PHIM . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='WEB', 1, 0)) AS WEB_SERVICE_1,".
            "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='WEB' , 1, 0)) As WEB_SERVICE_7,".
            "SUM(if(st.service_id = " . $this->PHIM30 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='WEB' , 1, 0)) As WEB_SERVICE_30 ".
            "FROM subscriber_transaction st ".
            "WHERE (st.create_date between '$startDay_str' and '$endDay_str') AND (status = 1) ".
            "GROUP BY DATE (st.create_date)";

        // 		echo $queryString."\n"; return;
        $connection = Yii::app()->db;
        $command = $connection->createCommand($queryString);
        $rows=$command->queryAll();
        // 					echo count($rows);
        // 					print_r($rows); return;
        foreach($rows as $row) {
            $newPHIMSubReport = new NewSubscriberReport();
            $newPHIMSubReport->create_date = $startDay_str;
            $newPHIMSubReport->service_id = $this->PHIM;
            $newPHIMSubReport->register_wap = $row['WAP_SERVICE_1'];
            $newPHIMSubReport->register_web = $row['WEB_SERVICE_1'];
            $newPHIMSubReport->register_app = $row['APP_SERVICE_1'];
            $newPHIMSubReport->register_sms = $row['SMS_SERVICE_1'];
            $newPHIMSubReport->register_km = $row['KM_SERVICE_1'];
            $newPHIMSubReport->save();

            $newPHIM7SubReport = new NewSubscriberReport();
            $newPHIM7SubReport->create_date = $startDay_str;
            $newPHIM7SubReport->service_id = $this->PHIM7;
            $newPHIM7SubReport->register_wap = $row['WAP_SERVICE_7'];
            $newPHIM7SubReport->register_web = $row['WEB_SERVICE_7'];
            $newPHIM7SubReport->register_app = $row['APP_SERVICE_7'];
            $newPHIM7SubReport->register_sms = $row['SMS_SERVICE_7'];
            $newPHIM7SubReport->register_km = $row['KM_SERVICE_7'];
            $newPHIM7SubReport->save();

            $newPHIM30SubReport = new NewSubscriberReport();
            $newPHIM30SubReport->create_date = $startDay_str;
            $newPHIM30SubReport->service_id = $this->PHIM30;
            $newPHIM30SubReport->register_wap = $row['WAP_SERVICE_30'];
            $newPHIM30SubReport->register_web = $row['WEB_SERVICE_30'];
            $newPHIM30SubReport->register_app = $row['APP_SERVICE_30'];
            $newPHIM30SubReport->register_sms = $row['SMS_SERVICE_30'];
            $newPHIM30SubReport->register_km = $row['KM_SERVICE_30'];
            $newPHIM30SubReport->save();
        }

        echo "create registered subscriber report for $startDay_str successfully \n";
    }*/
    public function actionCreateNewSubscriberReport($startDay_str = '', $endDay_str = '') {
        if($startDay_str == '') {
            $startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
        }
        if($endDay_str == '') {
            $endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7); //them 7 tieng de tranh truong hop bi sai gio tren server
        }
        //     	echo $startDay_str;
        //     	echo " *** ".$endDay_str;

        $startDay = strtotime($startDay_str);
        $endDay = strtotime($endDay_str);

        $reportNewSub = NewSubscriberReport::model()->findByAttributes(array('create_date' => $startDay_str));
        if($reportNewSub != NULL) {
            echo "report for $startDay_str has been created. Exit \n";
            return;
        }
        $date = date('Y-m-d', strtotime($startDay_str));
        $endDate = date('Y-m-d', strtotime($endDay_str));
        while(strtotime($date) < strtotime($endDate)){
            $startDay_str = date('Y-m-d 00:00:00', strtotime($date));
            $endDay_str = date('Y-m-d 23:59:59', strtotime($date));
            $queryString = "SELECT ".
                "DATE_FORMAT(DATE(st.create_date), '%d/%m/%Y') as transaction_date, st.create_date, ".
                "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='WAP' , 1, 0)) As WAP_SERVICE_7,".
                "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='SMS' , 1, 0)) As SMS_SERVICE_7,".
                "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='API' , 1, 0)) As KM_SERVICE_7,".
                "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='APP' , 1, 0)) As APP_SERVICE_7,".
                "SUM(if(st.service_id = " . $this->PHIM7 . " && purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " && using_type = " . $this->USING_TYPE_SERVICE . " && channel_type='WEB' , 1, 0)) As WEB_SERVICE_7 ".
                "FROM subscriber_transaction st ".
                "WHERE (st.create_date between '$startDay_str' and '$endDay_str') AND (status = 1) ".
                "GROUP BY DATE (st.create_date)";

//		 		echo $queryString."\n"; return;
            $connection = Yii::app()->db;
            $command = $connection->createCommand($queryString);
            $rows=$command->queryAll();
            // 					echo count($rows);
            // 					print_r($rows); return;
            foreach($rows as $row) {
                $newPHIM7SubReport = new NewSubscriberReport();
                $create_date = date('Y-m-d 00:00:00', strtotime($row['create_date']));
                $newPHIM7SubReport->create_date = $create_date;
                $newPHIM7SubReport->service_id = $this->PHIM7;
                $newPHIM7SubReport->register_wap = $row['WAP_SERVICE_7'];
                $newPHIM7SubReport->register_web = $row['WEB_SERVICE_7'];
                $newPHIM7SubReport->register_app = $row['APP_SERVICE_7'];
                $newPHIM7SubReport->register_sms = $row['SMS_SERVICE_7'];
                $newPHIM7SubReport->register_km = $row['KM_SERVICE_7'];
                if($newPHIM7SubReport->save()) { echo "\n saved for " . $row['create_date'] ." success \n";};
            }
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
            echo "create registered subscriber report for $startDay_str successfully \n";
        }
    }

	//tong hop report tu tat cac cac table va insert vao table total_report
	//chay luc 2h45
	public function actionCreateTotalReport($startDay_str = '', $endDay_str = '') {
		if($startDay_str == '') {
			$startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
		}
		if($endDay_str == '') {
			$endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7); //them 7 tieng de tranh truong hop bi sai gio tren server
		}
		//     	echo $startDay_str;
		//     	echo " *** ".$endDay_str;

		$startDay = strtotime($startDay_str);
		$endDay = strtotime($endDay_str);

		$reportTotal = TotalReport::model()->findByAttributes(array('create_date' => $startDay_str));
		if($reportTotal != NULL) {
			echo "report for $startDay_str has been created. Exit \n";
			return;
		}
		$date = date('Y-m-d', strtotime($startDay_str));
                $endDate = date('Y-m-d', strtotime($endDay_str));
                while(strtotime($date) < strtotime($endDate)){
                        $startDay_str = date('Y-m-d 00:00:00', strtotime($date));
                        $endDay_str = date('Y-m-d 23:59:59', strtotime($date));
		$report = new TotalReport();
		$report->create_date = $startDay_str;
			
		$newSubReport7 = NewSubscriberReport::model()->findByAttributes(array('create_date' => $startDay_str, 'service_id' => $this->PHIM7));
		$so_luot_dk_tb_phim7 = 0;
		$so_tb_dk_qua_wap = 0;
		$so_tb_dk_qua_app = 0;
		$so_tb_dk_qua_web = 0;
		$so_tb_dk_qua_sms = 0;
		$so_tb_dk_ctkm = 0;
		if($newSubReport7 != NULL) {
			$so_tb_dk_qua_wap += $newSubReport7->register_wap;
			$so_tb_dk_qua_app += $newSubReport7->register_app;
			$so_tb_dk_qua_web += $newSubReport7->register_web;
			$so_tb_dk_qua_sms += $newSubReport7->register_sms;
			$so_tb_dk_ctkm += $newSubReport7->register_km;
			$so_luot_dk_tb_phim7 = $newSubReport7->register_wap + $newSubReport7->register_app + $newSubReport7->register_sms + $newSubReport7->register_web + $newSubReport7->register_km;
		}
		$report->so_luot_dk_tb_phim7 = $so_luot_dk_tb_phim7;
		$report->so_luot_dk_tb_moi = $report->so_luot_dk_tb_phim7;
		$report->so_tb_dk_qua_wap = $so_tb_dk_qua_wap;
		$report->so_tb_dk_qua_sms = $so_tb_dk_qua_sms;
		$report->so_tb_dk_qua_app = $so_tb_dk_qua_app;
		$report->so_tb_dk_ctkm_phim7 = $so_tb_dk_ctkm;
		$objBeforeExtendReport = BeforeExtendReport::model()->findByAttributes(array('create_date' => $startDay_str));
		$canGiaHanPhim7 = 0;
		$CanTruyThuPhim7 = 0;
		if($objBeforeExtendReport != NULL) {
			$canGiaHanPhim7 = $objBeforeExtendReport->can_gia_han_phim7;
			$CanTruyThuPhim7 = $objBeforeExtendReport->can_truy_thu7;
		}
		$report->so_tb_can_gia_han_phim7 = $canGiaHanPhim7;
		$report->tong_so_tb_can_gia_han = $canGiaHanPhim7;
		$report->so_tb_can_truy_thu_phim7 = $CanTruyThuPhim7;
		$report->tong_so_tb_can_truy_thu = $CanTruyThuPhim7;

		$so_luot_gui_tang_goi_cuoc = 0;
		$soTbGiaHanTcPhim7 = 0;
		$generalReportPhim7 = GeneralReport::model()->findByAttributes(array('service_id' => $this->PHIM7, 'report_date'=>$startDay_str));
		if($generalReportPhim7 != NULL) {
			$soTbGiaHanTcPhim7 += $generalReportPhim7->extend_success_count;
		}
		$report->so_tb_gia_han_tc_phim7 = $soTbGiaHanTcPhim7;
		////////////////////////////////////////////////////// echo "soTbGiaHanTcPhim7 = $soTbGiaHanTcPhim7 \n";
		$report->tong_so_tb_gia_han_tc = $soTbGiaHanTcPhim7;

		$soTbTruyThuTcPhim7 = 0;
		if($generalReportPhim7 != NULL) {
			$soTbTruyThuTcPhim7 += $generalReportPhim7->retry_extend_success_count;
		}
		$report->so_tb_truy_thu_tc_phim7 = $soTbTruyThuTcPhim7;
		$report->tong_so_tb_truy_thu_tc = $soTbTruyThuTcPhim7;

		$soTbHuyPhim7 = 0;
		if($generalReportPhim7 != NULL) {
			$soTbHuyPhim7 += $generalReportPhim7->manual_cancel_count;
		}
		$report->so_tb_huy_phim7 = $soTbHuyPhim7;
		echo "soTbHuyPhim7 = $soTbHuyPhim7 \n";
		$report->tong_so_tb_huy_dv_trong_ngay = $report->tong_so_tb_huy_dv = $soTbHuyPhim7;

		$soTbBiHuyPhim7 = 0;
		if($generalReportPhim7 != NULL) {
			$soTbBiHuyPhim7 += $generalReportPhim7->auto_cancel_count;
		}
		$report->so_tb_bi_huy_phim7 = $soTbBiHuyPhim7;
		echo "soTbBiHuyPhim7 = $soTbBiHuyPhim7 \n";
		$report->tong_so_tb_bi_huy = $soTbBiHuyPhim7;

		//doanh thu
		$revenueGiftSub = 0;
		$revenueDkPhim7 = 0;
		$revenuePhim7 = Revenue::model()->findByAttributes(array('create_date' => $startDay_str, 'service_id' => $this->PHIM7));
		if($revenuePhim7 != NULL) {
			$revenueDkPhim7 += $revenuePhim7->register;
			$revenueGiftSub += $revenuePhim7->gift_sub;
			$so_luot_gui_tang_goi_cuoc += $revenueGiftSub/9000;
		}
		$report->doanh_thu_dk_phim7 = $revenueDkPhim7;
		echo "revenueDkPhim7 = $revenueDkPhim7 \n";
		$report->tong_doanh_thu_dk_moi = $revenueDkPhim7;

		$revenueGiaHanPhim7 = 0;
		if($revenuePhim7 != NULL) {
			$revenueGiaHanPhim7 += $revenuePhim7->extend;
		}
		$report->doanh_thu_gia_han_phim7 = $revenueGiaHanPhim7;
		echo "revenueGiaHanPhim7 = $revenueGiaHanPhim7 \n";
		$report->tong_doanh_thu_gia_han = $revenueGiaHanPhim7;

		$revenueTruyThuPhim7 = 0;
		if($revenuePhim7 != NULL) {
			$revenueTruyThuPhim7 += $revenuePhim7->retry_extend;
		}
		$report->doanh_thu_truy_thu_phim7 = $revenueTruyThuPhim7;
		echo "revenueTruyThuPhim7 = $revenueTruyThuPhim7 \n";
		$report->tong_doanh_thu_truy_thu = $revenueTruyThuPhim7;

		$revenueVod = Revenue::model()->findByAttributes(array('create_date' => $startDay_str, 'service_id' => NULL));
		$revenueXem = 0;
		$revenueDownload = 0;
		$revenueGift = 0;
		if($revenueVod != NULL) {
			$revenueXem = $revenueVod->view;
			$revenueDownload = $revenueVod->download;
			$revenueGift = $revenueVod->gift;
		}
		$report->doanh_thu_xem = intval($revenueXem);
		$report->doanh_thu_download = intval($revenueDownload);
		$report->doanh_thu_gui_tang_phim = intval($revenueGift);
		$report->doanh_thu_gui_tang_goi_cuoc = intval($revenueGiftSub);
		echo "\n Xem le: $revenueXem - $revenueDownload - $revenueGift - $revenueGiftSub \n";
		$report->tong_doanh_thu_dich_vu = intval($revenueXem + $revenueGift + $revenueGiftSub + $revenueDownload + $report->tong_doanh_thu_dk_moi + $report->tong_doanh_thu_gia_han + $report->tong_doanh_thu_truy_thu);
		echo "\ntong_doanh_thu_dich_vu : ".$report->tong_doanh_thu_dich_vu."\n";

		$cancelByWap = SubscriberTransaction::model()->countBySql("select count(id) from subscriber_transaction where status = 1 and (create_date between '$startDay_str' and '$endDay_str') and (purchase_type = ".$this->PURCHASE_TYPE_CANCEL." or purchase_type = ".$this->PURCHASE_TYPE_CANCEL.") and channel_type = 'WAP'");
		$report->so_tb_huy_qua_wap = $cancelByWap;
		$cancelBySms = SubscriberTransaction::model()->countBySql("select count(id) from subscriber_transaction where status = 1 and (create_date between '$startDay_str' and '$endDay_str') and (purchase_type = ".$this->PURCHASE_TYPE_CANCEL." or purchase_type = ".$this->PURCHASE_TYPE_CANCEL.") and channel_type = 'SMS'");
		$report->so_tb_huy_qua_sms = $cancelBySms;

		$tong_so_luot_truy_cap = 0;
		$tong_so_tb_truy_cap = 0;
		$tong_so_luot_truy_cap_cua_tb_dk = 0;
		$tong_so_luot_truy_cap_cua_tb_chua_dk = 0;
		$tong_so_tb_dk_truy_cap = 0;
		$tong_so_tb_chua_dk_truy_cap = 0;
		$so_luot_xem = 0;
		$so_luot_xem_free = 0;
		$so_luot_xem_free_cua_tb_no_cuoc = 0;
		$so_tb_no_cuoc_xem_free = 0;
		$so_tb_dk_xem_free = 0;
		$so_luot_xem_free_cua_tb_chua_dk = 0;
		$so_tb_chua_dk_xem_free = 0;
		$so_luot_xem_mat_phi = 0;
		$so_tb_xem_mat_phi = 0;

// 		$accessReport = AccessTrackingReport::model()->findByAttributes(array('create_date' => $startDay_str));
// 		// 		* @property integer $access_count_of_registered_sub
// 		// 		* @property integer $access_count_of_not_registered_sub
// 		// 		* @property integer $access_registered_sub_count
// 		// 		* @property integer $access_not_registered_sub_count
// 		// 		* @property integer $free_watch_count_of_retroactive_sub
// 		// 		* @property integer $free_watch_retroactive_sub_count
// 		// 		* @property integer $free_watch_count_of_registered_sub
// 		// 		* @property integer $free_watch_registered_sub_count
// 		// 		* @property integer $free_watch_count_of_not_registered_sub
// 		// 		* @property integer $free_watch_not_registered_sub_count
// 		// 		* @property integer $charging_watch_count
// 		// 		* @property integer $charging_watch_sub_count
// 		if($accessReport != NULL) {
// 			$tong_so_luot_truy_cap_cua_tb_dk = $accessReport->access_count_of_registered_sub;
// 			$tong_so_luot_truy_cap_cua_tb_chua_dk = $accessReport->access_count_of_not_registered_sub;
// 			// 			FIXME $tong_so_luot_truy_cap = lay so lieu tu Google Analytics. Tam thoi lay tong cua 2 loai tren
// 			$tong_so_luot_truy_cap = $tong_so_luot_truy_cap_cua_tb_dk + $tong_so_luot_truy_cap_cua_tb_chua_dk;
// 			$tong_so_tb_dk_truy_cap = $accessReport->access_registered_sub_count;
// 			$tong_so_tb_chua_dk_truy_cap = $accessReport->access_not_registered_sub_count;
// 			$tong_so_tb_truy_cap = $tong_so_tb_dk_truy_cap + $tong_so_tb_chua_dk_truy_cap;
// 			$so_luot_xem_free_cua_tb_chua_dk = $accessReport->free_watch_count_of_not_registered_sub;
// 			$so_luot_xem_free_cua_tb_dk = $accessReport->free_watch_count_of_registered_sub;
// 			$so_luot_xem_free_cua_tb_no_cuoc = $accessReport->free_watch_count_of_retroactive_sub;
// 			$so_luot_xem_free = $so_luot_xem_free_cua_tb_chua_dk + $so_luot_xem_free_cua_tb_dk + $so_luot_xem_free_cua_tb_no_cuoc;
// 			$so_luot_xem_mat_phi = $accessReport->charging_watch_count;
// 			$so_luot_xem = $so_luot_xem_free + $so_luot_xem_mat_phi;

// 			$so_tb_no_cuoc_xem_free = $accessReport->free_watch_retroactive_sub_count;
// 			$so_tb_dk_xem_free = $accessReport->free_watch_registered_sub_count;
// 			$so_tb_chua_dk_xem_free = $accessReport->free_watch_not_registered_sub_count;
// 			$so_tb_xem_mat_phi = $accessReport->charging_watch_sub_count;
// 		}

		// 		$tong_so_luot_truy_cap = 0;
		// 		$tong_so_tb_truy_cap = 0;
		// 		$tong_so_luot_truy_cap_cua_tb_dk = 0;
		// 		$tong_so_luot_truy_cap_cua_tb_chua_dk = 0;
		// 		$tong_so_tb_dk_truy_cap = 0;
		// 		$tong_so_tb_chua_dk_truy_cap = 0;
		// 		$so_luot_xem = 0;
		// 		$so_luot_xem_free = 0;
		// 		$so_luot_xem_free_cua_tb_no_cuoc = 0;
		// 		$so_tb_no_cuoc_xem_free = 0;
		// 		$so_tb_dk_xem_free = 0;
		// 		$so_luot_xem_free_cua_tb_chua_dk = 0;
		// 		$so_tb_chua_dk_xem_free = 0;
		// 		$so_luot_xem_mat_phi = 0;
		// 		$so_tb_xem_mat_phi = 0;
// 		$report->tong_so_luot_truy_cap = $tong_so_luot_truy_cap;
// 		$report->tong_so_tb_truy_cap = $tong_so_tb_truy_cap;
// 		$report->tong_so_luot_truy_cap_cua_tb_dk = $tong_so_luot_truy_cap_cua_tb_dk;
// 		$report->tong_so_luot_truy_cap_cua_tb_chua_dk = $tong_so_luot_truy_cap_cua_tb_chua_dk;
// 		$report->tong_so_tb_dk_truy_cap = $tong_so_tb_dk_truy_cap;
// 		$report->tong_so_tb_chua_dk_truy_cap = $tong_so_tb_chua_dk_truy_cap;
// 		$report->so_luot_xem = $so_luot_xem;
// 		$report->so_luot_xem_free = $so_luot_xem_free;
// 		$report->so_luot_xem_free_cua_tb_no_cuoc = $so_luot_xem_free_cua_tb_no_cuoc;
// 		$report->so_luot_xem_free_cua_tb_chua_dk = $so_luot_xem_free_cua_tb_chua_dk;
// 		$report->so_tb_dk_xem_free = $so_tb_dk_xem_free;
// 		$report->so_tb_chua_dk_xem_free = $so_tb_chua_dk_xem_free;
// 		$report->so_tb_no_cuoc_xem_free = $so_tb_no_cuoc_xem_free;
// 		$report->so_luot_xem_mat_phi = $so_luot_xem_mat_phi;
// 		$report->so_tb_xem_mat_phi = $so_tb_xem_mat_phi;

		$so_luot_gui_tang_phim = $so_tb_gui_tang_phim = 0;
		$generalReportPPV = GeneralReport::model()->findByAttributes(array('service_id' => NULL, 'report_date'=>$startDay_str));
		if($generalReportPPV != NULL) {
			$so_luot_gui_tang_phim = $so_tb_gui_tang_phim = intval($generalReportPPV->gift / 2000);
		}
		$report->so_luot_gui_tang_phim = $report->so_tb_gui_tang_phim = $so_tb_gui_tang_phim;
		//du lieu so_luot_gui_tang_goi_cuoc tong hop tu fia tren
		$report->so_tb_gui_tang_goi_cuoc = $report->so_luot_gui_tang_goi_cuoc = $so_tb_gui_tang_goi_cuoc = intval($so_luot_gui_tang_goi_cuoc);
			


		$tong_so_tb_phat_sinh_cuoc = SubscriberTransaction::model()->countBySql("select count(distinct subscriber_id) from subscriber_transaction where cost > 0 and status = 1 and (create_date between '$startDay_str' and '$endDay_str')");
		$tong_so_tb_dk_moi_trong_ngay = $so_luot_dk_tb_phim7;
		$report->tong_so_tb_phat_sinh_cuoc = $tong_so_tb_phat_sinh_cuoc;
		$report->tong_so_tb_dk_moi_trong_ngay = $tong_so_tb_dk_moi_trong_ngay;
			
		$so_tb_phim7 = 0;
		$so_tb_phim7 = $CanTruyThuPhim7 + $soTbGiaHanTcPhim7 + $so_luot_dk_tb_phim7 - $soTbHuyPhim7;
		$report->so_tb_luy_ke_phim7 = $so_tb_phim7;
		$report->tong_so_tb_dang_kich_hoat = $report->tong_so_tb_luy_ke = $so_tb_phim7;
			
		if(!$report->save()) {
			print_r($report->getErrors());
			echo "\n *** finish create total report for $startDay_str failed*** \n"; return;
		}
		$date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
		echo "\n *** finish create total report for $startDay_str successfully*** \n";
		}
	}
	
//from  subscriber_activity_log, service_subscriber_mapping, subscriber_transaction to ads_report: thong ke luot click mobile ads
	public function actionCreateAdsReport($startDay_str = '', $endDay_str = '') {
		/*
		if($startDay_str == '') {
			$startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*24));
		}
		if($endDay_str == '') {
			$endDay_str = date('Y-m-d 00:00:00', time());
		}
		*/
		if($startDay_str == '') {
                        $startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
                }
                if($endDay_str == '') {
                        $endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7); //them 7 tieng de tranh truong hop bi sai gio tren server
                }
        $yesterday = date('Y-m-d 00:00:00', (strtotime($startDay_str) - 60*60*24));
		$startDay = strtotime($startDay_str);
		$endDay = strtotime($endDay_str);
		$reportAds = AdsReport::model()->findByAttributes(array('create_date' => $startDay_str));
		if($reportAds != NULL) {
			echo "report for $startDay_str has been created. Exit \n";
			return;
		}
		
		$lstPartner = Partner::model()->findAll();
		$date = date('Y-m-d', strtotime($startDay_str));
		$endDate = date('Y-m-d', strtotime($endDay_str));
		while(strtotime($date) < strtotime($endDate)){
			$startDay_str = date('Y-m-d 00:00:00', strtotime($date));
			$endDay_str = date('Y-m-d 23:59:59', strtotime($date));
		foreach ($lstPartner as $partner){
			$report = new AdsReport();
			$report->partner_id = $partner->id;
			$report->create_date = $startDay_str;
			$not_coincide_ip = SubscriberActivityLog::model()->countBySql("select COUNT(DISTINCT(client_ip)) FROM subscriber_activity_log where request_date between '$startDay_str' and '$endDay_str' and action= ".$this->ACTION_CLICK_MOBILE_ADS." AND partner_id = ".$partner->id);
			$report->not_coincide_ip = $not_coincide_ip;
			$count_identify = SubscriberActivityLog::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_activity_log where subscriber_id is not null and request_date between '$startDay_str' and '$endDay_str' and action= ".$this->ACTION_CLICK_MOBILE_ADS." AND partner_id = ".$partner->id);
			$report->identify = $count_identify;
			$count_identify_not_coincide_ip = SubscriberActivityLog::model()->countBySql("select COUNT(DISTINCT client_ip) FROM subscriber_activity_log where subscriber_id is not null and request_date between '$startDay_str' and '$endDay_str' and action= ".$this->ACTION_CLICK_MOBILE_ADS." AND partner_id = ".$partner->id);
			$report->identify_not_coincide_ip = $count_identify_not_coincide_ip;
			$count_register_success = ServiceSubscriberMapping::model()->countBySql("select COUNT(subscriber_id) FROM service_subscriber_mapping where service_id is not null and create_date between '$startDay_str' and '$endDay_str'"." AND partner_id = ".$partner->id);
			$report->register_success = $count_register_success;
            $count_register_success_free = SubscriberTransaction::model()->countBySql("select count(subscriber_id) from subscriber_transaction where purchase_type = 1 and status = 1 and create_date between '$startDay_str' and '$endDay_str'"." and cost = 0 and event_id = 'partner_$partner->id'");
            $report->register_success_free = $count_register_success_free;
            $count_register_success_notfree = SubscriberTransaction::model()->countBySql("select count(subscriber_id) from subscriber_transaction where purchase_type = 1 and status = 1 and create_date between '$startDay_str' and '$endDay_str'"." and cost > 0 and event_id = 'partner_$partner->id'");
            $report->register_success_notfree = $count_register_success_notfree;
			$count_cancel_after_one_cycle = ServiceSubscriberMapping::model()->countBySql("select COUNT(subscriber_id) FROM service_subscriber_mapping where service_id is not null AND is_active = 0 AND ADDDATE(DATE(create_date),14 ) > DATE(modify_date) and modify_date between '$startDay_str' and '$endDay_str'"." AND partner_id = ".$partner->id);
			$report->cancel_after_one_cycle = $count_cancel_after_one_cycle;
			$count_recur_after_three_cycle = ServiceSubscriberMapping::model()->countBySql("select count(DISTINCT(subscriber_id)) from service_subscriber_mapping where service_id is not null AND recur_retry_times = 3 AND modify_date between '$startDay_str' and '$endDay_str'"." AND partner_id = ".$partner->id);
			$report->recur_after_three_cycle = $count_recur_after_three_cycle;
			$count_recur_failed = SubscriberTransaction::model()->countBySql("select count(subscriber_id) from subscriber_transaction where (purchase_type = 2 or purchase_type = 10) and status = 2 and create_date between '$startDay_str' and '$endDay_str'"." and event_id = 'partner_$partner->id'");
			$report->recur_failed = $count_recur_failed;
			$count_recur_success = SubscriberTransaction::model()->countBySql("select count(subscriber_id) from subscriber_transaction where (purchase_type = 2 or purchase_type = 10) and status = 1 and create_date between '$startDay_str' and '$endDay_str'"." and event_id = 'partner_$partner->id'");
			$report->recur_success = $count_recur_success;
            $count_total_cancel = SubscriberTransaction::model()->countBySql("select count(subscriber_id) from subscriber_transaction where purchase_type = 3 and status = 1 and create_date between '$startDay_str' and '$endDay_str'"." and event_id = 'partner_$partner->id'");
            $report->total_cancel = $count_total_cancel;
//            $cumulative_subscribers_thuc = ServiceSubscriberMapping::model()->countBySql("select COUNT(subscriber_id) FROM service_subscriber_mapping where service_id is not null and is_active = 1 AND partner_id = ".$partner->id);

            $luyke = AdsReport::model()->findByAttributes(array('create_date' => $yesterday, 'partner_id' => $partner->id));
            $cumulative_subscribers_real = ($luyke['cumulative_subscribers_real'] + $report->register_success_free + $report->register_success_notfree) - $report->total_cancel;
            $report->cumulative_subscribers_real = $cumulative_subscribers_real;

            $tl_a = 1;
            $tl_b = 1;
            $configSharing = ConfigSharing::model()->findAllByAttributes(array('service_id'=>$partner->id));
            $start = date('Y-m-d', strtotime($startDay_str));
            foreach($configSharing as $date1){
                $startdate = date('Y-m-d', strtotime($date1->start_date));
                $enddate = date('Y-m-d', strtotime($date1->end_date));
                if(strtotime($startdate) <= strtotime($start) && strtotime($start) <= strtotime($enddate)){
                    $tl_a = $date1->config_a / 100;
                    $tl_b = $date1->config_b / 100;
                }
            }
            if(count($luyke) > 0){
                $cumulative_subscribers = ($luyke['cumulative_subscribers'] + (round(($report->register_success_free * $tl_a),0)) + (round(($report->register_success_notfree * $tl_a),0))) - (round(($report->total_cancel * $tl_b),0));
                $report->cumulative_subscribers = $cumulative_subscribers;
            }else{
                $report->cumulative_subscribers = 0;
            }

            $report_revenue = SubscriberTransaction::model()->countBySql("select SUM(cost) from subscriber_transaction where status = 1 and create_date between '$startDay_str' and '$endDay_str' AND event_id = 'partner_$partner->id'");
            $report->revenue = $report_revenue;

//            $connection = Yii::app()->db;
//			$command = $connection->createCommand($queryString);
//			$rows=$command->queryAll();
//			$report->revenue = $rows[0]['total_cost'];
			if(!$report->save()) { 
				print_r($report->getErrors());
			};
			}
		    $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
		    echo $date;
		}
		echo "create ads report for $startDay_str successfully \n";
	}
}
