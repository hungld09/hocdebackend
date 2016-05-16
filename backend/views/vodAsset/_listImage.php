<div id="gallery" class="ad-gallery">
  <div id='descriptions'></div>  
  <div class="ad-image-wrapper">
  </div>
    
    
  <div class="ad-controls">
  </div>
  <div class="ad-nav">
    <div class="ad-thumbs">
      <ul class="ad-thumb-list">
        
      </ul>
    </div>
  </div>
</div>
<br/>
<?php echo CHtml::image(Yii::app()->baseUrl.'/images/image_edit.png','',array('style'=>'cursor:pointer','onClick'=>'editImage();'));?>&nbsp;
<?php echo CHtml::image(Yii::app()->baseUrl.'/images/image_delete.png','',array('style'=>'cursor:pointer','onClick'=>'$("#deleteDialog").dialog("open");'));?>&nbsp;
<?php echo CHtml::image(Yii::app()->baseUrl.'/images/image_add.png','',array('style'=>'cursor:pointer','onClick'=>'addImage();'));?>&nbsp;
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'imageDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Edit Image',
        'autoOpen'=>false,
        'buttons'=> array('Submit'=>'js: function() {saveImage();}','Cancel'=>'js: function() {$("#imageDialog").dialog("close");}'),
        'modal'=>true,
        'minWidth'=>650,
        'minHeight'=>600
				      
    ),
));
?>
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'vod-image-form',
            'enableClientValidation'=>true,
    )); 
    $image = new VodImage;
    ?>
<div class="form">
    <div class="row">
        <?php echo $form->hiddenField($image,'id'); ?>
        
        <?php echo $form->labelEx($image,'url'); ?>
        <?php echo $form->textField($image,'url',array('size'=>70,'maxlength'=>500)); ?>
        <?php echo $form->error($image,'url'); ?>
    </div>  

    <div class="row">
        <?php echo $form->labelEx($image,'title'); ?>
        <?php echo $form->textField($image,'title',array('size'=>70,'maxlength'=>300)); ?>
        <?php echo $form->error($image,'title'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($image,'width'); ?>
        <?php echo $form->textField($image,'width',array('size'=>20)); ?>
        <?php echo $form->error($image,'width'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($image,'height'); ?>
        <?php echo $form->textField($image,'height',array('size'=>20)); ?>
        <?php echo $form->error($image,'height'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($image,'Orientation'); ?>
        <?php echo $form->dropDownList($image,'format',array('Port'=>'Port',
        'Land'=>'Land')); ?>
        <?php echo $form->error($image,'format'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($image,'status'); ?>
        <?php echo $form->checkBox($image,'status',array()); ?>
        <?php echo $form->error($image,'status'); ?>
    </div>
</div>
    <?php $this->endWidget('CActiveForm'); ?> 
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'deleteDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Delete Image',
        'autoOpen'=>false,
        'buttons'=> array('OK'=>'js: function() {deleteImage();}','Cancel'=>'js: function() {$( this ).dialog( "close" );}'),
        'modal'=>true
				
        
    ),
));
?>
<div id="dialog-message" title="Delete Image">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		Do you really want to remove this image from this asset?
	</p>
	
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'invalidUploadDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Invalid File',
        'autoOpen'=>false,
        'buttons'=> array('OK'=>'js: function() {$( this ).dialog( "close" );}'),
        'modal'=>true,
        
		
        
    ),'htmlOptions'=>array('class'=>'ui-state-error')
));
?>
<div id="dialog-message" title="Invalid File">
	<p>
		<span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
		Error: invalid file
	</p>
	
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
<div id="file-uploader">      
       
</div>
<script>
 function createUploader(){            
            var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader'),
                action: '<?php echo Yii::app()->createUrl('admin/vodAsset/uploadImage') ?>',
                debug: true,
                params: {
                    vod_asset_id: <?php echo $model->id?>
                  
                },
                onComplete: function(id, fileName, responseJSON){start();},
                onSubmit: function(id, fileName){
                     if (! (/(jpg|png|jpeg|gif)$/.test(fileName))){
                        // extension is not allowed
                        $( "#invalidUploadDialog" ).dialog( "open" );
                        // cancel upload
                        return false;
                     }
                }
                
            });           
        }
        
        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load  
        window.onload = createUploader;     
function editImage(){
    var className = '.ad-active:first';
    var imageId = $(className).attr('id');
    $("#VodImage_id").val(imageId);
    $("#VodImage_url").val($(className).attr('href'));  
    $("#VodImage_title").val($(className).attr('title')); 
    $("#VodImage_width").val($(className).attr('width')); 
    $("#VodImage_height").val($(className).attr('height')); 
    $("#VodImage_format").val($(className).attr('format')); ;
    if ($(className).attr('status')==1)
        $("#VodImage_status").attr('check',true); else $("#VodImage_status").attr('check',false);
    $('#imageDialog').dialog({ title: 'Edit Image' }); 
    $('#imageDialog').dialog('open');
     
} 

function addImage(){
    $("#VodImage_id").val(null);
    $("#VodImage_url").val(null);  
    $("#VodImage_title").val(null); 
    $("#VodImage_width").val(null); 
    $("#VodImage_height").val(null); 
    $("#VodImage_format").val(null);  
    $("#VodImage_status").attr('check',true);
    $('#imageDialog').dialog({ title: 'Add Image' });  
    $('#imageDialog').dialog('open');
} 

function deleteImage() {
     $.ajax({
 url:"<?php echo Yii::app()->createUrl('admin/vodAsset/deleteImage') ?>",
 data: {id:$('.ad-active:first').attr('id') 
        
    },
 type: 'POST',
 success: function(data){
        $("#deleteDialog").dialog("close");
        start();
 }
});
}

