<style>
    .body{font-size: 12px !important;}
    .summary{display: none;}.filters{display: none;}.table th{padding: 2px;text-align: center;}.odd > td{height: 25px;padding: 2px;background-color: #fff !important;text-align: center;}
    .even > td{height: 25px;padding: 2px;text-align: center;}.pagination{text-align: right;line-height: 27px;}
    .yiiPager > li.previous {display: none;}.yiiPager > li.next {display: none;}.yiiPager > li.selected > a {background: #1E5C9A !important;color: #fff !important;}
    .yiiPager > li > a {background: none repeat scroll 0 0 #fff !important;color: #fff;}.grid-view{padding-top: 10px!important;}
    .yiiPager > li > a {border: 1px solid #ccc !important;margin: 2px;padding: 1px 6px !important;line-height: 20px !important;border-radius: 0;-moz-border-radius: 0;-webkit-border-radius: 0;color: #525252;font-size: 12px !important;}
    .pagination > ul {float: right;}#menutabs1{line-height: 9px!important;}a:hover{text-decoration: none!important;}
</style>
<div class='tabtracuusddv'>
    <li><a href='GUI - Cài đặt dịch vụ.html'  class='select'>Đăng ký / Hủy</a></li>
    <!--<li><a href='GUI - Cài đặt dịch vụ - Bù nội dung.html'>Bù nội dung</a></li>
    <li><a href='GUI - Cài đặt dịch vụ - Bù mã dự thưởng.html'>Bù mã dự thưởng</a></li>
    <li><a href='GUI - Cài đặt dịch vụ - Cài đặt dịch vụ.html'>Cài đặt dịch vụ</a></li>
    <li><a href='GUI - Cài đặt dịch vụ - Cài đặt tin quảng cáo.html'>Cài đặt tin quảng cáo</a></li>-->
</div>
<div class='fillterarea'>
    <table><tr>
            <td width='100'>Số thuê bao:</td>
            <form action="<?php echo Yii::app()->createUrl('cskhDichVuVfilm/caidatdichvu'); ?>" id="subscribe" method="GET">
                <td><input type='text' id="subscriber_number" value="<?php if(isset(Yii::app()->session['checkviewcd'])){ echo Yii::app()->session['checkviewcd'];} ?>" class='textbox' name="keyword" style="height: 14px;margin-bottom: 1px;width: 155px"></td>
                <td align='right' width='200'><input type="submit" value="Tra cứu" class="btn_search"></td>
            </form>
    </tr></table>
</div>
<script>
    <?php if(Yii::app()->user->hasFlash('response')):?>
    alert('<?php echo Yii::app()->user->getFlash('response'); ?>');
    <?php endif;?>
</script>
<?php if(isset(Yii::app()->session['anlayout2'])){ ?>
<?php
$arrClientAppType = array('1'=>'WAP', 2=>'Android', 3=>'iOS', 4=>'Windows Phone');
$this->widget('bootstrap.widgets.TbGridView',array(
    'id'=>'subscriber-grid',
    'type'=>'striped bordered',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'pager'=>array(
        'header' => 'Trang: &nbsp;',
    ),
    'columns'=>array(
        array(
            'header' => 'Dịch vụ',
            'value'=>  function($data){
                    return 'Vfilm';
                },
            'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'20px', 'width'=>'100px', 'style' => 'max-height:50px;'),
        ),
        array(
            'header' => 'Gói cước',
            'value'=>  function($data){
                if($data->id == 4){
                    return 'Gói ngày';
                }elseif($data->id == 5){
                    return 'Gói tuần';
                }elseif($data->id == 6){
                    return 'Gói vtv';
                }
            },
            'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'20px', 'width'=>'100px', 'style' => 'max-height:50px;'),
        ),
        /*array(
            'header' => 'Số thuê bao',
            'type'=>'html',
            'value'=>'$data->subscriber_number',
            'htmlOptions'=>array('class'=>'html', 'rows'=>1,'height'=>'20px', 'width'=>'100px', 'style' => 'max-height:50px;'),
        ),*/
        array(
            'header' => 'Thao tác',
            'type' => 'raw',
            'value' => function ($data) {
                if(isset(Yii::app()->session['msisdn'])){
                    $subscriber = Subscriber::model()->findByAttributes(array('subscriber_number' => Yii::app()->session['msisdn']));
                    if($subscriber != null){
                        if (!$subscriber->isUsingService2($data->id)) {
                            return '<a data-toggle="tooltip" data-placement="top" data-title="Đăng ký" href="' . Yii::app()->createUrl('cskhDichVuVfilm/sendRegister', array('service_id' => $data->id, 'subscriber_id' => $subscriber->id)) . '" onclick="return confirm(\'' . Yii::t('common', 'Are you sure?') . '\');" class="btnintbl"><span class="icondk">Đăng ký</span></a>';
                        }
                        if ($subscriber->isUsingService2($data->id)) {
                            return '<a data-toggle="tooltip" data-placement="top" data-original-title="Hủy" href="' . Yii::app()->createUrl('cskhDichVuVfilm/sendCancelSerivce', array('service_id' => $data->id, 'subscriber_id' => $subscriber->id)) . '" onclick="return confirm(\'' . Yii::t('common', 'Are you sure?') . '\');" class="btnintbl"><span class="iconhuy">Hủy</span></a>';
                        }
                    }else{
                        return null;
                    }
                }else{
                    return null;
                }
            },
            'htmlOptions' => array('class' => 'html', 'rows' => 1, 'height' => '20px', 'width' => '20px', 'style' => 'max-height:50px;'),
        ),
    ),
));
?>
<?php } ?>
    <h4 class='mb10'>Hủy theo file</h4>
    <a href="http://backend.vfilm.vn/file_huy_mau.txt" download>download file mẫu</a><br><br>
    <form role="form" action="javascrip:;" method="post" enctype="multipart/form-data" >
        <div class="form-group">
          <input type="file" class="form-control" name="myfile" id="myfile" multiple>
        </div>	  
       <input type="submit" class="upload" value="Upload" onclick="return doUpload();">
       <button class="btn_huy uploadfile">Hủy số thuê bao</button>
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
    <div id="results"></div>

<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/function.js"></script>
<script>
       var path_ajax='<?php echo Yii::app()->baseUrl?>';
       var path_ajax_img='<?php echo Yii::app()->request->baseUrl; ?>';
    $(function(){
        $('#subscriber_number').change(function(){
            var number = $(this).val();
            if (number.substr(0,2) != '84'){
                if (number.substr(0, 1) == '0'){
                    $(this).val('84' + number.substr(1, number.length - 1));
                }
            }
        });
        
    })
     $('.uploadfile').click(function(){
       var fileToUpload = $('#myfile').val().replace(/C:\\fakepath\\/i, '');
       $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->baseUrl?>/cskhDichVuVfilm/cancelnumber',
            data: {'fileToUpload':fileToUpload},
            dataType:'html',
            success: function(html){
               $("#results").html(html);
                return false;
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