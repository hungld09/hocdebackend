<?php
$this->breadcrumbs=array(
	'Vod Episodes',
);

$this->menu=array(
	array('label'=>'Create VodEpisode', 'url'=>array('create')),
	array('label'=>'Manage VodEpisode', 'url'=>array('admin')),
);
?>

<h1>Vod Episodes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
