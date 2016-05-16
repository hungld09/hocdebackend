<?php

define("VOD_USING_TYPE_WATCH", 1);
define("VOD_USING_TYPE_DOWNLOAD", 2);
define("VOD_USING_TYPE_SEND_GIFT", 3);
define("VOD_USING_TYPE_RECEIVE_GIFT", 4);

class VideoController extends Controller {

    private $pageSize = 12;

    public function filters() {
        return array(
            '3GOnly + Purchase',
        );
    }

    public function filter3GOnly($filterChain) {
        if ($this->accessType == Controller::$ACCESS_VIA_3G) {
            $filterChain->run();
        } else {
            Yii::app()->user->setFlash('responseToUser', "Quí khách truy cập 3G của Vinaphone mới sử dụng được tính năng này!");
            $this->redirect(Yii::app()->homeUrl);
        }
    }

    public function actionIndex() {
        return $this->redirect(array("video/browse"));
    }

    public function actionView($id) {
        if (!isset($id))
            return $this->redirect(array("video/browse"));

        $model = VodAsset::model();
        /** @var $asset VodAsset */
        $asset = $model->findByAttributes(array('id' => $id, 'status' => 1));
        if (!$asset)
            return $this->redirect(array("video/browse"));

//        $encrypted_id = $this->crypt->encrypt($id);

        /* $vsWatch    = $this->subscriber->hasVodAsset($asset, USING_TYPE_WATCH);
          $vsRecvGift = $this->subscriber->hasVodAsset($asset, USING_TYPE_RECEIVE_GIFT);
          $vsDownload = $this->subscriber->hasVodAsset($asset, USING_TYPE_DOWNLOAD); */
//        $vsWatch = ($this->subscriber != NULL) ? $this->subscriber->hasVodAsset($asset, USING_TYPE_WATCH) : FALSE;
//        $vsRecvGift = ($this->subscriber != NULL) ? $this->subscriber->hasVodAsset($asset, USING_TYPE_RECEIVE_GIFT) : FALSE;
//        $vsDownload = ($this->subscriber != NULL) ? $this->subscriber->hasVodAsset($asset, USING_TYPE_DOWNLOAD) : FALSE;
		$posterUrl = VodAsset::getFirstImage($id);
        $related = $asset->getRelatedVODs("rand()", 0, 5);
        $relatedVods = $related['data'];
//        for ($i = 0; $i < count($relatedVods); $i++) {
//            $relatedVods[$i] = CUtils::loadVodPoster($relatedVods[$i]);
            //Cheat view
//            $relatedVods[$i]['view_count'] += CUtils::getVirtualView($relatedVods[$i]['create_date']);
//            $relatedVods[$i]['encrypted_id'] = $this->crypt->encrypt($relatedVods[$i]['id']);
//        }

//        $comments = $asset->getComments(0, 1000);
//        $comments = $comments['data'];

//        $posterUrl = $posterPortUrl != "" ? $posterPortUrl : ($posterLandUrl != "" ? $posterLandUrl : Yii::app()->request->baseUrl . "/images/placeholder.png");

        // xem co dang ky dich vu chua? neu co la dich vu gi?
//        $hasService = count($this->usingServices);
//        $sMapping = $hasService > 0 ? $this->usingServices[0] : null;

        // watch URL & price
//        $watchPurchase = ($hasService && $sMapping->isExpired() == FALSE) || ($vsWatch !== FALSE || $vsRecvGift !== FALSE);
//        $watchUrl = Yii::app()->baseUrl . "/video" . ($asset->is_free == 1 || $asset->price == 0 || $watchPurchase ? "/watch?id=" : "/purchase?type=watch&id=") . urlencode($encrypted_id);
        $watchUrl = Yii::app()->baseUrl . "/video" . "/watch?id=" . urlencode($id);
//        $watchPrice = $asset->is_free == 1 || $asset->price == 0 ? "miễn phí" : ($watchPurchase ? "miễn phí" : intval($asset->price) . "đ"); //intval($asset->price) . "đ" . (($hasService && $sMapping->isExpired() == FALSE) ? ", đã đăng ký" : ($vsWatch !== FALSE ? ", đã mua" : ($vsRecvGifg !== FALSE ? ", được tặng" : "")));
        // Trailer URL
//        $haveTrailer = $asset->haveTrailer();
//        $trailerUrl = ($haveTrailer == true) ? Yii::app()->baseUrl . "/video/watch?trailer=1&id=" . urlencode($encrypted_id) : '';
        $trailerPrice = "miễn phí";

        // gift URL & price
        $free_gift = isset($sMapping) ? $sMapping->service->free_gift_count - $sMapping->gift_count : 0;
//        $giftPurchase = ($hasService > 0 && $sMapping->isExpired() == FALSE && $free_gift > 0);
//        $giftUrl = Yii::app()->baseUrl . "/video/purchase?type=gift&id=" . urlencode($encrypted_id);
//        $giftPrice = $asset->is_free == 1 || $asset->price_gift == 0 ? "miễn phí" : ($giftPurchase ? "miễn phí" : intval($asset->price_gift) . "đ"); // . (($hasService > 0 && $sMapping->isExpired() == FALSE && $free_gift > 0) ? ", còn $free_gift lượt miễn phí" : "");

//        $canWatch = $asset->is_free == 1 || $watchPurchase;
//        $canSendGift = $asset->is_free == 1 || $giftPurchase;

        $cats = $asset->vodCategoryAssetMappings;
        $nameCats = " ";
        foreach ($cats as $cat) {
            $catModel = VodCategory::model()->findByPk($cat->vod_category_id);
            $nameCats .= $catModel->display_name . ',';
        }
        $this->page_id = "video_index_$id";
        $this->render('index', array(
            'asset' => $asset,
            'watchUrl' => $watchUrl,
//            'watchPrice' => $watchPrice,
//            'canWatch' => $canWatch,
//            'trailerUrl' => $trailerUrl,
//            'trailerPrice' => $trailerPrice,
//            'haveTrailer' => $haveTrailer,
//            'giftUrl' => $giftUrl,
//            'giftPrice' => $giftPrice,
//            'canSendGift' => $canSendGift,
            'posterUrl' => $posterUrl,
            'catenames' => $nameCats,
            'related' => $relatedVods,
//            'comments' => $comments,
            'page_id' => 'video_index'));
    }

