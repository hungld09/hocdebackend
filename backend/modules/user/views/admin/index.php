<?php
$this->breadcrumbs=array(
	UserModule::t('Users')=>array('/user'),
	UserModule::t('Manage'),
);

$this->menu=array(
//     array('label'=>UserModule::t('Phân quyền'), 'url'=>array('create')),
    array('label'=>UserModule::t('Thêm người dùng'), 'url'=>array('create')),
    array('label'=>UserModule::t('Quản lý'), 'url'=>array('admin')),
//     array('label'=>UserModule::t('Manage Profile Field'), 'url'=>array('profileField/admin')),
//     array('label'=>UserModule::t('List User'), 'url'=>array('/user')),
);

?>
<h1><?php echo UserModule::t("Quản lý người dùng"); ?></h1>

<?php 
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'user-grid',
	'type'=>'striped bordered',
	'dataProvider'=>$dataProvider,
// 	'dataProvider'=>$model->search(),
// 	'filter'=>$model,
	'columns'=>array(
// 		array(
// 			'name' => 'id',
// 			'type'=>'raw',
// 			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
// 		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/update","id"=>$data->id))',
		),
// 		array(
// 			'name'=>'email',
// 			'type'=>'raw',
// 			'value'=>'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
// 		),
		'create_at',
		'lastvisit_at',
// 		array(
// 			'name'=>'superuser',
// 			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
// 			'filter'=>User::itemAlias("AdminStatus"),
// 		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
			'filter' => User::itemAlias("UserStatus"),
		),
// 		array(
// 			'class'=>'bootstrap.widgets.TbButtonColumn',
// 		),
	),
)); ?>
