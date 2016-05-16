<?php
/* @var $this BannerController */
/* @var $model Banner */

$this->breadcrumbs=array(
    'Banners'=>array('index'),
    'Manage',
);

$this->menu=array(
    array('label'=>'Create Banner','url'=>array('create')),
);
?>
<h1>Manage Banner</h1>
<?php
$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'banner-grid',
    'dataProvider'=>Banner::model()->getListBanner(),
    'columns'=>array(
        array(
            'name' => 'content',
            'type'=>'html',
            'value' => 'CHtml::image($data->getBanner(), "", array("style"=>"width:100px;height:60px;"))',
            'htmlOptions'=>array('width'=>'15%'),
        ),
        array(
            'name' => 'url',
            'type'=>'html',
            'value' => '$data->url',
            'htmlOptions'=>array('width'=>'25%'),
        ),
        array(
            'name' => 'time',
            'type'=>'html',
            'value' => '$data->time',
            'htmlOptions'=>array('width'=>'15%'),
        ),
        /*array(
                'name' => 'status',
                'type'=>'html',
                'value' => '$data->getStatus()',
                'htmlOptions'=>array('width'=>'20%'),
        ),*/
        array(
            'header' => 'Honor',
            'type' => 'raw',
            'value' => function ($data) {
                return '<a data-toggle="tooltip" data-placement="top" data-original-title="'.'status'.'" href="'.Yii::app()->createUrl('banner/changeStatus', array('id'=>$data->id)).'" class="glyphicon glyphicon-'.($data->status ? 'ok' : 'remove').'">'.($data->status ? "active" : "inactive").'</a>';
            },
            'headerHtmlOptions' => array(
                'width' => '5%',
            ),
        ),
        /*array(
                'name' => 'count_click',
                'type'=>'html',
                'value' => '$data->count_click',
                'htmlOptions'=>array('width'=>'20%'),
        ),*/
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{delete}',
            'buttons'=>array(
                'delete'=>
                    array(
                        'url'=>'Yii::app()->createUrl("banner/delete", array("id"=>$data->id))',
                    ),
            ),
        ),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'template' => '{update}',
            'buttons'=>array(
                'update'=>
                    array(
                        'url'=>'Yii::app()->createUrl("banner/update", array("id"=>$data->id))',
                    ),
            ),
        ),
    ),
));
?>