    public function actionBrowse() {
        $category_id = isset($_REQUEST['category']) && preg_match("/^\d+$/", $_REQUEST['category']) ?
                $_REQUEST['category'] : null;
        $order_by = isset($_REQUEST['order']) && preg_match("/(newest|most_viewed)/", $_REQUEST['order']) ?
                $_REQUEST['order'] : "";
        $page = isset($_REQUEST['page']) && preg_match("/^\d+$/", $_REQUEST['page']) ?
                $_REQUEST['page'] : 0;
        $pageSize = isset($_REQUEST['page_size']) && preg_match("/^\d+$/", $_REQUEST['page_size']) ?
                $_REQUEST['page_size'] : $this->pageSize;
        $keyword = null;
        $page = $page > 0 ? $page - 1 : 0;

        $db_order = "";
        $categoryName = "";
        switch ($order_by) {
            case "newest":
                $db_order = 't.create_date DESC';
                $categoryName = "Video xe mới nhất";
                break;
            case "most_viewed":
                $db_order = 't.view_count DESC';
                $categoryName = "Video xe xem nhiều";
                break;
            case "top_rated":
                $db_order = 't.rating_count DESC';
                $categoryName = "Video xe bình chọn nhiều";
                break;
            case "most_discussed":
                $db_order = 't.comment_count DESC';
                $categoryName = "Video xe bình luận nhiều";
                break;
            case "featured"://not support now
            // $models = Asset::model()->findAll();
            //break;
            default: //case "default":
                $order = 'default';
                $db_order = "t.create_date DESC, t.honor, t.code_name";
                $categoryName = "Video xe đang hot";
                break;
        }

        if (isset($category_id)) {
            $catModel = new VodCategory();
            $category = $catModel->findByPk($category_id);
            if (isset($category))
                $categoryName = $category->display_name;
        }

        $result = VodAsset::findVODs($category_id, $db_order, $page, $pageSize, $keyword);
        $assets = $result['data'];
//        for ($i = 0; $i < count($assets); $i++) {
//            $assets[$i] = CUtils::loadVodPoster($assets[$i]);
            //Cheat so luot xem theo ngay up len
//            $assets[$i]['view_count'] += CUtils::getVirtualView($assets[$i]['create_date']);
//            $assets[$i]['encrypted_id'] = $this->crypt->encrypt($assets[$i]['id']);
//        }
        $pager = array();
        foreach (array('total_result', 'page_number', 'page_size', 'total_page') as $e) {
            if (array_key_exists($e, $result))
                $pager[$e] = $result[$e];
        }
        $this->page_id = "video_browse";
        $this->render('browse', array(
            'type' => 'browse',
            'category' => $categoryName,
            'assets' => $assets,
            'category_id' => $category_id,
            'order_by' => $order_by,
            'pager' => $pager,
            'page_id' => 'video_browse'
        ));
    }

