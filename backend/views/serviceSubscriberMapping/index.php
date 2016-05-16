<?php
$this->breadcrumbs=array(
	'Service Subscriber Mappings',
);

$this->menu=array(
	array('label'=>'Create ServiceSubscriberMapping','url'=>array('create')),
	array('label'=>'Manage ServiceSubscriberMapping','url'=>array('admin')),
);
?>

<h1>Service Subscriber Mappings</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
