<?php
$this->breadcrumbs=array(
	'Vod Assets'=>array('index'),
	'Create',
);

$this->menu=array(
// 	array('label'=>'List VodAsset','url'=>array('index')),
	array('label'=>'Quản lý phim','url'=>array('admin')),
);
?>

<h1>Tạo phim mới</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>