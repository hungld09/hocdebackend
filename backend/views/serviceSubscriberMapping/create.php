<?php
$this->breadcrumbs=array(
	'Service Subscriber Mappings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ServiceSubscriberMapping','url'=>array('index')),
	array('label'=>'Manage ServiceSubscriberMapping','url'=>array('admin')),
);
?>

<h1>Create ServiceSubscriberMapping</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>