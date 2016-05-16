<?php
$this->breadcrumbs=array(
	'Vod Categories'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VodCategory', 'url'=>array('index')),
	array('label'=>'Create VodCategory', 'url'=>array('create')),
	array('label'=>'View VodCategory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage VodCategory', 'url'=>array('admin')),
);
?>

<h1>Update VodCategory <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>