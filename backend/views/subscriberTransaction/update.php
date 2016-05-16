<?php
$this->breadcrumbs=array(
	'Subscriber Transactions'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SubscriberTransaction','url'=>array('index')),
	array('label'=>'Create SubscriberTransaction','url'=>array('create')),
	array('label'=>'View SubscriberTransaction','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SubscriberTransaction','url'=>array('admin')),
);
?>

<h1>Update SubscriberTransaction <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>