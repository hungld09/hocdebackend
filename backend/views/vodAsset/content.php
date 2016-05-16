
<h1>List Content</h1>
   
<?php 
$dataProvider=new CActiveDataProvider('VodAsset');

$this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',   // refers to the partial view named '_post'
    'sortableAttributes'=>array(
        'title',
        'create_time'=>'Post Time',
    ),
));
?>