function saveImage(){
    $.ajax({
 url:"<?php echo Yii::app()->createUrl('admin/vodAsset/saveImage?vod_asset_id='.$model->id) ?>",
 data: {id:$("#VodImage_id").val(), 
        url:$("#VodImage_url").val(),
        title:$("#VodImage_title").val(),
        width:$("#VodImage_width").val(),
        height:$('#VodImage_height').val(),
        format:$('#VodImage_format').val(),
        status:($('#VodImage_status').is(":checked"))?1:0
    },
 type: 'POST',
 success: function(data){
        $("#imageDialog").dialog("close");
        start();
 }
});
}

var galleries,effect = null;
start();
var current_index = 0;
function start(){
        var url = "<?php echo Yii::app()->createUrl('admin/vodAsset/getListImages?id=').$model->id ?>";
        
        $(".ad-thumb-list").load(url,{},function (responseText, textStatus, XMLHttpRequest) {
                                //ad-gallery: 
                                /*
                                $('img.image1').data('ad-desc', 'Whoa! This description is set through elm.data("ad-desc") instead of using the longdesc attribute.<br>And it contains <strong>H</strong>ow <strong>T</strong>o <strong>M</strong>eet <strong>L</strong>adies... <em>What?</em> That aint what HTML stands for? Man...');
                                $('img.image1').data('ad-title', 'Title through $.data');
                                $('img.image4').data('ad-desc', 'This image is wider than the wrapper, so it has been scaled down');
                                $('img.image5').data('ad-desc', 'This image is higher than the wrapper, so it has been scaled down');
                                */
                                galleries = $('.ad-gallery').adGallery(
                                    {
                                        loader_image: '<?php echo Yii::app()->baseUrl.'/images/loader.gif'?>',
                                        description_wrapper: $('#descriptions'),
                                        animation_speed: 300,
                                        enable_keyboard_move: false,
                                        display_next_and_prev: false,
                                        callbacks: {
                                            init: function() {
                                              var gallery = this;  
                                              var thumbs = gallery.thumbs_wrapper.find('a');
                                              thumbs.each(function(i) {
                                                  $(this).click(
                                                    function() {
                                                        var className = '.ad-thumb' + i +':first';
                                                        var oldClassName = '.ad-thumb' + current_index +':first';
                                                        $(oldClassName).removeClass('ad-active');
                                                        $(className).addClass('ad-active');
                                                        if ($('.ad-loader').css('display')=='block') {
                                                           $('.ad-image').hide(); 
                                                           thumbs.each(function(i) {
                                                               $(this).unbind('click');
                                                               $(this).click(function(){
                                                                   return false;
                                                               })
                                                           });
                                                        }
                                                        
                                                    }
                                                  )
                                              });
                                            },
                                            afterImageVisible: function() {
                                              
                                                current_index = this.current_index;
                                            }
                                        }
                                    }
                                );
                                
                                var thumbs = $('.ad-thumb-list').find('a');
                                if ($('.ad-loader').css('display')=='block') {
                                       $('.ad-image').hide(); 
                                       $('.ad-thumb0').addClass('ad-active');
                                       thumbs.each(function(i) {
                                           $(this).unbind('click');
                                           $(this).click(function(){
                                               return false;
                                           })
                                       });
                                    }
                                    
                                if ($('.ad-image-description').length>1)
                                    $('.ad-image-description').each(function(i) { $(this).replaceWith(null);});     
                                
                                $('.ad-info').hide();
                                $('.ad-slideshow-controls').hide();
                                $('.ad-info:last').show();
                                $('.ad-slideshow-controls:last').show();
//                                (effect!=null)?galleries[0].settings.effect = effect:"";

//                                $('#switch-effect').change(
//                                  function() {
//                                        effect = $(this).val();
//                                        galleries[0].settings.effect = $(this).val();
//                                        return false;
//                                  }
//                                );
//                                $('#toggle-slideshow').click(
//                                  function() {
//                                        galleries[0].slideshow.toggle();
//                                        return false;
//                                  }
//                                );
//                                $('#last-uploaded').click(
//                                  function() {
//                                        galleries[0].lastImage();
//                                        return false;
//                                  }
//                                );
                                
                                galleries[0].addAnimation('wild',
                                      function(img_container, direction, desc) {
                                        var current_left = parseInt(img_container.css('left'), 10);
                                        var current_top = parseInt(img_container.css('top'), 10);
                                        if(direction == 'left') {
                                          var old_image_left = '-'+ this.image_wrapper_width +'px';
                                          img_container.css('left',this.image_wrapper_width +'px');
                                          var old_image_top = '-'+ this.image_wrapper_height +'px';
                                          img_container.css('top', this.image_wrapper_height +'px');
                                        } else {
                                          var old_image_left = this.image_wrapper_width +'px';
                                          img_container.css('left','-'+ this.image_wrapper_width +'px');
                                          var old_image_top = this.image_wrapper_height +'px';
                                          img_container.css('top', '-'+ this.image_wrapper_height +'px');
                                        };
                                        if(desc) {
                                          desc.css('bottom', '-'+ desc[0].offsetHeight +'px');
                                          desc.animate({bottom: 0}, this.settings.animation_speed * 2);
                                        };
                                        img_container.css('opacity', 0);
                                        return {old_image: {left: old_image_left, top: old_image_top, opacity: 0},
                                                new_image: {left: current_left, top: current_top, opacity: 1},
                                                easing: 'easeInBounce',
                                                speed: 2500};
                                      }
                                    );
            }
        );
}
        
</script>