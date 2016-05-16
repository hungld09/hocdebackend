<?php
$this->breadcrumbs=array(
	'Vod Subscriber Mappings'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List VodSubscriberMapping','url'=>array('index')),
	array('label'=>'Create VodSubscriberMapping','url'=>array('create')),
	array('label'=>'View VodSubscriberMapping','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage VodSubscriberMapping','url'=>array('admin')),
);
?>

<h1>Update VodSubscriberMapping <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>