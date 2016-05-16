<?php
/* @var $this BannerController */
/* @var $model Banner */

$this->breadcrumbs=array(
	'Banners'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

?>
<?php
	if($model->type == 2){
		echo $this->renderPartial('_formPopup', array('model'=>$model)); 
	} else {
		echo $this->renderPartial('_formBanner', array('model'=>$model)); 
	}
?>