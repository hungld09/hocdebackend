<?php
$this->breadcrumbs=array(
	'Reports',
);
?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'report-form',
	'enableAjaxValidation'=>false,
)); 
?>
<div class="form-actions" style="border:1;width:600px;float:right;padding: 10px 10px 10px 10px;margin-right: 10px;display: inline-block;">
<div style="border:0;width:150px;float:left;margin-left:20px;">
<br/>
<?php 
$arrDateInterval = array(0=>'Khoảng thời gian', 1=>'7 ngày gần đây', 2=>'Đầu tháng đến nay', 3=>'Tháng trước', 4=>'Đầu năm đến nay');
echo $form->radioButtonList($model, "intervalId", $arrDateInterval, array('separator' => '<br/>', 'class'=>'fire-toggle'));
?>
<br/>
<div id="select-partner" style="display:none">
	<?php  echo CHtml::activeDropDownList($model, "partnerId", CHtml::listData(Partner::model()->findAll(), "id", "display_name"))?>
</div>
</div>
<div style="float:right;margin-right: 50px;">
<?php
echo CHtml::label("Ngày bắt đầu", "", array());
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
		'name'=>'from_date',
		'model'=>$model,
		'attribute'=>'from_date',
		'value'=>$model->from_date,
		'options'=>array(
				'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
				'showOn'=>'button', // 'focus', 'button', 'both'
				'buttonText'=>Yii::t('ui','Select form calendar'),
				'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.gif',
				'buttonImageOnly'=>true,
				'dateFormat' => 'dd/mm/yy', // save to db format
// 				'altField' => '#self_pointing_id',
// 				'altFormat' => 'dd-mm-yy', // show to user format
		),
		'htmlOptions'=>array(
				'style'=>'width:120px;vertical-align:top'
		),
));

echo CHtml::label("Ngày kết thúc", "", array());
// echo date('d/m/Y',strtotime($model->to_date)); 
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
		'name'=>'to_date',
		'model'=>$model,
		'attribute'=>'to_date',
// 		'value'=>'20/10/2010',
		'value'=>$model->to_date,
		'options'=>array(
				'showAnim'=>'fold', // 'show' (the default), 'slideDown', 'fadeIn', 'fold'
				'showOn'=>'button', // 'focus', 'button', 'both'
				'buttonText'=>Yii::t('ui','Select form calendar'),
				'buttonImage'=>Yii::app()->request->baseUrl.'/images/calendar.gif',
				'buttonImageOnly'=>true,
				'dateFormat' => 'dd/mm/yy', // save to db format
		),
		'htmlOptions'=>array(
				'style'=>'width:120px;vertical-align:top'
		),
));
?>
<br/>
<?php
$this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'htmlOptions' => array('onclick'=>'refresh()'),
		'type'=>'primary',
		'label'=>'Submit',
));
?>
</div>
</div>

<div class="form-actions" style="border:1;width:320px;float:top;padding: 10px 10px 10px 10px; margin-left:20px; float: left;display: inline-block;" align="left">
<div id="menu" style="background-color:#f5f5f5;width:300px;float:top;padding: 10px 10px 10px 10px;">
<?php
	echo $form->radioButtonList($model, "reportId", $model->arrReportRadButton, array('separator' => "  ",'class'=>'fire-report'));
?>
</div>
</div>
<div id="content-report" style="background-color:#EEEEEE;text-align:center; float:bottom;display: inline-block;width:100%;">
<?php
	$this->renderPartial('_content', array('model'=>$model));
	$this->endWidget();
?>
</div>

<div id="footer" style="background-color:#FFA500;clear:both;text-align:center;">

</div>

<script>
function selectedRadReportBtn() {
//	alert('selected report');
}

$(function(){
    $('.fire-report').change(function(){
            if( $(this).is(":checked") ){ // check if the radio is checked
                var val = $(this).val(); // retrieve the value
                if(val == 40){
                    $('#select-partner').show();
                }
                else {
                    $('#select-partner').hide();
                }
            } else $('#select-partner').hide();
    });
    var reportId = '<?php echo $model->reportId?>';
    if(reportId == 40){
    	$('#select-partner').show();
    };
});

$(function(){
    $('.fire-toggle').change(function(){
    	var current_value = $('input:radio[name=Report[intervalId]]:checked').val();
    	if(current_value == 0) {
    		var d = new Date();
    		var month = d.getMonth()+1;
    		var day = d.getDate();
    		var endday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();
    		d.setDate(d.getDate()-1);
    		month = d.getMonth()+1;
    		day = d.getDate();
    		fromday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();

    		$("#from_date").val(fromday);
    		$("#to_date").val(endday);
    	}
    	else if(current_value == 1) { //7 ngay gan day
    		var d = new Date();
    		var month = d.getMonth()+1;
    		var day = d.getDate();
    		var endday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();
    		d.setDate(d.getDate()-7);
    		day = d.getDate();
    		month = d.getMonth()+1;
    		fromday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();

    		$("#from_date").val(fromday);
    		$("#to_date").val(endday);
    	}
    	else if(current_value == 2) { //dau thang den nay
    		//alert(1);
    		var d = new Date();
    		var month = d.getMonth()+1;
    		var day = d.getDate();
    		var endday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();
    		day = 1;
    		fromday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();

    		$("#from_date").val(fromday);
    		$("#to_date").val(endday);
    	}
    	else if(current_value == 3) { //thang truoc
    		//alert(1);
    		var d = new Date();
    		var month = d.getMonth()+1;
    		day = 1;
    		month = month - 1;
    		year = d.getFullYear();
    		if(month == 0) {
        		month = 12;
        		year = year - 1;
    		}
    		fromday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + year;

    		d.setDate(d.getDate()-day);
    		var day = d.getDate();
    		var endday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();
    		day = 1;

    		$("#from_date").val(fromday);
    		$("#to_date").val(endday);
    	}
    	else if(current_value == 4) { //dau nam den nay
    		//alert(1);
    		var d = new Date();
    		var month = d.getMonth()+1;
    		var day = d.getDate();
    		var endday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();
    		day = 1;
    		month = 1;
    		fromday = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();

    		$("#from_date").val(fromday);
    		$("#to_date").val(endday);
    	}
    });
});
</script>

