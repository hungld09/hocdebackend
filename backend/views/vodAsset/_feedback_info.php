<table id='feedbackInfo'>
    <tr><td><?php echo CHtml::image(Yii::app()->baseUrl . '/images/spacer.gif', '', array('class' => 'loaderImage', 'id' => 'loaderFeedbackInfo', 'style' => 'display:none')); ?><br/>
            <div style="text-align: center">
                <img src="<?php echo Yii::app()->baseUrl . '/images/eye-icon.png' ?>" width="30px"/>
                <label style='vertical-align:super'>&nbsp;<b>
                        <?php
                        echo CHtml::label($model->view_count, '', array('id' => 'viewCountDisplay'));
                        echo CHtml::textField('viewCountEdit', $model->view_count, array('id' => 'viewCountEdit', 'style' => 'display:none'))
                        ?> views</b></label>
            </div><br/>
            <div style="width:10%;Text-align:center;float:left;">
                <img src="<?php echo Yii::app()->baseUrl . '/images/like-icon.png' ?>"/><br/>
                <b>
                    <?php
                    echo CHtml::label($model->like_count, '', array('id' => 'likeCountDisplay'));
                    echo CHtml::textField('likeCountEdit', $model->like_count, array('id' => 'likeCountEdit', 'style' => 'display:none', 'onChange' => 'js:changeLikeDislike();'))
                    ?>
                </b>
            </div>
                            
            <?php
            if ($model->like_count != 0 || $model->dislike_count != 0) {

                $this->widget('zii.widgets.jui.CJuiProgressBar', array('id' => 'like_dislike',
                    'value' => $model->like_count / ($model->like_count + $model->dislike_count) * 100,
                    'options' => array(
                        'create' => 'js:function(event,ui){init();}',
                    ),
                    'htmlOptions' => array('style' => 'height:20px; width:77%;float:left;text-align:center;'),
                ));
            } else
                echo "There isn't anyone liked and disliked.";
            ?>
                            
            <div style="width:10%;float:right;">
                <img src="<?php echo Yii::app()->baseUrl . '/images/dislike-icon.png' ?>"/><br/>
                <b><?php
            echo CHtml::label($model->dislike_count, '', array('id' => 'dislikeCountDisplay'));
            echo CHtml::textField('dislikeCountEdit', $model->dislike_count, array('id' => 'dislikeCountEdit', 'style' => 'display:none', 'onChange' => 'js:changeLikeDislike();'))
            ?></b>
            </div>
        </td>
    </tr>
    <tr>
        <td><b style="margin-left:185px">
                <?php
                echo CHtml::label($model->rating_count, '', array('id' => 'ratingCountDisplay'));
                echo CHtml::textField('ratingCountEdit', $model->rating_count, array('id' => 'ratingCountEdit', 'style' => 'display:none'))
                ?> Total Votes</b><br/><br/>
            <span class="stars"><?php echo $model->rating ?></span>
            <label>&nbsp;<b>
                    <?php
                    echo CHtml::label(number_format($model->rating, 2), '', array('id' => 'ratingDisplay'));
                    echo CHtml::textField('ratingEdit', $model->rating, array('id' => 'ratingEdit', 'maxLength' => 4, 'style' => 'display:none;width:25px', 'onChange' => 'js:changeRating();'));
                    ?>
                </b>/5</label><br/><br/>                        
        </td>
    </tr>
    <tr>
        <td style="text-align: center">
            <img src="<?php echo Yii::app()->baseUrl . '/images/favorite-icon.png' ?>" width="30px"/>
            <label style='vertical-align:super'>&nbsp;<b>
                    <?php
                    echo CHtml::label($model->favorite_count, '', array('id' => 'favoriteCountDisplay'));
                    echo CHtml::textField('favoriteCountEdit', $model->favorite_count, array('id' => 'favoriteCountEdit', 'style' => 'display:none'))
                    ?> Favorite Count</b></label>
        </td>
    </tr>
</table> 
<script>
    
function init(){

    $("#like_dislike").css({ 'background': 'Red' });
    $("#like_dislike > div").css({ 'background': 'Green' });
    }
