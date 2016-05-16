<?php
$this->breadcrumbs=array(
	'Vod Categories',
);

$this->menu=array(
	array('label'=>'Create VodCategory', 'url'=>array('create')),
	array('label'=>'Manage VodCategory', 'url'=>array('admin')),
);
?>

<h1>Vod Categories</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
