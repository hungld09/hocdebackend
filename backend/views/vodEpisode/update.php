<?php
$this->breadcrumbs=array(
	'Vod Episodes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
// 	array('label'=>'List VodEpisode', 'url'=>array('index')),
// 	array('label'=>'Create VodEpisode', 'url'=>array('create')),
// 	array('label'=>'View VodEpisode', 'url'=>array('view', 'id'=>$model->id)),
// 	array('label'=>'Manage VodEpisode', 'url'=>array('admin')),
);
?>

<h1>Update VodEpisode <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_formUpdate', array('model'=>$model)); ?>