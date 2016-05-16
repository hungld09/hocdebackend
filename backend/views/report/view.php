<?php
$this->breadcrumbs=array(
	'Reports'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Report','url'=>array('index')),
	array('label'=>'Create Report','url'=>array('create')),
	array('label'=>'Update Report','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Report','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Report','url'=>array('admin')),
);
?>

<h1>View Report #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'report_name',
		'report_parent_id',
		'isReport',
		'isRoot',
		'template_file',
		'url',
		'type',
	),
)); ?>