    public function actionSearch($q, $page = 1) {
        if (!isset($q) || $q == "") {
            return $this->redirect(array("video/browse"));
        }
        if (!isset($page) || $page < 1)
            $page = 1;

        $result = VodAsset::findVODs(null, null, $page - 1, $this->pageSize, $q);
        $assets = $result['data'];
        for ($i = 0; $i < count($assets); $i++) {
            $assets[$i] = CUtils::loadVodPoster($assets[$i]);
            //Cheat so luot xem theo ngay up len
            $assets[$i]['view_count'] += CUtils::getVirtualView($assets[$i]['create_date']);
            $assets[$i]['encrypted_id'] = $this->crypt->encrypt($assets[$i]['id']);
        }

        $pager = array();
        foreach (array('total_result', 'page_number', 'page_size', 'total_page') as $e) {
            if (array_key_exists($e, $result))
                $pager[$e] = $result[$e];
        }
        $this->page_id = "video_search";
        $this->render('browse', array(
            'type' => 'search',
            'keyword' => $q,
            'category' => "Kết quả tìm kiếm",
            'assets' => $assets,
            'category_id' => "",
            'order_by' => null,
            'pager' => $pager,
            'page_id' => 'video_search'
        ));
    }

    public function actionWatch($id) {
//        try {
//            $id = $this->crypt->decrypt($id);
//            if (preg_match('/^(\d+)/', $id, $matches)) {
//                $id = $matches[1];
//            } else {
//                throw new Exception('Invalid encrypted id');
//            }
//        } catch (Exception $e) {
//            return $this->redirect(array('/'));
//        }
        //View trailer video
        #TODO: check vod purchase
        if ($this->msisdn == '')
            return $this->redirect(array("video/browse"));

        $vod = VodAsset::model()->findByAttributes(array('id' => $id, 'status' => 1));
        /* $vs = isset($vod) ? $this->subscriber->hasVodAsset($vod, USING_TYPE_WATCH) : FALSE;
          $vsRecvGift = isset($vod) ? $this->subscriber->hasVodAsset($vod, USING_TYPE_RECEIVE_GIFT) : FALSE; */
//        $vs = (isset($vod) && $this->subscriber != NULL) ? $this->subscriber->hasVodAsset($vod, USING_TYPE_WATCH) : FALSE;
//        $vsRecvGift = (isset($vod) && $this->subscriber != NULL) ? $this->subscriber->hasVodAsset($vod, USING_TYPE_RECEIVE_GIFT) : FALSE;

//        $svc = NULL;
//        if ($vod->is_free != 1) {
//            if (count($this->usingServices) > 0) {
//                $svc = $this->usingServices[0];
//                //error_log("isExpired=" . $svc->isExpired() . ",vs=" .);
//                if ($svc->isExpired() && $vs === FALSE && $vsRecvGift === FALSE)
//                    return $this->redirect(array("video/browse"));
//            } else if ($vod->price > 0 && $vs === FALSE && $vsRecvGift === FALSE) {
//                return $this->redirect(array("video/browse"));
//            }
//        }

        $streams = array();
        $episode = isset($_REQUEST['episode']) ? $_REQUEST['episode'] : 0;
        if (isset($vod)) {
//                $protocol = CUtils::getSupportedStreamingProtocol();
				$protocol = 2;
                $streamType =  1;
                foreach ($vod->vodStreams as $stream) {
                    if ($stream->protocol == $protocol && $stream->stream_type == $streamType) {
                        $streams[] = $stream->stream_url;
                    }
                }
        } else {
            return $this->redirect(array("video/browse"));
        }
		$posterUrl = VodAsset::getFirstImage($id);

        $related = $vod->getRelatedVODs("rand()", 0, 5);
        $relatedVods = $related['data'];
//        for ($i = 0; $i < count($relatedVods); $i++) {
//            $relatedVods[$i] = CUtils::loadVodPoster($relatedVods[$i]);
            //Cheat so luot xem theo ngay up len
//            $relatedVods[$i]['view_count'] += CUtils::getVirtualView($relatedVods[$i]['create_date']);
//            $relatedVods[$i]['encrypted_id'] = $this->crypt->encrypt($relatedVods[$i]['id']);
//        }

//        $comments = $vod->getComments(0, 1000);
//        $comments = $comments['data'];

        $vod->view_count++;
//        if (!$viewTrailer) {
//            //Check User da xem video chua
//            $viewVideo = VodView::model()->findByAttributes(array('subscriber_id' => $this->subscriber->id, 'vod_asset_id' => $vod->id));
//            $addViewCount = FALSE;
//            if ($viewVideo != NULL) {
//                //Add them khi Video mat phi && Dang su dich vu da gia han hoac dang ky moi
//                $expireVideoView = ($viewVideo->expiry_date != NULL) ? strtotime($viewVideo->expiry_date) : 0;
//                $expireService = ($svc != NULL) ? strtotime($svc->expiry_date) : 0;
//                $currentDate = time();
//                $addViewCount = (!$vod->is_free && $svc != NULL && $expireService > $currentDate && $expireVideoView != $expireService);
//            } else {
//                $addViewCount = true;
//            }
//            if ($addViewCount) {
//                $vodView = new VodView();
//                $vodView->vod_asset_id = $vod->id;
//                $vodView->subscriber_id = $this->subscriber->id;
//                $vodView->expiry_date = ($svc == NULL) ? NULL : $svc->expiry_date;
//                $vodView->create_date = date("Y-m-d H:i:s");
//                $vodView->type = ($vod->is_free || $vod->price == 0) ? 1 : 0;
//                $vodView->save();
//            }
//        }
        $vod->save();
        $this->page_id = "video_watch";
        $this->render('watch', array('asset' => $vod,
            'url' => count($streams) > 0 ? $streams[0] : "",
        	'posterUrl'=>$posterUrl,
            'related' => $relatedVods,
//            'comments' => $comments,
            'episode' => $episode,
            'page_id' => 'video_watch'
        ));
    }

