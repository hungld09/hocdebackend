<?php
$this->breadcrumbs=array(
	'Service Subscriber Mappings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ServiceSubscriberMapping','url'=>array('index')),
	array('label'=>'Create ServiceSubscriberMapping','url'=>array('create')),
	array('label'=>'View ServiceSubscriberMapping','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage ServiceSubscriberMapping','url'=>array('admin')),
);
?>

<h1>Update ServiceSubscriberMapping <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>