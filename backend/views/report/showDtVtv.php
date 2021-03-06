<style>
    table td{
        border: 1px solid;
        text-align: center;
    }
</style>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/jquery-ui.js'; ?>"></script>
<div class="date">
    <b>Chọn ngày tháng:</b>
    <br>
    <p>Ngày bắt đầu: <input type="text" data-format="dd-mm-YYYY" name="start" class="datepicker start" <?php echo !empty($_GET['start']) ? 'value="' . $_GET['start'] . '"' : ''; ?>></p>
    <p>Ngày kết thúc: <input type="text" data-format="dd-mm-YYYY" name="end" class="datepicker end" <?php echo !empty($_GET['end']) ? 'value="' . $_GET['end'] . '"' : ''; ?>></p>
    <button type="submit" class="btn btn-default submit">Xem trước</button>
    <br>
    <br>
    <div class="showcontent">

    </div>
</div>


<script>
    <?php if(Yii::app()->user->hasFlash('response')):?>
    alert('<?php echo Yii::app()->user->getFlash('response'); ?>');
    <?php endif;?>
    jQuery(document).on('click', '.submit', function () {
        var start = $('.start').val(),
            end = $('.end').val();
        if(start != '' && end != ''){
            $.ajax({
                type: 'POST',
                url: '<?php echo Yii::app()->createUrl('report/showcontent')?>',
                data: 'start=' + start + '&end=' + end,
                cache: false,
                success: function (data) {
                    $('.showcontent').html(data).parent().fadeIn('slow');
                }
            });
        }else{
            alert('Bạn chưa chọn ngày tháng!');
        }
        return false;
    });
    $(function() {
        $( ".datepicker" ).datepicker({
            'dateFormat': 'dd/mm/yy'
        });
    });
</script>