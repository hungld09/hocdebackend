<?php
$this->breadcrumbs=array(
	'Subscriber'=>array('index'),
	'Manage',
);
?>

<?php
	/* @var $model Subscriber */ 
	$this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'subscriber_number',
// 		array(
// 				'name'=>'status',
// 				// 			'value'=>$model->html_content,
// 				'value'=> $model->getStatusLabel(),
// 				'htmlOptions'=>array('class'=>'html', 'rows'=>6,'height'=>'60px', 'width'=>'100px', 'style' => 'max-height:50px;'),
// // 				'filter' => $arrBrand,
// 		),
// 		'email',
		array(
				'name'=>'auto_recurring',
				// 			'value'=>$model->html_content,
				'value'=> $model->getAutoRecurringLabel(),
				'htmlOptions'=>array('class'=>'html', 'rows'=>6,'height'=>'60px', 'width'=>'100px', 'style' => 'max-height:50px;'),
				// 				'filter' => $arrBrand,
		),
		'avatar_url',
		'yahoo_id',
// 		'google_id',
		'create_date',
		array(
				'name'=>'client_app_type',
				// 			'value'=>$model->html_content,
				'value'=> $model->getClientType(),
				'htmlOptions'=>array('class'=>'html', 'rows'=>6,'height'=>'60px', 'width'=>'100px', 'style' => 'max-height:50px;'),
// 				'filter' => $arrBrand,
		),
		array(
				'name'=>'usingStatus',
				// 			'value'=>$model->html_content,
				'value'=> $model->getUsingServiceStr(),
				'htmlOptions'=>array('class'=>'html', 'rows'=>6,'height'=>'60px', 'width'=>'100px', 'style' => 'max-height:50px;'),
// 				'filter' => $arrBrand,
		),
// 		'using_promotion',
	),
)); ?>

<?php 
	if(User::getRoleLevel(Yii::app()->user->id) == 3) {
		$btnLabel = "";
		if($model->status == Subscriber::STATUS_WHITE_LIST) {
			$btnLabel = "Xóa khỏi danh sách miễn phí";
			$status = 1;
		}
		else {
			$btnLabel = "Lưu vào danh sách miễn phí";
			$status = 10;
		}
		
		$this->menu=array(
		// 	array('label'=>'List Subscriber','url'=>array('index')),
			array('label'=>$btnLabel,'url'=>array("subscriber/changeStatus/status/$status/id/$model->id")),
		);
	}
?>