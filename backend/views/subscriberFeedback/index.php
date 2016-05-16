<?php
$this->breadcrumbs=array(
	'Subscriber Feedbacks',
);

$this->menu=array(
	array('label'=>'Create SubscriberFeedback','url'=>array('create')),
	array('label'=>'Manage SubscriberFeedback','url'=>array('admin')),
);
?>

<h1>Subscriber Feedbacks</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