    public function actionPurchase($type) {

	$id = isset($_REQUEST['video_id'])?$_REQUEST['video_id']:0;
	$encrypt_id = $id;
	if($id == 0){
        try {
            $id = isset($_REQUEST['id'])?$this->crypt->decrypt($_REQUEST['id']):0;
	    $encrypt_id = isset($_REQUEST['id'])?$_REQUEST['id']:0;
            if (preg_match('/^(\d+)/', $id, $matches)) {
                $id = $matches[1];
            } else {
                throw new Exception('Invalid encrypted id');
            }
        } catch (Exception $e) {
            return $this->redirect(array('video/'.$id));
        }
	}
        $vod = VodAsset::model()->findByAttributes(array('id' => $id, 'status' => 1));
        if ($type == 'watch') {
            $price = $vod->price;
            $using_type = USING_TYPE_WATCH;
// 			$content_id = $charging->view_content_id;
        } else if ($type == 'download') {
            $price = $vod->price_download;
            $using_type = USING_TYPE_DOWNLOAD;
// 			$content_id = $charging->download_content_id;
        }

        //Thuc hien khi thanh toan thanh cong, vinaphone redirect ve day
        if (isset($_REQUEST['msisdn']) && isset($_REQUEST['transactionid'])) {
            $msisdn_rediect = $_REQUEST['msisdn'];
            $order_id = $_REQUEST['orderid'];
            $transaction_id = $_REQUEST['transactionid'];
            $checkout_datetime = $_REQUEST['checkoutdatetime'];
            $return_secure_code = $_REQUEST['securecode'];

            //Verify return checkout
            if (ChargingController::verifyCheckoutReturn($order_id, $checkout_datetime, $transaction_id, $return_secure_code)) {
                $subscriberOrder = SubscriberOrder::model()->findByPk($order_id);
                if ($subscriberOrder == NULL) {
                    //TODO: hien thi verify fail
                    Yii::app()->user->setFlash('responseToUser', "Verify fail!");
                    return $this->redirect(array('video/'.$id));
                }
// 				$subscriberOrder->transaction_id = $transaction_id;
                $timestamp = DateTime::createFromFormat('YmdHis', $checkout_datetime)->getTimestamp();
                $subscriberOrder->transaction_date = $timestamp;
                $subscriberOrder->status  = 1;
                $subscriberOrder->error_code = 'SUCCESS';
                $subscriberOrder->update();
                //TODO: thuc hien tiep khi thanh toan thanh cong
                if ($this->subscriber == null) {
                    $this->subscriber = Subscriber::newSubscriber($this->msisdn);
                }

                $vodSubsMapping = $this->subscriber->addVodAsset($vod, $using_type);
                if ($type == 'watch') {
                    $responseToUser = 'Quý khách đã mua phim ' . $vod->display_name;
                    $this->redirect(array("video/watch?id=" . urlencode($encrypt_id)));
                } else if ($type == 'download') {
                    $responseToUser = 'Quý khách đã download phim ' . $vod->display_name;
                    $this->redirect(array("video/download?id=" . urlencode($encrypt_id) . ($vod->is_series ? "/episode/1" : "")));
                } else {
                    $this->redirect(array("video/" . $vod->id));
                }

            } else {
                //TODO: hien thi verify fail
                Yii::app()->user->setFlash('responseToUser', "Verify fail!");
                return $this->redirect(array('video/'.$id));
            }
            return;
        }

        //Thuc hien khi cancel
        if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'cancel') {
            //TODO: Hien thi thanh toan loi cho nguoi dung tren WAP
            return $this->redirect(array('video/'.$id));
        }


