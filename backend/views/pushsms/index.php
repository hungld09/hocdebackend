<div class="" style="padding: 10px">
<h4 class='mb10'>Hủy theo file .csv (Luu y chi nhan submit 1 lan)</h4>
    <!--<a href="http://backend.vfilm.vn/file_huy_mau.txt" download>download file mẫu</a><br><br>-->
    <form role="form" action="javascrip:;" method="post" enctype="multipart/form-data" >
        <label>Noi dung push sms</label>
        <textarea rows="10" cols="100" id="textSms"></textarea>
        <div class="form-group">
          <input type="file" class="form-control" name="myfile" id="myfile" multiple>
        </div>	  
       <input type="submit" class="upload" value="Upload" onclick="return doUpload();">
       <button class="btn_huy uploadfile">Push sms thuê bao</button>
      <!--<input type="button" class="btn btn-default uploadfile" value="Hủy số thuê bao" />-->
    </form>
    <hr>
    <div id="progress-group">
        <div class="progress">
          <div class="progress-bar" style="width: 60%;">
            Tên file ở đây
          </div>
          <div class="progress-text">
            Tiến trình ở đây
          </div>
        </div>
    </div>
    <div id="results">

    </div>
</div> 
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/function.js"></script>
<script>
       var path_ajax='<?php echo Yii::app()->baseUrl?>';
       var path_ajax_img='<?php echo Yii::app()->request->baseUrl; ?>';
   
     $('.uploadfile').click(function(){
       var fileToUpload = $('#myfile').val().replace(/C:\\fakepath\\/i, '');
       var textSms=$('#textSms').val();
       if(fileToUpload == null){
           alert('Ban chua chon file upload'); return false;
       }
       if(textSms == null || textSms.length == 0){
           alert('Ban chua nhap text sms'); return false;
       }
       $('.uploadfile').hide();
       $.ajax({
            type: 'POST',
            url: "<?php echo Yii::app()->baseUrl . '/pushsms/sendSms'?>",
            data: {'fileToUpload':fileToUpload, 'textSms':textSms},
            cache: false,
            success: function(html){
               $("#results").html(data).parent().fadeIn('slow');
            }
        });
    });
</script>
<style type="text/css">
        .upload{
            height: 22px;
            line-height: 18px;
            border: 1pt solid #B5B8C8;
            background:#FAFAFA;
            border-radius: 4px;
            padding-left: 10px;
            padding-right: 10px;
            cursor: pointer;
        }
        .progress {
                position: relative;
        }
        .progress-bar {
            float: left;
            width: 0;
            height: 100%;
            font-size: 12px;
            line-height: 20px;
            color: #fff;
            text-align: center;
            background-color: #428bca;
            -webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
            box-shadow: inset 0 -1px 0 rgba(0,0,0,.15);
            -webkit-transition: width .6s ease;
            transition: width .6s ease;
            }
        .progress-text {
                position: absolute;
                width: 100%;
                height: 100%;
                text-align: right;
                padding-right: 5px;
                color: #333;
        }
</style>