<?php
$this->breadcrumbs=array(
	'Subscriber Feedbacks'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SubscriberFeedback','url'=>array('index')),
	array('label'=>'Manage SubscriberFeedback','url'=>array('admin')),
);
?>

<h1>Create SubscriberFeedback</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>