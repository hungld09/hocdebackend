<?php
$this->breadcrumbs=array(
	'Subscriber'=>array('index'),
	'Manage',
);
?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'service-form',
	'enableAjaxValidation'=>true,
        'enableClientValidation'=>true
)); ?>
<div class="flash-message">
	<?php echo Yii::app()->user->getFlash('response'); ?>
</div>

<div class="form-actions" style="width:100%">
	<div class="content-sms">
	    <h2>
		<legend class="legend"><b>Gửi tin nhắn đến thuê bao</b></legend>
		</h2>
		<!-- 
	        <div class="row">
	      <?php 
		      $list=CHtml::listData(Service::model()->findAllByAttributes(array("is_active"=>1)), 'id', 'display_name'); 
		      echo $form->dropDownList($model,'id',$list,array('empty'=>'Chọn gói cước')); 
	//	      echo $form->hiddenField($model,'categories');  
	      ?>
		
			</div>
			<br/>
			 -->
	<fieldset>
	    <legend class="legend"><b>Tin nhắn</b></legend>
	    <div>
	            <?php
					echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>20,'class'=>'textinput','maxlength'=>300,'style'=>'width: 300px; height: 80px;'));
					echo $form->error($model,'message');
					echo $form->hiddenField($model,'id');  
	            ?>
	    </div>
	    <?php echo CHtml::htmlButton('Gửi tin nhắn', array('class' => 'btn btn-primary btn-lg', 'style'=>'width:100px','type'=>'btn','submit' => array('subscriber/sendSMS'),'confirm' => "Bạn chắc chắn muốn gửi tin nhắn đến thuê bao $model->subscriber_number ?")); ?>
	    <?php //echo CHtml::htmlButton('Gửi tin nhắn', array('class' => 'btn btn-primary btn-lg','style'=>'width:100px', 'type'=>'btn','onclick'=>'js:sendSMS();','confirm' => 'Are you sure?')); ?>
	</fieldset>
</div>
<!-- 
<div class="content-asset">
	<h2>
		<legend class="legend"><b>Gửi nội dung</b></legend>
		</h2>
		<div class="row">
	      <?php 
		      $list=CHtml::listData(Service::model()->findAllByAttributes(array("is_active"=>1)), 'id', 'display_name'); 
		      echo $form->dropDownList($model,'id',$list,array('empty'=>'Chọn gói cước')); 
	//	      echo $form->hiddenField($model,'categories');  
	      ?>
		
			</div>
	<fieldset>
	    <legend class="legend"><b>Phim lẻ</b></legend>
	    <div>
	            <?php
					echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>20,'class'=>'textinput','maxlength'=>300,'style'=>'width: 300px; height: 80px;'));
					echo $form->error($model,'message');
	            ?>
	    </div>
	    <?php echo CHtml::htmlButton('Gửi Phim', array('class' => 'btn btn-primary btn-lg', 'style'=>'width:80px','type'=>'btn','submit' => array('subscriber/sendAsset'),'confirm' => 'Are you sure?')); ?>
	</fieldset>
	 </div>
  -->
</div>

<div class="form-actions" align="left" style="width:100%">
	    <h2>
		<legend class="legend"><b>Đăng ký/Hủy dịch vụ</b></legend>
		</h2>
<?php 
if(!$model->isUsingService()) {
    $list=CHtml::listData(Service::model()->findAllByAttributes(array("is_active"=>1)), 'id', 'display_name');
    echo $form->dropDownList($model,'service_id',$list,array('empty'=>'Chọn gói cước'));
    echo "<br/>";
    echo $form->hiddenField($model, 'id');
	echo CHtml::htmlButton('Đăng ký',array('class' => 'btn btn-primary btn-lg', 'type'=>'btn','submit' => array('subscriber/sendRegister'),'confirm' => 'Are you sure?')); echo "&nbsp;";
}
?>
<?php
if($model->isUsingService()) {
    $mapping = ServiceSubscriberMapping::model()->findAllByAttributes(array("is_active"=>1, 'subscriber_id' => $model->id));
    $arr = array();
    foreach($mapping as $item){
        $arr[] = $item->service_id;
    }
    $arr = implode(',', $arr);
    $list=CHtml::listData(Service::model()->findAllByAttributes(array(), array('condition'=>'id in ('. $arr .')',)), 'id', 'display_name');
    echo $form->dropDownList($model,'service_id',$list,array('empty'=>'Chọn gói cước'));
    echo "<br/>";
    echo $form->hiddenField($model, 'id');
	echo CHtml::htmlButton('Hủy dịch vụ', array('class' => 'btn btn-primary btn-lg', 'type'=>'btn','submit' => array('subscriber/sendCancelSerivce'), 'confirm' => 'Are you sure?'));  echo "&nbsp;";
}
?>
<?php
//if($model->auto_recurring == 0) {
//	echo CHtml::htmlButton('Đăng ký tự gia hạn', array('class' => 'btn btn-primary btn-lg', 'type'=>'btn','submit' => array('subscriber/sendAutoRegisterRecur'),'confirm' => 'Are you sure?'));  echo "&nbsp;";
//}
//?>
<?php
//if($model->auto_recurring == 1) {
//	echo CHtml::htmlButton('Hủy tự gia hạn', array('class' => 'btn btn-primary btn-lg', 'type'=>'btn','submit' => array('subscriber/sendCancelAutoRegisterRecur'),'confirm' => 'Are you sure?'));  echo "&nbsp;";
//}
//?>

<?php 
// if(!$model->isUsingService()) {
// 	echo CHtml::htmlButton('Tặng miễn phí', array('class' => 'btn btn-primary btn-lg', 'type'=>'btn','submit' => array('subscriber/sendGiftFree'),'confirm' => 'Are you sure?'));  echo "&nbsp;";
// }
?>
</div>

<?php $this->endWidget(); ?>