<?php
$this->breadcrumbs=array(
	'Subscribers'=>array('index'),
	$model->id,
);

$this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		'links'=>array('Danh sách thuê bao'=>Yii::app()->baseUrl.'/subscriber/admin/',$model->subscriber_number),
));
?>

<?php
$criteriaTransRegisterCancel = new CDbCriteria;
$criteriaTransRegisterCancel = array(
		'condition'=>'subscriber_id='.$model->id . " and service_id is not null and ". "((purchase_type = 1)"." or (purchase_type = 3) or (purchase_type = 4))",
		'order'=>'id desc',
);
$modelTransRegisterCancel = new CActiveDataProvider(SubscriberTransaction::model(), array(
		'criteria'=>$criteriaTransRegisterCancel,
));

$criteriaExtend = new CDbCriteria;
$criteriaExtend = array(
		'condition'=>'subscriber_id='.$model->id . " and (purchase_type = 2 or purchase_type = 10)",
		'order'=>'id desc',
);
$modelExtend = new CActiveDataProvider(SubscriberTransaction::model(), array(
		'criteria'=>$criteriaExtend,
));

$criteriaPPV = new CDbCriteria;
$criteriaPPV = array(
		'condition'=>'subscriber_id='.$model->id . " and purchase_type = 1 and vod_asset_id is not null",
		'order'=>'id desc',
);
$modelPPV = new CActiveDataProvider(SubscriberTransaction::model(), array(
		'criteria'=>$criteriaPPV,
));

$criteriaSms = new CDbCriteria;
$criteriaSms = array(
		'condition'=>'subscriber_id='.$model->id,
		'order'=>'id desc',
);
$modelSms = new CActiveDataProvider(SmsMessage::model(), array(
		'criteria'=>$criteriaSms,
));

$criteriaStreamingLog = new CDbCriteria;
$criteriaStreamingLog = array(
		'condition'=>'subscriber_id='.$model->id,
		'order'=>'id desc',
);
$modelStreamingLog = new CActiveDataProvider(StreamingLog::model(), array(
		'criteria'=>$criteriaStreamingLog,
));
//$roles=Rights::getAssignedRoles(Yii::app()->user->id); // check for single role
//$is_show_service = false;
//foreach($roles as $role) {
//	if($role->name == User::ROLE_NAME_SYSTEM_ADMIN){
//		$is_show_service = true;
//	}
//}

if(Yii::app()->user->hasFlash('response')) $activeTab = 6; //for SubscriberController - muc dich vu
else $activeTab=0;

$level = User::getRoleLevel(Yii::app()->user->id);
if(($level == 0) || ($level == 2) || ($level == 3)){
		$this->widget('zii.widgets.jui.CJuiTabs', array(
	    'tabs'=>array(
	        'Thông tin cơ bản'=>$this->renderPartial('info', array('model'=>$model),true),
	        'Giao dịch đăng ký/hủy'=>$this->renderPartial('listTransaction',array('model'=>$modelTransRegisterCancel),true),
	    	'Giao dịch gia hạn'=>$this->renderPartial('listTransactionExtend',array('model'=>$modelExtend),true),
	    	'Giao dịch mua nội dung'=>$this->renderPartial('listPPVTransaction',array('model'=>$modelPPV),true),
	        'Lịch sử MO/MT'=>$this->renderPartial('listMessage',array('model'=>$modelSms),true),
	        'Lịch sử tương tác, sử dụng'=>$this->renderPartial('streamingLogHistory',array('model'=>$modelStreamingLog),true),
	        'Dịch vụ'=>$this->renderPartial('service',array('model'=>$model),true),
	    ),
	    'options'=>array(
	        'collapsible'=>true,
	        'selected'=>$activeTab,
	    ),
	    'htmlOptions'=>array(
	        'style'=>'width:100%;'
	    ),
	));
} else 

$this->widget('zii.widgets.jui.CJuiTabs', array(
    'tabs'=>array(
        'Thông tin cơ bản'=>$this->renderPartial('info', array('model'=>$model),true),
        'Giao dịch đăng ký/hủy'=>$this->renderPartial('listTransaction',array('model'=>$modelTransRegisterCancel),true),
	    'Giao dịch gia hạn'=>$this->renderPartial('listTransactionExtend',array('model'=>$modelExtend),true),
    	'Giao dịch mua nội dung'=>$this->renderPartial('listPPVTransaction',array('model'=>$modelPPV),true),
        'Tin nhắn'=>$this->renderPartial('listMessage',array('model'=>$modelSms),true),
        'Lịch sử tương tác, sử dụng'=>$this->renderPartial('streamingLogHistory',array('model'=>$modelStreamingLog),true),
    ),
    'options'=>array(
        'collapsible'=>true,
        'selected'=>0,
    ),
    'htmlOptions'=>array(
        'style'=>'width:100%;'
    ),
));
?>
