<?php

class GeneralReportCommand extends CConsoleCommand
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
	public $PURCHASE_ASSET_VTV = 11;

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

	public $SERVICE_1 = 4;
	public $SERVICE_2 = 5;
	public $SERVICE_3 = 6;

	public function findReport($arrReports, $service_id) {
		foreach($arrReports as $report) {
			if($report->service_id == $service_id) return $report;
		}
		return NULL;
	}

	// luu vao table service_subscriber_report de thong ke san luong dich vu hang ngay
	public function actionCreateSubscriberReport($startDay_str = '', $endDay_str = '') {
		if($startDay_str == '') {
			$startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
		}
		if($endDay_str == '') {
			$endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7);
		}
		//expiry_date sau khi gia han thanh cong +7 ngay
                $expiryDate_str  = strtotime($startDay_str) + 7*24*60*60;
                $endDay_expiry = date("Y-m-d H:i:s", $expiryDate_str);

		echo $startDay_str." - ".$endDay_str." - ".$endDay_expiry;	
		$startDay = strtotime($startDay_str);
		$endDay = strtotime($endDay_str); 
		$tmpReport = ServiceSubscriberReport::model()->findByAttributes(array("create_date"=>$startDay_str));
		if($tmpReport != null) {
			$this->responseError(1,1, "Report for today had been created");
		}
		
		$phim = ServiceSubscriberReport::model()->countBySql("select COUNT(DISTINCT(subscriber_id)) FROM service_subscriber_mapping where expiry_date between '$startDay_str' and '$endDay_expiry' and is_active = 1 and service_id = ".$this->PHIM);
		echo " *** PHIM: ".$phim;
		$phim7 = ServiceSubscriberReport::model()->countBySql("select COUNT(DISTINCT(subscriber_id)) FROM service_subscriber_mapping where expiry_date between '$startDay_str' and '$endDay_expiry' and is_active = 1 and service_id = ".$this->PHIM7);
		echo " *** PHIM7: ".$phim7;
		$phim30 = ServiceSubscriberReport::model()->countBySql("select COUNT(DISTINCT(subscriber_id)) FROM service_subscriber_mapping where expiry_date between '$startDay_str' and '$endDay_expiry' and is_active = 1 and service_id = ".$this->PHIM30);
		echo " *** PHIM30: ".$phim30;
		
		$phimExtendFailed = ServiceSubscriberReport::model()->countBySql("select COUNT(DISTINCT(subscriber_id)) FROM service_subscriber_mapping where recur_retry_times > 0 and is_active = 1 and service_id = ".$this->PHIM);
		echo " *** PHIM extend failed: ".$phimExtendFailed;
		$phim7ExtendFailed = ServiceSubscriberReport::model()->countBySql("select COUNT(DISTINCT(subscriber_id)) FROM service_subscriber_mapping where recur_retry_times > 0 and is_active = 1 and service_id = ".$this->PHIM7);
		echo " *** PHIM7 extend failed: ".$phim7ExtendFailed;
		$phim30ExtendFailed = ServiceSubscriberReport::model()->countBySql("select COUNT(DISTINCT(subscriber_id)) FROM service_subscriber_mapping where recur_retry_times > 0 and is_active = 1 and service_id = ".$this->PHIM30);
		echo " *** PHIM30 extend failed: ".$phim30ExtendFailed;

		$report = new ServiceSubscriberReport();
		$report->phim = $phim;
		$report->failed_extend_phim = $phimExtendFailed;
		$report->phim7 = $phim7;
		$report->failed_extend_phim7 = $phim7ExtendFailed;
		$report->phim30 = $phim30;
		$report->failed_extend_phim30 = $phim30ExtendFailed;
		$report->create_date = $startDay_str;
		if(!$report->save()) {
			print_r($report->getErrors());
		}
	}
	public function actionCreateSubscriberReport_Disable() {
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$criteria=new CDbCriteria;
		$criteria->distinct = true;
		$criteria->select = 'id';

		$criteria7=new CDbCriteria;
		$criteria7->distinct = true;
		$criteria7->select = 'id';

		$criteria30=new CDbCriteria;
		$criteria30->distinct = true;
		$criteria30->select = 'id';

		$currentTime = date('Y-m-d H:i:s');
		$currentDate = date('Y-m-d');
		$tmpReport = ServiceSubscriberReport::model()->findByAttributes(array("create_date"=>$currentDate));
		if($tmpReport != null) {
			$this->responseError(1,1, "Report for today had been created");
		}
		//            echo $startTime;
		$criteria->addCondition('t.expiry_date >= "'.$currentTime.'"');
		$criteria->addCondition('t.is_active = 1');

		$criteria7->addCondition('t.expiry_date >= "'.$currentTime.'"');
		$criteria7->addCondition('t.is_active = 1');

		$criteria30->addCondition('t.expiry_date >= "'.$currentTime.'"');
		$criteria30->addCondition('t.is_active = 1');

		$criteria->addCondition('t.service_id = "'.$this->PHIM.'"');
			
		//$phim = ServiceSubscriberMapping::model()->countBySql("select count(*) from service_subscriber_mapping where expiry_date >= '$currentTime' and is_active = 1 and service_id = 4");
		$phim = ServiceSubscriberMapping::model()->findAll($criteria);
		echo " *** PHIM: ".sizeof($phim); //[0]->count();

		$criteria7->addCondition('t.service_id = "'.$this->PHIM7.'"');
		//$phim7 = ServiceSubscriberMapping::model()->countBySql("select count(*) from service_subscriber_mapping where expiry_date >= '$currentTime' and is_active = 1 and service_id = 5");
		$phim7 = ServiceSubscriberMapping::model()->findAll($criteria7);
		echo " *** PHIM7: ".sizeof($phim7);

		$criteria30->addCondition('t.service_id = "'.$this->PHIM30.'"');
		//$phim30 = ServiceSubscriberMapping::model()->countBySql("select count(*) from service_subscriber_mapping where expiry_date >= '$currentTime' and is_active = 1 and service_id = 6");
		$phim30 = ServiceSubscriberMapping::model()->findAll($criteria30);
		echo " *** PHIM30: ".sizeof($phim30);

		//tinh so subscriber gia han bi loi *** begin
		$criteriaExFailed=new CDbCriteria;
		$criteriaExFailed->distinct = true;
		$criteriaExFailed->select = 'id';

		$criteriaExFailed7=new CDbCriteria;
		$criteriaExFailed7->distinct = true;
		$criteriaExFailed7->select = 'id';

		$criteriaExFailed30=new CDbCriteria;
		$criteriaExFailed30->distinct = true;
		$criteriaExFailed30->select = 'id';

		$currentTime = date('Y-m-d H:i:s');
		$currentDate = date('Y-m-d');

		$criteriaExFailed->addCondition('t.is_active = 1');

		$criteriaExFailed7->addCondition('t.is_active = 1');

		$criteriaExFailed30->addCondition('t.is_active = 1');

		$criteriaExFailed->addCondition('t.service_id = "'.$this->PHIM.'"');
		$criteriaExFailed7->addCondition('t.service_id = "'.$this->PHIM7.'"');
		$criteriaExFailed30->addCondition('t.service_id = "'.$this->PHIM30.'"');

		$criteriaExFailed->addCondition('t.recur_retry_times > 0');
		$phimExtendFailed = ServiceSubscriberMapping::model()->findAll($criteriaExFailed);
		echo " *** PHIM extend failed: ".sizeof($phimExtendFailed);

		$criteriaExFailed7->addCondition('t.recur_retry_times > 0');
		$phim7ExtendFailed = ServiceSubscriberMapping::model()->findAll($criteriaExFailed7);
		echo " *** PHIM7 extend failed: ".sizeof($phim7ExtendFailed);

		$criteriaExFailed30->addCondition('t.recur_retry_times > 0');
		$phim30ExtendFailed = ServiceSubscriberMapping::model()->findAll($criteriaExFailed30);
		echo " *** PHIM30 extend failed: ".sizeof($phim30ExtendFailed);
		//tinh so subscriber gia han bi loi *** end

		$report = new ServiceSubscriberReport();
		$report->phim = sizeof($phim);
		$report->failed_extend_phim = sizeof($phimExtendFailed);
		$report->phim7 = sizeof($phim7);
		$report->failed_extend_phim7 = sizeof($phim7ExtendFailed);
		$report->phim30 = sizeof($phim30);
		$report->failed_extend_phim30 = sizeof($phim30ExtendFailed);
		$report->create_date = $currentDate;
		if(!$report->save()) {
			print_r($report->getErrors());
		}
		
		/*
		//10-10-2013 : ko sua lai general_report nua
 		$lastDate = date('Y-m-d H:i:s',(strtotime($currentDate) - 3600*24));
 		//             echo $lastDate; return;
 		$generalReportPHIM = GeneralReport::model()->findByAttributes(array('report_date'=>$lastDate, 'service_id' => 4));
 		$generalReportPHIM7 = GeneralReport::model()->findByAttributes(array('report_date'=>$lastDate, 'service_id' => 5));
 		$generalReportPHIM30 = GeneralReport::model()->findByAttributes(array('report_date'=>$lastDate, 'service_id' => 6));
 		if($generalReportPHIM != NULL) {
 			$generalReportPHIM->extend_fail_count = $report->failed_extend_phim;
 			$generalReportPHIM->update();
 		}
 		if($generalReportPHIM7 != NULL) {
 			$generalReportPHIM7->extend_fail_count = $report->failed_extend_phim7;
 			$generalReportPHIM7->update();
 		}
 		if($generalReportPHIM30 != NULL) {
 			$generalReportPHIM30->extend_fail_count = $report->failed_extend_phim30;
 			$generalReportPHIM30->update();
 		}
		*/
	}

	
	// luu vao table general_report de thong ke san luong dich vu hang ngay
	public function actionCreateReport($startDay_str = '', $endDay_str = '') {
		if($startDay_str == '') {
			$startDay_str = date('Y-m-d 00:00:00', (time() - 60*60*15));
            $date = new DateTime(date('Y-m-d'));
//            $process_date = $date->modify('-1 day')->format('Y-m-d');
            $process_date = date('Y-m-d', (time() - 60*60*15));
		} else {
            $process_date = date('Y-m-d', strtotime($startDay_str));
        }
		if($endDay_str == '') {
			$endDay_str = date('Y-m-d 00:00:00', time() + 60*60*7);
            $date = new DateTime($startDay_str);
            $process_date = $date->format('Y-m-d');
		}

		$startDay = strtotime($startDay_str);
		$endDay = strtotime($endDay_str);
		$sqlService = "select * from service";
		$arrServices = Service::model()->findAllBySql($sqlService);
		foreach($arrServices as $service) {
			//echo $service->id." - ";
			//fixme: can check xem trong ngay hnay da co nhung report nao chua, neu co roi thi ko tao new nua
			$tmpReport = GeneralReport::model()->findByAttributes(array("service_id"=>$service->id, "report_date"=>$process_date));
			// neu da ton tai thi ko lam gi, neu khong nhung SubscriberTransaction record da thong ke roi lai dc thong ke lai
			if($tmpReport != NULL) {
				//                    array_push($arrReportServices, $tmpReport);
				$this->responseError(0,0, "Report for ".date('Y-m-d')." is existed. No action here!!!");
				continue;
			}
			else {
				$reportService = new GeneralReport();
				$reportService->service_id = $service->id;
				$auto_cancel_count = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 1 and (channel_type = 'MAXRETRY' or channel_type = 'SUBNOTEXT' or channel_type = 'SYSTEM') and purchase_type = 3 and service_id = ".$service->id);
				echo " *** Auto cancel: ".$auto_cancel_count;
				$manual_cancel_count = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 1 and (channel_type != 'MAXRETRY' AND channel_type != 'SUBNOTEXT' AND channel_type != 'SYSTEM') and purchase_type = 3 and service_id = ".$service->id);
				echo " *** Manual cancel: ".$manual_cancel_count;
				$extend_fail_count = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 2 and purchase_type = 2 and service_id = ".$service->id);
				echo " *** Extend fail: ".$extend_fail_count;
				$retry_extend_failed_count = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 2 and purchase_type = 10 and service_id = ".$service->id);
				echo " *** Retry extend fail: ".$retry_extend_failed_count;
				$extend_success_count = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 1 and purchase_type = 2 and service_id = ".$service->id);
				echo " *** Extend success: ".$extend_success_count;
				$retry_extend_success_count = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 1 and purchase_type = 10 and service_id = ".$service->id);
				echo " *** Retry extend success: ".$retry_extend_success_count;
				$register_fail_count = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 2 and purchase_type = 1 and service_id = ".$service->id);
				echo " *** Register fail: ".$register_fail_count;
				$register_success_count = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 1 and purchase_type = 1 and service_id = ".$service->id);
				echo " *** Register success: ".$register_success_count;
                $register_success_count_free = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 1 and purchase_type = 1 and service_id = ".$service->id." and cost = 0");
                echo " *** Register success free: ".$register_success_count_free;
                $register_success_count_notfree = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 1 and purchase_type = 1 and service_id = ".$service->id." and cost > 0");
                echo " *** Register success notfree: ".$register_success_count_notfree;
                $view_count_vtv = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where date(create_date) = '$process_date' and status = 1 and description = 11");
                echo " *** View count vtv: ".$view_count_vtv;
				$reportService->report_date = $process_date;
				$reportService->using_type = $this->USING_SERVICE;
				$reportService->auto_cancel_count = $auto_cancel_count;
				$reportService->manual_cancel_count = $manual_cancel_count;
				$reportService->extend_fail_count = $extend_fail_count;
				$reportService->retry_extend_failed_count = $retry_extend_failed_count;
				$reportService->extend_success_count = $extend_success_count;
				$reportService->retry_extend_success_count = $retry_extend_success_count;
				$reportService->register_fail_count = $register_fail_count;
				$reportService->register_success_count = $register_success_count;
                $reportService->register_success_count_free = $register_success_count_free;
                $reportService->register_success_count_notfree = $register_success_count_notfree;
                $reportService->view_vtv_count = $view_count_vtv;
				if(!$reportService->save()) {
					print_r($reportService->getErrors());
					$this->responseError(1,1, "save reportService error");
			}
			}
		}

		$tmpReport = GeneralReport::model()->findByAttributes(array("service_id"=>-1, "using_type" => $this->USING_VIEW, "report_date"=>$startDay_str));
		if($tmpReport != NULL) {
			$this->responseError(0,0, "Report View for ".date('Y-m-d')." is existed. No action here!!!");
			//continue;
		}
		else {
			$reportView = new GeneralReport();
			$reportView->service_id = -1;
			$reportView->using_type = $this->USING_VIEW;
			$reportView->report_date = $startDay_str;
			$pay_per_video_fail_count_view = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where create_date between '$startDay_str' and '$endDay_str' and status = 2 and purchase_type = 1 and using_type = ".$this->USING_VIEW);
			echo " *** Pay per video fail view: ".$pay_per_video_fail_count_view;
			$pay_per_video_success_count_view = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where create_date between '$startDay_str' and '$endDay_str' and status = 2 and purchase_type = 1 and using_type = ".$this->USING_VIEW);
			echo " *** Pay per video success view: ".$pay_per_video_success_count_view;
			$reportView->pay_per_video_fail_count = $pay_per_video_fail_count_view;
			$reportView->pay_per_video_success_count = $pay_per_video_success_count_view;
			if(!$reportView->save()) {
				print_r($reportView->getErrors());
				$this->responseError(1,1, "save reportView error");
			}
		}

		$tmpReport = GeneralReport::model()->findByAttributes(array("service_id"=>-1, "using_type" => $this->USING_DOWNLOAD, "report_date"=>$startDay_str));
		if($tmpReport != NULL) {
			//                $reportDownload = $tmpReport;
			$this->responseError(0,0, "Report Download for ".date('Y-m-d')." is existed. No action here!!!");
			//continue;
		}
		else {
			$reportDownload = new GeneralReport();
			$reportDownload->service_id = -1;
			$reportDownload->using_type = $this->USING_DOWNLOAD;
			$reportDownload->report_date = $startDay_str;
			$pay_per_video_fail_count_download = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where create_date between '$startDay_str' and '$endDay_str' and status = 2 and purchase_type = 1 and using_type = ".$this->USING_DOWNLOAD);
			echo " *** Pay per video fail download: ".$pay_per_video_fail_count_download;
			$pay_per_video_success_count_download = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where create_date between '$startDay_str' and '$endDay_str' and status = 1 and purchase_type = 1 and using_type = ".$this->USING_DOWNLOAD);
			echo " *** Pay per video success download: ".$pay_per_video_success_count_download;
			$reportView->pay_per_video_fail_count = $pay_per_video_fail_count_download;
			$reportView->pay_per_video_success_count = $pay_per_video_success_count_download;
			if(!$reportDownload->save()) {
				print_r($reportDownload->getErrors());
				$this->responseError(1,1, "save reportDownload error");
			}
		}

		$tmpReport = GeneralReport::model()->findByAttributes(array("service_id"=>-1, "using_type" => $this->USING_GIFT, "report_date"=>$startDay_str));
		if($tmpReport != NULL) {
			//                $reportGift = $tmpReport;
			$this->responseError(0,0, "Report Gift for ".date('Y-m-d')." is existed. No action here!!!");
			//continue;
		}
		else {
			$reportGift = new GeneralReport();
			$reportGift->service_id = -1;
			$reportGift->using_type = $this->USING_GIFT;
			$reportGift->report_date = $startDay_str;
			$pay_per_video_fail_count_gift = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where create_date between '$startDay_str' and '$endDay_str' and status = 2 and purchase_type = 1 and using_type = ".$this->USING_GIFT);
			echo " *** Pay per video fail gift: ".$pay_per_video_fail_count_gift;
			$pay_per_video_success_count_gift = SubscriberTransaction::model()->countBySql("select COUNT(subscriber_id) FROM subscriber_transaction where create_date between '$startDay_str' and '$endDay_str' and status = 1 and purchase_type = 1 and using_type = ".$this->USING_GIFT);
			echo " *** Pay per video success gift: ".$pay_per_video_success_count_gift;
			$reportView->pay_per_video_fail_count = $pay_per_video_fail_count_gift;
			$reportView->pay_per_video_success_count = $pay_per_video_success_count_gift;
			
			if(!$reportGift->save()) {
				print_r($reportGift->getErrors());
				$this->responseError(1,1, "save reportGift error");
			}
		}
		
		
			$this->responseError(0,0, "create report for ".date('Y-m-d')." successfully");
		}
	public function actionCreateReportDisable($day_num = 0) {
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$arrServices = Service::model()->findAllByAttributes(array("is_active"=>1));
		$index = $day_num;
		while($index > 0) {
			$timeCollect = time() - (60*60*24) * $index;
			$index--;
			$arrReportServices = array();
			$tmpReport = GeneralReport::model()->findByAttributes(array("report_date"=>date('Y-m-d',$timeCollect)));
			if($tmpReport != NULL) {
				//                    array_push($arrReportServices, $tmpReport);
				//                    $this->responseError(0,0, "Report for ".date('Y-m-d')." is existed. No action here!!!");
				continue;
			}

			foreach($arrServices as $service) {
// 				               echo $service->id." - ";
				//fixme: can check xem trong ngay hnay da co nhung report nao chua, neu co roi thi ko tao new nua

				$tmpReport = GeneralReport::model()->findByAttributes(array("service_id"=>$service->id, "report_date"=>date('Y-m-d',$timeCollect)));
				// neu da ton tai thi ko lam gi, neu khong nhung SubscriberTransaction record da thong ke roi lai dc thong ke lai
				if($tmpReport != NULL) {
					//                    array_push($arrReportServices, $tmpReport);
					//                        $this->responseError(0,0, "Report for ".date('Y-m-d')." is existed. No action here!!!");
					continue;
				}
				else {
					$reportService = new GeneralReport();
					$reportService->service_id = $service->id;
					//                        $reportService->report_date = $timeCollect;
					$reportService->report_date = date('Y-m-d',$timeCollect);
					$reportService->using_type = $this->USING_SERVICE;
					$reportService->save();
					array_push($arrReportServices, $reportService);
				}
			}

			$tmpReport = GeneralReport::model()->findByAttributes(array("service_id"=>-1, "using_type" => $this->USING_VIEW, "report_date"=>date('Y-m-d',$timeCollect)));
			if($tmpReport != NULL) {
				//                $reportView = $tmpReport;
				//                    $this->responseError(0,0, "Report for ".date('Y-m-d')." is existed. No action here!!!");
				continue;
			}
			else {
				$reportView = new GeneralReport();
				$reportView->service_id = -1;
				$reportView->using_type = $this->USING_VIEW;
				//                    $reportView->report_date = $timeCollect;
				$reportView->report_date = date('Y-m-d',$timeCollect);
				$reportView->save();
			}

			$tmpReport = GeneralReport::model()->findByAttributes(array("service_id"=>-1, "using_type" => $this->USING_DOWNLOAD, "report_date"=>date('Y-m-d',$timeCollect)));
			if($tmpReport != NULL) {
				//                $reportDownload = $tmpReport;
				//                    $this->responseError(0,0, "Report for ".date('Y-m-d')." is existed. No action here!!!");
				continue;
			}
			else {
				$reportDownload = new GeneralReport();
				$reportDownload->service_id = -1;
				$reportDownload->using_type = $this->USING_DOWNLOAD;
				//                    $reportDownload->report_date = $timeCollect;
				$reportDownload->report_date = date('Y-m-d',$timeCollect);
				$reportDownload->save();
			}

			$tmpReport = GeneralReport::model()->findByAttributes(array("service_id"=>-1, "using_type" => $this->USING_GIFT, "report_date"=>date('Y-m-d',$timeCollect)));
			if($tmpReport != NULL) {
				//                $reportGift = $tmpReport;
				//                    $this->responseError(0,0, "Report for ".date('Y-m-d')." is existed. No action here!!!");
				continue;
			}
			else {
				$reportGift = new GeneralReport();
				$reportGift->service_id = -1;
				$reportGift->using_type = $this->USING_GIFT;
				//                    $reportGift->report_date = $timeCollect;
				$reportGift->report_date = date('Y-m-d',$timeCollect);
				if(!$reportGift->save()) {
					print_r($reportGift->getErrors());
					$this->responseError(1,1, "save reportGift error");
				}
			}

			$criteria=new CDbCriteria;
			$criteria->distinct = true;
			$criteria->select=array('id, service_id, status, purchase_type, using_type');

			$startTime = date('Y-m-d 00:00:00',$timeCollect);
			$nextDay = $timeCollect + (24*60*60);
			$endTime = date('Y-m-d 00:00:00', $nextDay);
			//            echo $startTime;
			$criteria->addCondition('t.create_date >= "'.$startTime.'"');
			$criteria->addCondition('t.create_date < "'.$endTime.'"');
			echo $startTime." - ".$endTime;
			$sql = "select * from subscriber_transaction where create_date between '$startTime' and '$endTime'";
			echo $sql;
			//$transactions = SubscriberTransaction::model()->findAll($criteria);
			$transactions = SubscriberTransaction::model()->findAllBySql($sql);
			//echo count($transaction);
			foreach($transactions as $transaction) {
				echo "a";
				//      $transaction = new SubscriberTransaction; //fixme xoa dong nay
				//                echo $transaction->id." - ";
				if($transaction->service_id > 0) { // lquan den service
					//                    purchase_type ***   1 : mua moi, 2 : gia han, 3 : subscriber chu dong huy, 4 : bi provider huy
					$report = $this->findReport($arrReportServices, $transaction->service_id);
					if($report == NULL) {
						continue;
						//                             $this->responseError(1,1, "service id $transaction->service_id is invalid");
					}
					$report->auto_cancel_count += ($transaction->purchase_type==4)?1:0;
					$report->manual_cancel_count += ($transaction->purchase_type==3)?1:0;
					//                  status   *** 1: success, 2: failed
					if(($transaction->purchase_type==2) && ($transaction->status==2)) {
						$report->extend_fail_count += 1;
					}
					else if(($transaction->purchase_type==10) && ($transaction->status==2)) { //truy thu that bai
						$report->retry_extend_failed_count += 1;
					}
					
					if (($transaction->purchase_type==2) && ($transaction->status==1)) {
						$report->extend_success_count += 1;
					}
					else if (($transaction->purchase_type==10) && ($transaction->status==1)) {
						$report->retry_extend_success_count += 1; //truy thu thanh cong
					} 

					if (($transaction->purchase_type==1) && ($transaction->status==2)) {
						//                            if($transaction->error_code == 'CPS-1001') {
						//                                $report->register_lack_money_count += 1;
						//                            }
						//                            else {
						$report->register_fail_count += 1;
						//                            }
					}
					$report->register_success_count += (($transaction->purchase_type==1) && ($transaction->status==1))?1:0;
					//                        $report->update();
					//                        echo ' - register = '.$report->register_success_count;
					//                        $this->responseError(1,1, "report $report->id - register $report->service_id - $report->register_success_count");
				}
				else { // pay per video: for download, gift, view
					//                  using_type *** 1: view, 2: download, 4: gift
					switch ($transaction->using_type) {
						case $this->USING_VIEW: // view vod
							if($transaction->status==2) {
								//                                    if($transaction->error_code == 'CPS-1001') {
								//                                        $reportView->pay_per_video_lack_money_count += 1;
								//                                    }
								//                                    else {
								$reportView->pay_per_video_fail_count += 1;
								//                                    }
							}
							$reportView->pay_per_video_success_count += ($transaction->status==1)?1:0;
							break;
						case $this->USING_DOWNLOAD: // download vod
							if($transaction->status==2) {
								//                                    if($transaction->error_code == 'CPS-1001') {
								//                                        $reportDownload->pay_per_video_lack_money_count += 1;
								//                                    }
								//                                    else {
								$reportDownload->pay_per_video_fail_count += 1;
								//                                    }
							}
							$reportDownload->pay_per_video_success_count += ($transaction->status==1)?1:0;
							break;
						case $this->USING_GIFT: // send gift vod
							if($transaction->status==2) {
								//                                    if($transaction->error_code == 'CPS-1001') {
								//                                        $reportGift->pay_per_video_lack_money_count += 1;
								//                                    }
								//                                    else {
								$reportGift->pay_per_video_fail_count += 1;
								//                                    }
							}
							$reportGift->pay_per_video_success_count += ($transaction->status==1)?1:0;
							break;
					}
				}
			}

			foreach($arrReportServices as $reportService) {
				//                    $reportService->service_id -= 3; trong truong hop ben Hung fix cung la 1,2,3
				$reportService->update();
			}
			$reportView->update();
			$reportDownload->update();
			$reportGift->update();
		}
		$this->responseError(0,0, "create report for ".date('Y-m-d')." successfully");
	}

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

	//thong ke doanh thu hang ngay, luu vao table revenue
	public function actionCreateRevenueReport($startDay_str = '', $endDay_str = '') {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
		if($startDay_str == '') {
            $date = new DateTime(date('Y-m-d'));
            $date->sub(new DateInterval('P1D'));
            $startDay_str = $date->format('Y-m-d H:i:s');
		}
		if($endDay_str == '') {
            $date = new DateTime(date('Y-m-d'));
            $date->sub(new DateInterval('PT1S'));
            $endDay_str = $date->format('Y-m-d H:i:s');
		}
		//     	echo $startDay_str;
		//     	echo " *** ".$endDay_str;

		$startDay = strtotime($startDay_str);
		$endDay = strtotime($endDay_str);

		$queryString = "SELECT DATE_FORMAT(DATE(st.create_date), '%Y-%m-%d 00:00:00') as transaction_date," .
				"SUM(st.cost) as TOTAL_COST," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " AND service_id = " . $this->SERVICE_1 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_ADD_SERVICE_1," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " AND service_id = " . $this->SERVICE_2 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_ADD_SERVICE_7," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where purchase_type = " . $this->PURCHASE_TYPE_REGISTER . " AND service_id = " . $this->SERVICE_3 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_ADD_SERVICE_30," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where using_type = " . $this->USING_TYPE_GIFT . " AND st1.service_id = " . $this->SERVICE_1 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_PAY_PER_GIFT_SUB1, " .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where using_type = " . $this->USING_TYPE_GIFT . " AND st1.service_id = " . $this->SERVICE_2 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_PAY_PER_GIFT_SUB2, " .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where using_type = " . $this->USING_TYPE_GIFT . " AND st1.service_id = " . $this->SERVICE_3 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_PAY_PER_GIFT_SUB3, " .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where purchase_type = " . $this->PURCHASE_TYPE_EXTEND . " AND service_id = " . $this->SERVICE_1 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_EXTEND_SERVICE_1," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where purchase_type = " . $this->PURCHASE_TYPE_EXTEND . " AND service_id = " . $this->SERVICE_2 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_EXTEND_SERVICE_7," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where purchase_type = " . $this->PURCHASE_TYPE_EXTEND . " AND service_id = " . $this->SERVICE_3 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_EXTEND_SERVICE_30," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where purchase_type = " . $this->PURCHASE_TYPE_RETRY_EXTEND . " AND service_id = " . $this->SERVICE_1 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_RETRY_EXTEND_SERVICE_1," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where purchase_type = " . $this->PURCHASE_TYPE_RETRY_EXTEND . " AND service_id = " . $this->SERVICE_2 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_RETRY_EXTEND_SERVICE_7," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where purchase_type = " . $this->PURCHASE_TYPE_RETRY_EXTEND . " AND service_id = " . $this->SERVICE_3 . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_RETRY_EXTEND_SERVICE_30," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where using_type = " . $this->USING_TYPE_VIEW . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_PAY_PER_VIEW," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where using_type = " . $this->USING_TYPE_VIEW . " AND description = " . $this->PURCHASE_ASSET_VTV . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_PAY_PER_VIEW_VTV," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where using_type = " . $this->USING_TYPE_DOWNLOAD . " AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_PAY_PER_DOWNLOAD," .
				"(SELECT SUM(st1.cost) FROM subscriber_transaction st1 where using_type = " . $this->USING_TYPE_GIFT . " AND st1.`service_id` is null AND st1.`status` = 1 AND DATE(st1.create_date) = DATE(st.create_date)) AS COST_PAY_PER_GIFT " .
				"FROM subscriber_transaction st where st.create_date BETWEEN '$startDay_str' AND '$endDay_str' GROUP BY DATE(st.create_date)";

		//         echo $queryString;
		//         return;

		$connection = Yii::app()->db;
		$command = $connection->createCommand($queryString);
		$rows=$command->queryAll();
		//         $rows=$dataReader->readAll();
		//         print_r($rows);
		//         print_r($rows);
		foreach($rows as $row) {
			// 	        print_r($row);
			$tmp = Revenue::model()->findByAttributes(array('create_date'=>$row['transaction_date']));
			if($tmp != NULL) continue;
 			$revenueService1 = new Revenue();
 			$revenueService1->service_id = $this->SERVICE_1;
 			$revenueService1->register = $row['COST_ADD_SERVICE_1'];
 			$revenueService1->extend = $row['COST_EXTEND_SERVICE_1'];
 			$revenueService1->retry_extend = $row['COST_RETRY_EXTEND_SERVICE_1'];
 			$revenueService1->gift_sub = $row['COST_PAY_PER_GIFT_SUB1'];
 			$revenueService1->create_date = $row['transaction_date'];
 			$revenueService1->save();

			$revenueService7 = new Revenue();
			$revenueService7->service_id = $this->SERVICE_2;
			$revenueService7->register = $row['COST_ADD_SERVICE_7'];
			$revenueService7->extend = $row['COST_EXTEND_SERVICE_7'];
			$revenueService7->retry_extend = $row['COST_RETRY_EXTEND_SERVICE_7'];
			$revenueService7->gift_sub = $row['COST_PAY_PER_GIFT_SUB2'];
			$revenueService7->create_date = $row['transaction_date'];
			if(!$revenueService7->save()) {
				$this->responseError(1,1, "Cannot save revenueService7");
			}

 			$revenueService30 = new Revenue();
 			$revenueService30->service_id = $this->SERVICE_3;
 			$revenueService30->register = $row['COST_ADD_SERVICE_30'];
 			$revenueService30->extend = $row['COST_EXTEND_SERVICE_30'];
 			$revenueService30->retry_extend = $row['COST_RETRY_EXTEND_SERVICE_30'];
 			$revenueService30->gift_sub = $row['COST_PAY_PER_GIFT_SUB3'];
 			$revenueService30->create_date = $row['transaction_date'];
 			$revenueService30->save();

			$revenuePayPerVod = new Revenue();
			$revenuePayPerVod->view = $row['COST_PAY_PER_VIEW'];
			$revenuePayPerVod->view_vtv = $row['COST_PAY_PER_VIEW_VTV'];
			$revenuePayPerVod->gift = $row['COST_PAY_PER_GIFT'];
			$revenuePayPerVod->download = $row['COST_PAY_PER_DOWNLOAD'];
			$revenuePayPerVod->create_date = $row['transaction_date'];
			if(!$revenuePayPerVod->save()) {
				$this->responseError(1,1, "Cannot save revenuePayPerVod");
			}
		}

		$this->responseError(0,0, "Create revenue report from $startDay_str to $endDay_str successfully!");
	}

	//thong ke doanh thu & gui mail den cac sep (lau nay chi Thang van phai tong hop bang tay va gui mail hang ngay)
	//     link de goi action nay: http://report.mfilm.vn/mfilmReport/index.php/generalReport/createDailyReport
	public function actionCreateDailyReport() {
		//     	$fullResult = simplexml_load_file("http://api.mfilm.vn:8080/mfilm/api/createDailyReport");
		$fullResult = simplexml_load_file("http://192.168.5.101:8080/mfilm/api/createDailyReport");
		$reportContent = $fullResult->report;
		echo $reportContent;
		$filename = "assets/mfilm-daily-report-date".date('YmdHi', time())."log";
		file_put_contents($filename, $reportContent);
		return;
	}

	//de thong ke cai gi day
	public function actionCollectViewInfo() {
		echo header("Content-type: text/plain");
		//     	$start1 = strtotime('2013-04-01 00:00:00');
		//     	$end1 = strtotime('2013-05-01 00:00:00');
		$count = 0;
		for($i = 1; $i <= 30; $i++) { //thang 4 co 30 ngay
			$startDate = "2013-04-$i 00:00:00";
			$endDate = "2013-04-$i 23:59:59";
			$views = VodView::model()->findAllBySql("select distinct subscriber_id from vod_view where create_date between '$startDate' and '$endDate'");
			$count += sizeof($views);
		}
		echo "Thang 4 co $count subscribers \n";

		$count = 0;
		for($i = 1; $i <= 31; $i++) { //thang 5 co 31 ngay
			$startDate = "2013-05-$i 00:00:00";
			$endDate = "2013-05-$i 23:59:59";
			$views = VodView::model()->findAllBySql("select distinct subscriber_id from vod_view where create_date between '$startDate' and '$endDate'");
			$count += sizeof($views);
		}
		echo "Thang 5 co $count subscribers \n";

		$count = 0;
		for($i = 1; $i <= 30; $i++) { //thang 5 co 31 ngay
			$startDate = "2013-04-$i 00:00:00";
			$endDate = "2013-04-$i 23:59:59";
			$views = SmsMessage::model()->findAllBySql("select distinct subscriber_id from sms_message where (sending_time between '$startDate' and '$endDate') and (message like '%Mat khau de dung%')");
			$count += sizeof($views);
		}
		echo "Thang 4 co $count subscribers dung wifi\n";

		$count = 0;
		for($i = 1; $i <= 31; $i++) { //thang 5 co 31 ngay
			$startDate = "2013-05-$i 00:00:00";
			$endDate = "2013-05-$i 23:59:59";
			$views = SmsMessage::model()->findAllBySql("select distinct subscriber_id from sms_message where (sending_time between '$startDate' and '$endDate') and (message like '%Mat khau de dung%')");
			$count += sizeof($views);
		}
		echo "Thang 5 co $count subscribers dung wifi\n";
	}
}
