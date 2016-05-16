<?php
$this->breadcrumbs=array(
	'Subscribers',
);

$this->menu=array(
	array('label'=>'Create Subscriber','url'=>array('create')),
	array('label'=>'Manage Subscriber','url'=>array('admin')),
);
?>

<h1>Subscribers</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
