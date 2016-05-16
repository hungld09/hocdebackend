<?php
$this->breadcrumbs=array(
	$model->display_name=>array('view','id'=>$model->id),'Manage Feedback'
);
?>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/comment.css" />
<table>
    <tr>
        <td style='width:35%'>
            <?php $this->renderPartial('_feedback_info',array('model'=>$model))?> 
            <?php
            echo CHtml::image(Yii::app()->baseUrl . '/images/edit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; cursor:pointer', 
                                            
                                               'onclick' =>'displayEdit();
                                                           
                                                            
                                                           ',
                                               'id'=>'feedbackInfoEdit'            
                                                            
          ));
          echo CHtml::image(Yii::app()->baseUrl . '/images/submit-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;cursor:pointer', 
//                                           
                                               'onclick' =>'
                                                            $("#loaderFeedbackInfo").show();
                                                            sendFeedbackInfo();
                                                            cancelDisplay();   
                                                            
                                                           ',
                                               'id'=>'feedbackInfoSubmit'             
                                                            
            ));
           echo CHtml::image(Yii::app()->baseUrl . '/images/cancel-icon.png', '', 
                            array('style' => 'vertical-align: bottom; float:right; display:none;margin-right:10px;cursor:pointer', 
//                                             
                                               'onclick' =>'
                                                            cancelDisplay();
                                                          
                                                           ',
                                               'id'=>'feedbackInfoCancel'             
                                                            
            ));
           ?>
        </td>
        <td>                      
                <?php
                $this->widget('zii.widgets.CListView', array(
                    'dataProvider' => $this->actionGetListComment(),
                    'itemView' => '_listComment',
                    'summaryCssClass' => 'summaryClass',
                    'summaryText' => 'There are total {count} comments for this asset.',
                    'template' => '{summary} {items}  {pager}',
                    'itemsCssClass' => 'commentList'
                ));
                ?>
        </td>
    </tr>
</table>
<script>
function showEditComment(id) {
    $("#editCommentBtn_"+id).hide();
    $("#cancelCommentBtn_"+id).show();
    $("#submitCommentBtn_"+id).show();
    $("#commentDisplay_"+id).hide();
    $("#commentEdit_"+id).show();
    $("#cancelCommentBtn_"+id).css('margin-top','38px');
    $("#submitCommentBtn_"+id).css('margin-top','38px');
}

function cancelEditComment(id) {
    $("#editCommentBtn_"+id).show();
    $("#cancelCommentBtn_"+id).hide();
    $("#submitCommentBtn_"+id).hide();
    $("#commentDisplay_"+id).show();
    $("#commentEdit_"+id).hide();
    
}

function sendEditComment(id) {
    cancelEditComment(id);
    $("#loaderComment_"+id).show();
    $.ajax({
 url:"<?php echo Yii::app()->createUrl('admin/vodAsset/updateCommentInfo') ?>",
 data: {
        id: id,
        comment:$("#commentEdit_"+id).val()
       },
 type: 'POST',
  success: function(data){
      $("#commentDisplay_"+id).html(data);
      $("#loaderComment_"+id).hide();
  }
});
    
}

function changeCommentStatus(id) {
$("#statusComment_"+id).removeClass();
$("#statusComment_"+id).addClass('loaderImage');
$.ajax({
 url:"<?php echo Yii::app()->createUrl('admin/vodAsset/changeCommentStatus') ?>",
 data: {
        id: id
       },
 type: 'POST',
 success: function(data){
      $("#statusComment_"+id).removeClass();
      if (data) {        
            $("#statusComment_"+id).addClass('activeImage');
      } else $("#statusComment_"+id).addClass('illegalImage');
 }
});
}
</script>
