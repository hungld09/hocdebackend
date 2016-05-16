<div class="form-actions">
<?php
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'vodImage-grid',
	'dataProvider'=>VodImage::model()->getListImages($model->id),
	'columns'=>array(
		array(
				'name' => 'url',
				'type'=>'html',
				'value' => 'CHtml::image($data->getUrl(), "", array("style"=>"width:100px;height:60px;"))',
				'htmlOptions'=>array('width'=>'100'),
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{delete}',
			'buttons'=>array(
				'delete'=>
				array(
						'url'=>'Yii::app()->createUrl("vodImage/delete", array("id"=>$data->id))',
				),
			),
		),
	),
));
?>

<?php
$modelVodImage = new VodImage();
$vod_asset_id = $model->id;
$this->widget('bootstrap.widgets.TbFileUpload', array(
	'url' => $this->createUrl("vodImage/upload/vod_asset_id/$vod_asset_id"),
	'model' => $modelVodImage,
	'attribute' => 'picture', // see the attribute?
	'multiple' => true,
	'options' => array(
			'maxFileSize' => 2000000,
			'acceptFileTypes' => 'js:/(\.|\/)(gif|jpeg|jpg|png)$/i',
)));
?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit',
	'htmlOptions' => array('onclick'=>'refresh()'),
	'type'=>'primary',
	'label'=>'Submit',
)); 
?>


</div>

<script>
function refresh() {
	$.fn.yiiGridView.update("vodImage-grid");
}
</script>