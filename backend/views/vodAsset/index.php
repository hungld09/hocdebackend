<?php
$this->breadcrumbs=array(
	'Vod Assets',
);

$this->menu=array(
	array('label'=>'Create VodAsset','url'=>array('create')),
	array('label'=>'Manage VodAsset','url'=>array('admin')),
);
?>

<h1>Vod Assets</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
