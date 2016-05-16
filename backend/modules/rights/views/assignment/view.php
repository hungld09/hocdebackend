<?php 
// $this->breadcrumbs = array(
// 	'Rights'=>Rights::getBaseUrl(),
// 	Rights::t('core', 'Assignments'),
// ); 
?>

<div class="form-actions" id="assignments">

	<h2><?php echo Rights::t('core', 'Phân quyền'); ?></h2>

	<p>
		<?php //echo Rights::t('core', 'Here you can view which permissions has been assigned to each user.'); ?>
	</p>

	<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'type' => 'striped bordered',
	    'dataProvider'=>$dataProvider,
// 	    'template'=>"{items}\n{pager}",
	    'emptyText'=>Rights::t('core', 'No users found.'),
// 	    'htmlOptions'=>array('class'=>'grid-view assignment-table'),
	    'columns'=>array(
    		array(
    			'name'=>'name',
    			'header'=>Rights::t('core', 'Name'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'html', 'width'=>'80px',),
//     				'htmlOptions'=>array('class'=>'html', 'rows'=>6,'height'=>'30px', 'width'=>'80px', 'style' => 'max-height:50px;'),
    			'value'=>'$data->getAssignmentNameLink()',
    		),
    		array(
    			'name'=>'assignments',
    			'header'=>Rights::t('core', 'Roles'),
    			'type'=>'raw',
    			'htmlOptions'=>array('class'=>'html', 'width'=>'80px',),
    			'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_ROLE)',
    		),
// 			array(
//     			'name'=>'assignments',
//     			'header'=>Rights::t('core', 'Tasks'),
//     			'type'=>'raw',
//     			'htmlOptions'=>array('class'=>'task-column'),
//     			'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_TASK)',
//     		),
// 			array(
//     			'name'=>'assignments',
//     			'header'=>Rights::t('core', 'Operations'),
//     			'type'=>'raw',
//     			'htmlOptions'=>array('class'=>'operation-column'),
//     			'value'=>'$data->getAssignmentsText(CAuthItem::TYPE_OPERATION)',
//     		),
	    )
	)); ?>

</div>