        if ($this->msisdn != '' && isset($vod)) {
            if ($this->subscriber == null) {
                $this->subscriber = Subscriber::newSubscriber($this->msisdn);
            }

//  			$charging = new ChargingProxy();

            $received_number = isset($_REQUEST['received_number']) ? $_REQUEST['received_number'] : "";
            $content_id = "";

            // xem co dang ky dich vu chua? neu co la dich vu gi?
            $hasService = count($this->usingServices);
            $sMapping = $hasService > 0 ? $this->usingServices[0] : null;

            // kiem tra xem co can tru tien khong?
            $doCharging = true;
            if ($type == 'watch') {
                $vsWatch = $this->subscriber->hasVodAsset($vod, USING_TYPE_WATCH);
                // kiem tra xem da dang ky dich vu va con hieu luc? hoac da mua phim nay? hoac da duoc tang phim nay?
                $doCharging = !(($hasService && $sMapping->isExpired() == FALSE) || $vsWatch !== FALSE || $price == 0);
            } else if ($type == 'download') {
                $vsDownload = $this->subscriber->hasVodAsset($vod, USING_TYPE_DOWNLOAD);
                $free_download = isset($sMapping) ? $sMapping->service->free_download_count - $sMapping->download_count : 0;
                // goi cuoc con hieu luc va co free download? hoac da tung tra tien cho phim nay?
                $doCharging = !(($hasService > 0 && $sMapping->isExpired() == FALSE && $free_download > 0) || $vsDownload !== FALSE || $price == 0);
            }

            if ($vod->is_free == 1)
                $doCharging = false;

            $responseToUser = "";
            $chargingOK = true;
            if ($doCharging) {
                //Ko cho chargin khi truy cap qua wifi
                if ($this->accessType != Controller::$ACCESS_VIA_3G) {
                    Yii::app()->user->setFlash('responseToUser', "Quí khách truy cập 3G của Vinaphone mới sử dụng được tính năng này!");
                    $this->redirect(Yii::app()->homeUrl);
                }

                $subscriberOrder = $this->subscriber->newOrder(CHANNEL_TYPE_WAP, $using_type, PURCHASE_TYPE_NEW, null, $vod);
                $order_id = $subscriberOrder->id;

// 				$response = $charging->debitAccount($order_id, $this->msisdn, $this->msisdn, $price, $charging->content_category_id, $content_id);
                $returnUrl = str_replace('dev.vinaphim', 'mobiphim', Yii::app()->createAbsoluteUrl(Yii::app()->request->url));
                $backUrl = str_replace('dev.vinaphim', 'mobiphim', Yii::app()->createAbsoluteUrl(Yii::app()->request->url)) . '&action=cancel';
                $this->redirect(ChargingController::makeCheckoutUrl($order_id, $vod->display_name, date('YmdHis'), $price, $price, "0", $returnUrl, $backUrl), true);
            }else{
		return $this->redirect(array("video/watch?id=".urlencode($encrypt_id)));
	    }
        } else {
            return $this->redirect(array("video/browse"));
        }
    }

    public function actionDownload($id, $episode = null) {
        try {
            $id = $this->crypt->decrypt($id);
            if (preg_match('/^(\d+)/', $id, $matches)) {
                $id = $matches[1];
            } else {
                throw new Exception('Invalid encrypted id');
            }
        } catch (Exception $e) {
            return $this->redirect(array('/'));
        }

        #TODO: check download purchase
        if ($this->msisdn == '')
            return $this->redirect(array("video/browse"));

        $vod = VodAsset::model()->findByAttributes(array('id' => $id, 'status' => 1));

        $vsDownload = $this->subscriber->hasVodAsset($vod, USING_TYPE_DOWNLOAD);
        $smap = count($this->usingServices) > 0 ? $this->usingServices[0] : null;

        if ($vod->is_free != 1) {
            if (count($this->usingServices) > 0) {
                $svc = $this->usingServices[0];

                if ($vsDownload === FALSE) {
                    if ($svc->download_count >= $svc->service->free_download_count) {
                        return $this->redirect(array("video/browse"));
                    } else {
                        $this->subscriber->addVodAsset($vod, USING_TYPE_DOWNLOAD, false);
                        $svc->download_count++;
                        $svc->save();
                    }
                }
            } else if ($vod->price_download > 0 && $vsDownload === FALSE) {
                return $this->redirect(array("video/browse"));
            }
        }

        $streams = array();

        if (isset($vod)) {
            if ($vod->is_series) {
                if ($episode == null) {
                    $episode = 0;
                } else {
                    if ($episode > 0)
                        $episode--;
                    else
                        $episode = 0;
                }
                $vodEpisode = $vod->vodEpisodes[$episode];

                foreach ($vodEpisode->vodStreams as $stream) {
                    if ($stream->protocol == CUtils::$STREAMING_HTTP) {
                        $streams[] = $stream->stream_url;
                    }
                }
            } else {
                foreach ($vod->vodStreams as $stream) {
                    if ($stream->protocol == CUtils::$STREAMING_HTTP) {
                        $streams[] = $stream->stream_url;
                    }
                }
            }
            if (count($streams) > 0) {
                //echo $streams[0];
                //return $this->redirect($streams[0]);
                if (preg_match('/vod\/(.*)$/', $streams[0], $matches)) {
                    $filepath = "vod/" . $matches[1];

                    $fh = fopen($filepath, "r");
                    if ($fh) {
                        $this->layout = false;
                        header('Content-type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="' . $matches[1] . '"');
                        $info = CUtils::getDeviceInfo();
                        if ($info['os'] != 'symbian')
                            header('Content-Length: ' . filesize($filepath));

                        while ($data = fread($fh, 4096)) {
                            echo $data;
                        }

                        fclose($fh);
                        Yii::app()->end();
                    } else {
                        Yii::app()->user->setFlash('responseToUser', "Không thể download phim. Xin vui lòng thử lại sau.");
                        return $this->redirect(array("video/" . $vod->id));
                    }
                } else {
                    Yii::app()->user->setFlash('responseToUser', "Không thể download phim. Xin vui lòng thử lại sau.");
                    return $this->redirect(array("video/" . $vod->id));
                }
            } else {
                Yii::app()->user->setFlash('responseToUser', "Không thể download phim. Xin vui lòng thử lại sau.");
                return $this->redirect(array("video/" . $vod->id));
            }
        } else {
            return $this->redirect(array("video/browse"));
        }
    }

    public function actionConfirm($type, $id) {
        $vod = VodAsset::model()->findByAttributes(array('id' => $id, 'status' => 1));
        if ($vod) {
            $price = 0;
            if ($type == 'watch')
                $price = $vod->price;
            else if ($type == 'download')
                $price = $vod->price_download;
            else if ($type == 'gift')
                $price = $vod->price_gift;
            else
                return $this->redirect(array("video/browse"));

            $this->render('confirm', array('asset' => $vod, 'price' => $price, 'nextUrl' => Yii::app()->baseUrl . "/video/purchase/$type/id/$id"));
        } else {
            return $this->redirect(array("video/browse"));
        }
    }

    public function actionRateVOD() {
        header('Content-Type: application/json; charset="UTF-8"');
        $vodID = isset($_REQUEST['vod']) ? $_REQUEST['vod'] : 0;
        $mobileNumber = $this->msisdn;
        $stars = isset($_REQUEST['rate']) ? intval($_REQUEST['rate']) : '0';

        if ($mobileNumber == '') {
            echo json_encode(array('message' => ' Xin vui lòng truy cập dịch vụ bằng 3G/EDGE của Vinaphone, hoặc đăng nhập bằng wifi'));
            Yii::app()->end();
        }

        $apiService = new APIService();
        $response = $apiService->rateVOD($vodID, $mobileNumber, $stars);
        if ($response == NULL) {
            echo json_encode(array('message' => 'Lỗi trong quá trình xử lý, xin vui lòng thử lại sau'));
            Yii::app()->end();
        } else {
            if ($response->error_no == 0) {
                echo json_encode(array('message' => 'Đánh giá của bạn đã được ghi nhận, cám ơn bạn đã đóng góp ý kiến'));
                Yii::app()->end();
            } else {
                echo json_encode(array('message' => 'Lỗi trong quá trình xử lý, xin vui lòng thử lại sau'));
                Yii::app()->end();
            }
        }
    }

}
