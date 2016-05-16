<div class='commentItem'>
    <p>
        <cite class='cite'><?php echo $data->subscriber->user_name ?></cite>
        
        <?php 
        if ($data->status)
            echo CHtml::image(Yii::app()->baseUrl . '/images/spacer.gif', '', array('class' => 'activeImage', 'id' => 'statusComment_'.$data->id,
                                                                                    'onClick'=>'js:changeCommentStatus('.$data->id.');')); 
        else echo CHtml::image(Yii::app()->baseUrl . '/images/spacer.gif', '', array('class' => 'illegalImage', 'id' => 'statusComment_'.$data->id,
                                                                                    'onClick'=>'js:changeCommentStatus('.$data->id.');')); 
        ?>
        <?php echo CHtml::image(Yii::app()->baseUrl . '/images/spacer.gif', '', array('class' => 'loaderImage', 'id' => 'loaderComment_'.$data->id, 'style' => 'display:none')); ?>
    </p>
    <p class="time"><?php echo $data->create_date?></p>
    <pre id='commentDisplay_<?php echo $data->id ?>'><?php echo $data->comment?></pre>
    <?php echo CHtml::textArea('commentEdit',$data->comment, array('id'=>'commentEdit_'.$data->id,'style'=>'display:none'))?>
     <?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'editComment','id'=>'editCommentBtn_'.$data->id,
                                                                                        'onClick'=>'js: showEditComment('.$data->id.');'
                                                                         ));
     ?>
     <?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'editComment','id'=>'submitCommentBtn_'.$data->id,'style'=>'display:none',
                                                                                        'onClick'=>'js:sendEditComment('.$data->id.');'
                                                                         ));
     ?>
     <?php echo CHtml::image(Yii::app()->baseUrl.'/images/spacer.gif','',array('class'=>'cancelComment','id'=>'cancelCommentBtn_'.$data->id,'style'=>'display:none',
                                                                                        'onClick'=>'js: cancelEditComment('.$data->id.');'
                                                                         ));
     ?>
</div>
