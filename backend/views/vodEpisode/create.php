<?php
$this->breadcrumbs=array(
	'Vod Episodes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List VodEpisode', 'url'=>array('index')),
	array('label'=>'Manage VodEpisode', 'url'=>array('admin')),
);
?>

<h1>Thêm tập phim</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>