<?php
$date = new DateTime(date('Y-m-d'));
$date->modify('-7 days');
$start_date = $date->format('Y-m-d');
$end_date = date('Y-m-d');

$service_id = isset(Yii::app()->session['service_id']) ? Yii::app()->session['service_id'] : '';
$start_date = isset(Yii::app()->session['start_date']) ? Yii::app()->session['start_date'] : $start_date;
$end_date = isset(Yii::app()->session['end_date']) ? Yii::app()->session['end_date'] : $end_date;
$subscriber_number = isset(Yii::app()->session['msisdn']) ? Yii::app()->session['msisdn'] : '';

?>
<div class='fillterarea'>
    <form method="post">
        <table>
            <tr>
                <td width='100'>Số thuê bao:</td>
                <td colspan=5>
                    <input style='width:147px' type='text' class='textbox' name="subscriber_number" id="subscriber_number" value="<?php echo $subscriber_number ?>">
                    <?php echo $error; ?>
                </td>
                <td rowspan='2' align='right' width='200'>
                    <input type="submit" value="Tra cứu" class="btn_search" name="search" id="btn_search">
                </td>
            </tr>
            <tr>
                <td>Gói cước:</td>
                <td><select style='width:150px' class="dropdownlist" name="service_id">
                        <option value="">-- Chọn gói cước --</option>
                        <option value="4" <?php echo $service_id == 4 ? 'selected="selected"' : '' ?>>NGÀY</option>
                        <option value="5" <?php echo $service_id == 5 ? 'selected="selected"' : '' ?>>TUẦN</option>
                        <option value="6" <?php echo $service_id == 6 ? 'selected="selected"' : '' ?>>VTV</option>
                    </select></td>
                <td>Thời gian bắt đầu:</td>
                <td><input type="text" class="datetime" name="start_date" readonly value="<?php echo $start_date ?>"></td>
                <td>Thời gian kết thúc</td>
                <td><input type="text" class="datetime" name="end_date" readonly value="<?php echo $end_date ?>"></td>
            </tr>
        </table>
    </form>
</div>

<script>
    $(function(){
        $("link[href*='bootstrap.css']").remove();
        $("link[href*='bootstrap-responsive.css']").remove();
        $("link[href*='bootstrap-yii.css']").remove();
        $("link[href*='jquery-ui-bootstrap.css']").remove();
        $("script[src*='bootstrap.js']").remove();
        $("script[src*='bootstrap.bootbox.min.js']").remove();
        $("script[src*='jquery.js']").remove();

        $( ".datetime" ).datepicker({ dateFormat: 'yy-mm-dd' });

        $('#btn_search').click(function(){
            var subscriber_number = $('input[name=subscriber_number'),
                service_id = $('select[name=service_id]'),
                start_date = $('input[name=start_date]'),
                end_date = $('input[name=end_date]');

            if (subscriber_number.val().length == 0){
                alert('Ban chua nhap so dien thoai');
                subscriber_number.focus();
                return false;
            }
//            if (service_id.val().length == 0){
//                alert('Ban chua chon gi cuoc');
//                service_id.focus();
//                return false;
//            }
            if (start_date.val().length == 0){
                alert('Ban chua chon ngay bat dau');
                start_date.focus();
                return false;
            }
            if (end_date.val().length == 0){
                alert('Ban chua chon ngay ket thuc');
                end_date.focus();
                return false;

            }

        });
        $('#subscriber_number').change(function(){
           var number = $(this).val();
            if (number.substr(0,2) != '84'){
                if (number.substr(0, 1) == '0'){
                    $(this).val('84' + number.substr(1, number.length - 1));
                }
            }
        });
    });
</script>