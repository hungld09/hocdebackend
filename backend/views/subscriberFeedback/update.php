<?php
$this->breadcrumbs=array(
	'Subscriber Feedbacks'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SubscriberFeedback','url'=>array('index')),
	array('label'=>'Create SubscriberFeedback','url'=>array('create')),
	array('label'=>'View SubscriberFeedback','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SubscriberFeedback','url'=>array('admin')),
);
?>

<h1>Update SubscriberFeedback <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>