<?php
$this->breadcrumbs=array(
	'Subscribers'=>array('index'),
	'Create',
);

$this->menu=array(
// 	array('label'=>'List Subscriber','url'=>array('index')),
	array('label'=>'Quản lý thuê bao miễn phí','url'=>array('adminWhiteList')),
);
?>

<h1>Tạo thuê bao miễn phí</h1>
<?php 
	if(isset($model->error_message)) {
		echo "<h4>". $model->error_message . "</h4>";
	}
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>