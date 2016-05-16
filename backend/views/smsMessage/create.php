<?php
$this->breadcrumbs=array(
	'Sms Messages'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List SmsMessage','url'=>array('index')),
	array('label'=>'Manage SmsMessage','url'=>array('admin')),
);
?>

<h1>Create SmsMessage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>