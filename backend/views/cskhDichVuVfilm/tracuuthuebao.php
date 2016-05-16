<style>
    .body{font-size: 12px !important;}
    .summary{display: none;}.filters{display: none;}.table th{padding: 2px;text-align: center;}.odd > td{height: 25px;padding: 2px;background-color: #fff !important;text-align: center;}
    .even > td{height: 25px;padding: 2px;text-align: center;}.pagination{text-align: right;line-height: 27px;}
    .yiiPager > li.previous {display: none;}.yiiPager > li.next {display: none;}.yiiPager > li.selected > a {background: #1E5C9A !important;color: #fff !important;}
    .yiiPager > li > a {background: none repeat scroll 0 0 #fff !important;color: #fff;}.grid-view{padding-top: 10px!important;}
    .yiiPager > li > a {border: 1px solid #ccc !important;margin: 2px;padding: 1px 6px !important;line-height: 20px !important;border-radius: 0;-moz-border-radius: 0;-webkit-border-radius: 0;color: #525252;font-size: 12px !important;}
    .pagination > ul {float: right;}#menutabs1{line-height: 9px!important;}a:hover{text-decoration: none!important;}
    tr > th {
        text-align: center;
    }
</style>
<script>
    <?php if(Yii::app()->user->hasFlash('response')):?>
    alert('<?php echo Yii::app()->user->getFlash('response'); ?>');
    <?php endif;?>
</script>
<div class='fillterarea'>
    <table><tr>
        <td width='100'>Số thuê bao:</td>
        <form action="<?php echo Yii::app()->createUrl('cskhDichVuVfilm/tracuuthuebao'); ?>" id="subscribe" method="GET">
            <td><input type='text' id="subscriber_number" value="<?php if(isset(Yii::app()->session['msisdn'])){ echo Yii::app()->session['msisdn'];} ?>" class='textbox' name="keyword" style="height: 14px;margin-bottom: 1px;width: 155px"></td>
            <td align='right' width='200'><input type="submit" value="Tra cứu" class="btn_search"></td>
        </form>
    </tr></table>
</div>
<?php if(Yii::app()->session['checkview'] == 1){ ?>
    <table class='tbl_style'>
        <thead>
        <tr>
            <th>Dịch vụ</th>
            <th>Gói cước</th>
            <th>Trạng thái</th>
            <th>Ngày đăng ký</th>
            <th>Hiệu lực gói cước</th>
        </tr>
        </thead>
        <tr>
            <td align='center' rowspan='9'><span>VFILM</span></td>
            <td align='center'><span>NGÀY</span></td>
            <td><span><?php echo $model->getUsingServiceStr2(4); ?></span></td>
            <td align='center'><span><?php echo $model->getUsingDateService(4); ?></span></td>
            <td align='center'><span><?php echo $model->getUsingDateService2(4); ?></span></td>
        </tr>
        <tr>
            <td align='center'><span>TUẦN</span></td>
            <td><span><?php echo $model->getUsingServiceStr2(5); ?></span></td>
            <td align='center'><span><?php echo $model->getUsingDateService(5); ?></span></td>
            <td align='center'><span><?php echo $model->getUsingDateService2(5); ?></span></td>
        </tr>
        <tr>
            <td align='center'><span>VTV</span></td>
            <td><span><?php echo $model->getUsingServiceStr2(6); ?></span></td>
            <td align='center'><span><?php echo $model->getUsingDateService(6); ?></span></td>
            <td align='center'><span><?php echo $model->getUsingDateService2(6); ?></span></td>
        </tr>
    </table>
<?php } ?>
<script>
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
</script>

