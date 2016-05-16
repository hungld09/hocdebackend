<?php
$this->breadcrumbs=array(
	'Sms Messages'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List SmsMessage','url'=>array('index')),
	array('label'=>'Create SmsMessage','url'=>array('create')),
	array('label'=>'View SmsMessage','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage SmsMessage','url'=>array('admin')),
);
?>

<h1>Update SmsMessage <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>