<?php
$this->breadcrumbs=array(
	'Subscribers'=>array('index'),
	'Manage',
);

// $this->menu=array(
// 	array('label'=>'List Subscriber','url'=>array('index')),
// 	array('label'=>'Create Subscriber','url'=>array('create')),
// );

?>

<h1>Danh sách thuê bao</h1>

<?php 
$arrClientAppType = array('1'=>'WAP', 2=>'Android', 3=>'iOS', 4=>'Windows Phone');
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'subscriber-grid',
	'type'=>'striped bordered',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
// 		'id',
		array(
				'name'=>'subscriber_number',
				'type'=>'html',
				'value'=> '$data->getSubscriberLink()',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'20px', 'width'=>'100px', 'style' => 'max-height:50px;'),
				// 				'filter' => $arrBrand,
		),
		array(
				'name'=>'client_app_type',
				// 			'value'=>$model->html_content,
				'value'=> 'CHtml::encode(substr($data->getClientType(), 0, 15))',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'20px', 'width'=>'100px', 'style' => 'max-height:50px;'),
				'filter' => $arrClientAppType,
		),
		'create_date',
		array(
				'name'=>'usingStatus',
				// 			'value'=>$model->html_content,
				'value'=> 'CHtml::encode(substr($data->getUsingServiceStatus(), 0, 25))',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'20px', 'width'=>'100px', 'style' => 'max-height:50px;'),
// 				'filter' => $arrStatus,
		),
// 		'user_name',
// 		'status',
// 		'status_log',
// 		'email',
		/*
		'full_name',
		'password',
		'last_login_time',
		'last_login_session',
		'birthday',
		'sex',
		'avatar_url',
		'yahoo_id',
		'skype_id',
		'google_id',
		'zing_id',
		'facebook_id',
// 		'create_date',
		'modify_date',
		'client_app_type',
		'using_promotion',
		'auto_recurring',
		'reserve_column',
		'verification_code',
		'point1',
		'point2',
		'point3',
		'point4',
		*/
// 		array(
// 			'class'=>'bootstrap.widgets.TbButtonColumn',
// 			'template' => '{view}',
// // 			'template' => '{view}{update}',
// 		),
	),
)); ?>
