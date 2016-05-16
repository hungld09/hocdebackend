<?php
$this->breadcrumbs=array(
	'Vod Assets'=>array('index'),
	$model->id,
);

$this->menu=array(
// 	array('label'=>'List video','url'=>array('index')),
	array('label'=>'Tạo phim mới','url'=>array('create')),
// 	array('label'=>'Update video','url'=>array('update','id'=>$model->id)),
// 	array('label'=>'Delete video','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Quản lý phim','url'=>array('admin')),
);
?>

<h1>View video #<?php echo $model->display_name; ?></h1>

<?php 
if($model->is_series == 0) {
	$this->widget('zii.widgets.jui.CJuiTabs', array(
	    'tabs'=>array(
	        'Thông tin cơ bản'=>$this->renderPartial('info', array('model'=>$model),true),
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
					'Thông tin cơ bản'=>$this->renderPartial('info', array('model'=>$model),true),
					'Danh mục'=>$this->renderPartial('_listCategory',array('model'=>$model),true),
					'Ảnh'=>$this->renderPartial('imageManage',array('model'=>$model),true),
					'Tập phim'=>$this->renderPartial('listEpisode',array('model'=>$modelEpisode, 'vod_asset_id'=>$model->id),true),
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
?>

<!-- <div class="form-actions"> -->
<?php
// phan nay hien thi category_info
// $this->renderPartial('_listStream',array('model'=>$model));
?>
</div>

<?php
// phan nay hien thi category_info
// $this->renderPartial('_listCategory',array('model'=>$model));
?>

<?php 
// echo $this->renderPartial('imageManage',array('model'=>$model)); 
?>
<!-- </div> -->