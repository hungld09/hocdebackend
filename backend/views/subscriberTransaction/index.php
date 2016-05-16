<?php
$this->breadcrumbs=array(
	'Subscriber Transactions',
);

$this->menu=array(
	array('label'=>'Create SubscriberTransaction','url'=>array('create')),
	array('label'=>'Manage SubscriberTransaction','url'=>array('admin')),
);
?>

<h1>Subscriber Transactions</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
