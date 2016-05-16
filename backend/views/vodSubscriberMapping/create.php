<?php
$this->breadcrumbs=array(
	'Vod Subscriber Mappings'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VodSubscriberMapping','url'=>array('index')),
	array('label'=>'Manage VodSubscriberMapping','url'=>array('admin')),
);
?>

<h1>Create VodSubscriberMapping</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>