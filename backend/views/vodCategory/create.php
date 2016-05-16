<?php
$this->breadcrumbs=array(
	'Vod Categories'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage VodCategory', 'url'=>array('admin')),
);
?>

<h1>Create VodCategory</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>