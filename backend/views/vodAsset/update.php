<?php
$this->breadcrumbs=array(
	'Vod Assets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
// 	array('label'=>'List video','url'=>array('index')),
	array('label'=>'Tạo phim mới','url'=>array('create')),
	array('label'=>'Hiển thị phim','url'=>array('view','id'=>$model->id)),
	array('label'=>'Quản lý phim','url'=>array('admin')),
);
?>

<h1>Update video <?php echo $model->display_name; ?></h1>

<?php 
if($model->is_series == 0) {
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	    'tabs'=>array(
	        'Thông tin cơ bản'=>$this->renderPartial('_form', array('model'=>$model),true),
	        'Danh mục'=>$this->renderPartial('_listCategory',array('model'=>$model),true),
	        'Ảnh'=>$this->renderPartial('imageManage',array('model'=>$model),true),
	        'Luồng video'=>$this->renderPartial('_listStream',array('model'=>$model),true),
	    ),
	    'options'=>array(
	        'collapsible'=>true,
	        'selected'=>0,
	    ),
	    'htmlOptions'=>array(
	        'style'=>'width:1000px;'
	    ),
	));
}
else {
	$criteriaEpisode = new CDbCriteria;
	$criteriaEpisode = array(
			'condition'=>'vod_asset_id='.$model->id,
			'order'=>'id desc',
	);
	$modelEpisode = new CActiveDataProvider(VodEpisode::model(), array(
			'criteria'=>$criteriaEpisode,
	));
		
	$this->widget('zii.widgets.jui.CJuiTabs', array(
			'tabs'=>array(
					'Thông tin cơ bản'=>$this->renderPartial('_form', array('model'=>$model),true),
					'Danh mục'=>$this->renderPartial('_listCategory',array('model'=>$model),true),
					'Ảnh'=>$this->renderPartial('imageManage',array('model'=>$model),true),
					'Tập phim'=>$this->renderPartial('listEpisode',array('model'=>$modelEpisode, 'vod_asset_id'=>$model->id),true),
			),
			'options'=>array(
					'collapsible'=>true,
					'selected'=>0,
			),
			'htmlOptions'=>array(
					'style'=>'width:1000px;'
			),
	));
}
?>