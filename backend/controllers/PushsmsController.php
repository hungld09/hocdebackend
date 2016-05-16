<?php
class PushsmsController extends Controller
{
    public function actionIndex()
    {
//        $x = time()-15*24*60*60;
//        echo date('Y-m-d H:i:s',$x);die;
        $this->render('index');
    }
    public function actionSendSms(){
        if (empty($_POST['fileToUpload'])) {
            echo "Bạn chưa chọn file upload";die;
        }
        if(strlen($_POST['textSms']) == 0 || strlen(trim($_POST['textSms'])) == 0){
            echo "Bạn chưa nhap noi dung";die;
        }
        $content = array();
        $fullFileName = '/var/www/html/vfilmbackend/backend/www/upload/'. $_POST['fileToUpload'];
        $file = file($fullFileName);
        $relations = array();
        $listSubFail = '';
        $success = 0;
        $fail = 0;
        $suc_cf = 0;
        $mtMessage = $_POST['textSms'];
        for ($i = 0; $i < count($file); $i++) {
            $k=0;
            $f=0;
            $h=0;
            $relation = explode(";", trim($file[$i]));
//            $subs = $this->validatorMobile($relation[0]);
            $subscriber = Subscriber::model()->findByAttributes(array('subscriber_number'=>$relation[0]));
            if($subscriber == NULL) {
                $subscriber = Subscriber::newSubscriber($relation[0]);
            }
            sleep(0.1);
            $subPromotion = PushSms::model()->findByAttributes(array('subscriber_id'=>$subscriber->id, 'status'=>1));
            if(count($subPromotion) == 0){
                $mt = VinaphoneController::sendSms($relation[0], $mtMessage);
                if ($mt->mt_status == 0) {
                    $k++;
                    $success +=$k;
                    $promotion = new PushSms;
                    $promotion->subscriber_id = $subscriber->id;
                    $promotion->sms_id = $mt->id;
                    $promotion->status = 1;
                    $promotion->create_date = date('Y-m-d H:i:s');
                    $promotion->modify_date = date('Y-m-d H:i:s');
                    if(!$promotion->save()){
                       echo '<pre>'; print_r($promotion->getErrors());die;
                    }
                }else{
                    $f++;
                    $fail +=$f;
                    $promotion = new PushSms;
                    $promotion->subscriber_id = $subscriber->id;
                    $promotion->sms_id = $mt->id;
                    $promotion->status = 2;
                    $promotion->create_date = date('Y-m-d H:i:s');
                    $promotion->modify_date = date('Y-m-d H:i:s');
                    if(!$promotion->save()){
                        echo '<pre>'; print_r($promotion->getErrors());die;
                    }
                    $data = (array(
                        $i => array(
                            $relation[0],
                        ))
                    );
                    $content = array_merge_recursive($content, $data);
                }
            }else{
                $h ++;
                $suc_cf +=$h;
//                echo $relation[0] . '&nbsp; Da push sms roi <br/>';
            }
        }
        echo 'Tong so thue bao push thanh cong: '.$success.'<br/>';
        echo 'Tong so thue bao push roi: '.$suc_cf.'<br/>';
        echo 'Tong so thue bao pust that bai: '.$fail.'<br/>';
        $this->renderPartial('_showcontent', array(
            'model' => $content,
        ));
    }
    public static function validatorMobile($mobileNumber, $typeFormat = 0){
        if(strpos($mobileNumber, '484888') > 0) { //for testing performance
                return $mobileNumber;
        }
        $valid_number = '';
        if(preg_match('/^(84|0|)(91|94|123|124|125|127|129)\d{7}$/', $mobileNumber, $matches)){
                /**
                 * $typeFormat == 0: 8491xxxxxx
                 * $typeFormat == 1: 091xxxxxx
                 * $typeFormat == 2: 91xxxxxx
                 */
                if($typeFormat == 0){
                        if ($matches[1] == '0' || $matches[1] == ''){
                                $valid_number = preg_replace('/^(0|)/', '84', $mobileNumber);
                        }else{
                                $valid_number = $mobileNumber;
                        }
                }else if($typeFormat == 1){
                        if ($matches[1] == '84' || $matches[1] == ''){
                                $valid_number = preg_replace('/^(84|)/', '0', $mobileNumber);
                        }else{
                                $valid_number = $mobileNumber;
                        }
                }else if ($typeFormat == 2){
                        if ($matches[1] == '84' || $matches[1] == '0'){
                                $valid_number = preg_replace('/^(84|0)/', '', $mobileNumber);
                        }else{
                                $valid_number = $mobileNumber;
                        }
                }

        }
        return $valid_number;
    }
    public function actionToolSms(){
        $this->render('toolsms');
    }
    public function actionToolreportsms(){
        if (empty($_POST['fileToUpload'])) {
            echo "Bạn chưa chọn file upload";die;
        }
        $date = date('Y-m-d 00:00:00', strtotime($_POST['from_date']));
        $fullFileName = '/var/www/html/vfilmbackend/backend/www/upload/'. $_POST['fileToUpload'];
        $file = file($fullFileName);
        $relations = array();
        $relations1 = array();
        $relations2 = array();
        $relations3 = array();
        for ($i = 0; $i < count($file); $i++) {
             $relation3 = explode(";", trim($file[$i]));
             $relations2[]= $relation3[0];
        }
        //tap 1
//        $subscriber = Subscriber::model()->findByAttributes(array('subscriber_number'=>$relation[0]));
        $resulfHuys = Yii::app()->db->createCommand()
            ->select("s.subscriber_number")
            ->from("subscriber s")
            ->join("subscriber_transaction st", "s.id = st.subscriber_id")
            ->where("st.create_date > '$date' and st.purchase_type = 3")
            ->queryAll();
        foreach ($resulfHuys as $resulfHuy){
            $relations[]= $resulfHuy['subscriber_number'];
        }
        $x = array_intersect($relations2,$relations);
        //tap 2
        $resulfdks = Yii::app()->db->createCommand()
            ->select("s.subscriber_number")
            ->from("subscriber s")
            ->join("subscriber_transaction st", "s.id = st.subscriber_id")
            ->where("st.create_date > '$date' and st.purchase_type = 1")
            ->queryAll();
        foreach ($resulfdks as $resulfdk){
            $relations1[]= $resulfdk['subscriber_number'];
        }
        $y = array_intersect($relations2,$relations1);     
        
        echo 'Tong so thue bao Huy: '.count($x).'<br/>';
        echo 'Tong so thue bao truy cap: '.count($y).'<br/>';
    }
}