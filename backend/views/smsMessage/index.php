<?php
$this->breadcrumbs=array(
	'Sms Messages',
);

$this->menu=array(
	array('label'=>'Create SmsMessage','url'=>array('create')),
	array('label'=>'Manage SmsMessage','url'=>array('admin')),
);
?>

<h1>Sms Messages</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
