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
<?php $this->endWidget(); ?>