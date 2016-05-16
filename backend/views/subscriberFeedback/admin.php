<?php
$this->breadcrumbs=array(
	'Subscriber Feedbacks'=>array('index'),
	'Manage',
);
?>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'subscriber-feedback-grid',
	'type'=>'striped bordered',
	'dataProvider'=>$model->getListFeedBack(),
	'filter'=>$model,
	'columns'=>array(
// 		'id',
		array(
				'name'=>'subscriber_id',
				// 			'value'=>$model->html_content,
				'value'=> '$data->subscriber->subscriber_number',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'100px', 'style' => 'max-height:50px;'),
		),
		array(
				'name'=>'title',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'200px', 'style' => 'max-height:50px;'),
		),
		array(
				'name'=>'content',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'400px', 'style' => 'max-height:50px;'),
		),
		array(
				'name'=>'create_date',
				'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'30px', 'width'=>'150px', 'style' => 'max-height:50px;'),
		),
// 		'status',
		/*
		'status_log',
		'is_responsed',
		'response_date',
		'response_user_id',
		'response_detail',
		*/
// 		array(
// 			'class'=>'bootstrap.widgets.TbButtonColumn',
// 		),
	),
)); ?>
