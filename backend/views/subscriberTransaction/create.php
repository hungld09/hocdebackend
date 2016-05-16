<?php
$this->breadcrumbs=array(
	'Subscriber Transactions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SubscriberTransaction','url'=>array('index')),
	array('label'=>'Manage SubscriberTransaction','url'=>array('admin')),
);
?>

<h1>Create SubscriberTransaction</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>