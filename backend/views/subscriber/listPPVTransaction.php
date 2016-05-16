<?php
$this->breadcrumbs=array(
	'Subscriber Transactions'=>array('index'),
	'Manage',
);

?>

<h2>Lịch sử mua nội dung</h2>
<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'subscriber-transaction-grid-ppv',
	'type' => 'striped bordered',
	'dataProvider'=>$model,
// 	'filter'=>$model,
	'columns'=>array(
// 		'id',
		array(
				'name'=>'create_date',
				'htmlOptions'=>array('class'=>'html', 'rows'=>6,'height'=>'30px', 'width'=>'80px', 'style' => 'max-height:50px;'),
		),
// 		array(
// 				'name'=>'service_id',
// 				// 			'value'=>$model->html_content,
// 				'value'=> '($data->service_id != NULL)?CHtml::encode(substr($data->service->code_name, 0, 25)):""',
// 				'htmlOptions'=>array('class'=>'html', 'rows'=>6,'height'=>'30px', 'width'=>'60px', 'style' => 'max-height:50px;'),
// 		),
		array(
				'name'=>'vod_asset_id',
				// 			'value'=>$model->html_content,
				'value'=> '($data->vod_asset_id != NULL)?CHtml::encode(substr($data->vodAsset->display_name, 0, 100)):""',
				'htmlOptions'=>array('class'=>'html', 'rows'=>6,'height'=>'30px', 'width'=>'200px', 'style' => 'max-height:50px;'),
		),
// 		'vod_episode_id',
// 		'subscriber_id',
		array(
				'name'=>'cost',
				// 			'value'=>$model->html_content,
				'value'=> 'CHtml::encode(substr(intval($data->cost), 0, 30))',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'40px', 'style' => 'max-height:50px;'),
		),
		array(
				'name'=>'channel_type',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'50px', 'style' => 'max-height:50px;'),
		),
		array(
				'name'=>'purchase_type',
				// 			'value'=>$model->html_content,
				'value'=> 'CHtml::encode(substr($data->getPurchaseTypeStr(), 0, 30))',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'70px', 'style' => 'max-height:50px;'),
		),
// 		array(
// 				'name'=>'using_type',
// 				// 			'value'=>$model->html_content,
// 				'value'=> 'CHtml::encode(substr($data->getUsingTypeStr(), 0, 30))',
// 				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'70px', 'style' => 'max-height:50px;'),
// 		),
// 		array(
// 				'name'=>'description',
// 				// 			'value'=>$model->html_content,
// 				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'180px', 'style' => 'max-height:50px;'),
// 		),
// 		array(
// 				'name'=>'Ứng dụng',
// 				'value'=>'$data->getApplication()',
// 				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'90px', 'style' => 'max-height:50px;'),
// 		),
// 		array(
// 				'name'=>'vnp_username',
// 				// 			'value'=>$model->html_content,
// 				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'70px', 'style' => 'max-height:50px;'),
// 		),
// 		array(
// 				'name'=>'vnp_ip',
// 				// 			'value'=>$model->html_content,
// 				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'70px', 'style' => 'max-height:50px;'),
// 		),
// 		array(
// 				'name'=>'error_code',
// 				// 			'value'=>$model->html_content,
// 				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'70px', 'style' => 'max-height:50px;'),
// 		),
		array(
				'name'=>'statusStr',
				// 			'value'=>$model->html_content,
				'value'=> 'CHtml::encode(substr($data->getStatusStr(), 0, 30))',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'100px', 'style' => 'max-height:50px;'),
		),
		/*
		'service_number',
		'event_id',
		'req_id',
		*/
// 		array(
// 			'class'=>'bootstrap.widgets.TbButtonColumn',
// 		),
	),
));
?>
