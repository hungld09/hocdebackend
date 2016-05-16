<?php
$this->breadcrumbs=array(
	'Vod Subscriber Mappings',
);

$this->menu=array(
	array('label'=>'Create VodSubscriberMapping','url'=>array('create')),
	array('label'=>'Manage VodSubscriberMapping','url'=>array('admin')),
);
?>

<h1>Vod Subscriber Mappings</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