function displayEdit(){    
$("#like_dislike").slider({min:0,value: <?php echo $model->like_count/($model->like_count + $model->dislike_count)*100?>,max:100,
                        slide: function(event, ui) {  
                           var totalLikeDislike = parseInt($("#likeCountEdit").val()) + parseInt($("#dislikeCountEdit").val()); 
                           var value = $( "#like_dislike" ).slider( "option", "value" );
                           $( "#like_dislike" ).progressbar( "option", "value", value );
                           $("#likeCountEdit").val(Math.ceil(value*totalLikeDislike/100));
                           $("#dislikeCountEdit").val(totalLikeDislike - Math.ceil(value*totalLikeDislike/100));
                          
                        },
                        change: function(event, ui) {  
                           var totalLikeDislike = parseInt($("#likeCountEdit").val()) + parseInt($("#dislikeCountEdit").val()); 
                           var value = $( "#like_dislike" ).slider( "option", "value" );
                           $( "#like_dislike" ).progressbar( "option", "value", value );
                           $("#likeCountEdit").val(Math.ceil(value*totalLikeDislike/100));
                           $("#dislikeCountEdit").val(totalLikeDislike - Math.ceil(value*totalLikeDislike/100));
                          
                        }
}); 
$("#like_dislike").progressbar( "option", "value",  $( "#like_dislike" ).slider( "option", "value" ) );
$("#feedbackInfoEdit").hide();
$("#feedbackInfoSubmit").show();
$("#feedbackInfoCancel").show();
$("#viewCountDisplay").hide();
$("#viewCountEdit").show();
$("#likeCountDisplay").hide();
$("#likeCountEdit").show();
$("#dislikeCountDisplay").hide();
$("#dislikeCountEdit").show();
$("#ratingCountDisplay").hide();
$("#ratingCountEdit").show();
$("#favoriteCountDisplay").hide();
$("#favoriteCountEdit").show();
$("#ratingEdit").show();
$("#ratingDisplay").hide();
}
function cancelDisplay(){    
$("#like_dislike").slider('destroy'); 
$("#feedbackInfoEdit").show();
$("#feedbackInfoSubmit").hide();
$("#feedbackInfoCancel").hide();
$("#viewCountDisplay").show();
$("#viewCountEdit").val(<?php echo $model->view_count?>);
$("#viewCountEdit").hide();
$("#likeCountDisplay").show();
$("#likeCountEdit").val(<?php echo $model->like_count?>);
$("#likeCountEdit").hide();
$("#dislikeCountDisplay").show();
$("#dislikeCountEdit").val(<?php echo $model->dislike_count?>);
$("#dislikeCountEdit").hide();
$("#ratingCountDisplay").show();
$("#ratingCountEdit").val(<?php echo $model->rating_count?>);
$("#ratingCountEdit").hide();
$("#favoriteCountDisplay").show();
$("#favoriteCountEdit").val(<?php echo $model->favorite_count?>);
$("#favoriteCountEdit").hide();
$("#ratingEdit").hide();
$("#ratingDisplay").show();
var rating = '<?php echo number_format($model->rating, 2);?>'
$("#ratingEdit").val(rating);
$('span.stars').html(rating);
$('span.stars').stars(); 
}
function changeLikeDislike() {
    var likeCount  = parseInt($("#likeCountEdit").val());
    var dislikeCount = parseInt($("#dislikeCountEdit").val());
    var value = parseFloat(likeCount/(likeCount + dislikeCount)*100);
    
    $("#like_dislike").progressbar( "option", "value", value );
    $("#like_dislike").slider( "option", "value", value );
}
function changeRating() {
    var rating = $("#ratingEdit").val();
    if (checkFloat(rating)!=null || (rating<0)||(rating>5)){
        rating = '<?php echo number_format($model->rating, 2);?>'
        $("#ratingEdit").val(rating);
        }
    $('span.stars').html(rating);
    $('span.stars').stars();    
}
$.fn.stars = function() {
                            return $(this).each(function() {
                                    $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
                            });
                    }
$('span.stars').stars();

function sendFeedbackInfo() {
   
$.ajax({
 url:"<?php echo Yii::app()->createUrl('admin/vodAsset/updateFeedbackInfo') ?>",
 data: {viewCount:$("#viewCountEdit").val(), 
        likeCount:$('#likeCountEdit').val(),
        dislikeCount:$('#dislikeCountEdit').val(),
        ratingCount:$('#ratingCountEdit').val(),
        rating:$('#ratingEdit').val(),
        favoriteCount:$('#favoriteCountEdit').val(),
        id: "<?php echo $model->id?>" },
 type: 'POST',
  success: function(data){
      $("#feedbackInfo").replaceWith(data);
      var likeCount  = parseInt($("#likeCountEdit").val());
      var dislikeCount = parseInt($("#dislikeCountEdit").val());
      var value = parseFloat(likeCount/(likeCount + dislikeCount)*100);
      $("#like_dislike").progressbar({create: function() {init();},"value":value});
  }
});
    }

</script>