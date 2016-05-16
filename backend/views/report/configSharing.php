<?php
/**
 * Created by Lorge
 *
 * User: Only Love.
 * Date: 12/20/13 - 4:18 PM
 *
 * @var CActiveForm $form
 * @var PropertyForm $model
 */
$currentAction = Yii::app()->controller->action->id;
?>
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/jquery-ui.js'; ?>"></script>

<h2>Cài đặt % ăn chia:</h2><br>
<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id'=>'configSharing-form',
        'method' => 'POST',
        'enableClientValidation'=>true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
        ),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data',
            'role' => 'form',
        ),
    )); ?>
    <?php if (Yii::app()->user->hasFlash('_error_')): ?>
        <div class="form-group">
            <div class="alert alert-danger">
                <button data-dismiss="alert" class="close"></button>
                <?php echo Yii::app()->user->getFlash('_error_'); ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="form-group">
        <div class="col-xs-2">
            <span>Tỉ lệ % sản lượng đk (free) gói vtv: </span>
        </div>
        <div class="col-xs-10">
            <?php echo $form->textField($model,'config_a', array(
                'type'=>'text',
                'size'=>40,
                'class'=>'form-control',
            )); ?> %
            <?php echo $form->error($model,'config_a'); ?><br/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-2">
            <span>Tỉ lệ % sản lượng đk (mất phí) gói vtv: </span>
        </div>
        <div class="col-xs-10">
            <?php echo $form->textField($model,'config_b', array(
                'type'=>'text',
                'size'=>40,
                'class'=>'form-control',
            )); ?> %
            <?php echo $form->error($model,'config_b'); ?><br/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-2">
            <span>Tỉ lệ % sản lượng thuê bao chủ động hủy: </span>
        </div>
        <div class="col-xs-10">
            <?php echo $form->textField($model,'config_c', array(
                'type'=>'text',
                'size'=>40,
                'class'=>'form-control',
            )); ?> %
            <?php echo $form->error($model,'config_c'); ?><br/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-2">
            <span>Tỉ lệ % sản lượng thuê bao hệ thống hủy: </span>
        </div>
        <div class="col-xs-10">
            <?php echo $form->textField($model,'config_d', array(
                'type'=>'text',
                'size'=>40,
                'class'=>'form-control',
            )); ?> %
            <?php echo $form->error($model,'config_d'); ?><br/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-2">
            <span>Tỉ lệ % sản lượng Gia hạn thành công gói VTV (áp dụng chung cho cả Gia hạn + truy thu): </span>
        </div>
        <div class="col-xs-10">
            <?php echo $form->textField($model,'config_e', array(
                'type'=>'text',
                'size'=>40,
                'class'=>'form-control',
            )); ?> %
            <?php echo $form->error($model,'config_e'); ?><br/>
        </div>
    </div>
    <div class="form-group">
        <div class="col-xs-2">
            <span>Tỉ lệ % sản lượng xem lẻ Phim VTV: </span>
        </div>
        <div class="col-xs-10">
            <?php echo $form->textField($model,'config_f', array(
                'type'=>'text',
                'size'=>40,
                'class'=>'form-control',
            )); ?> %
            <?php echo $form->error($model,'config_f'); ?><br/>
        </div>
    </div>
    <div class="date">
        <br>
        <p>Ngày bắt đầu: <input type="text" data-format="dd-mm-YYYY" name="start" class="datepicker start" <?php echo !empty($_GET['start']) ? 'value="' . $_GET['start'] . '"' : ''; ?>></p>
        <p>Ngày kết thúc: <input type="text" data-format="dd-mm-YYYY" name="end" class="datepicker end" <?php echo !empty($_GET['end']) ? 'value="' . $_GET['end'] . '"' : ''; ?>></p>
        <br>
        <br>
        <div class="showcontent">

        </div>
    </div>
    <div class="col-xs-12" style="float: left">
        <?php echo CHtml::button('Save', array(
            'type' => 'submit',
            'class '=> 'btn btn-primary'
        )); ?>
    </div>
    <div class="space"></div>
    <?php $this->endWidget(); ?>
</div>

<div>
    <table>
        <tbody>
        <tr>
            <td>Ngày</td>
            <td>Đk free</td>
            <td>Đk mất phí</td>
            <td>Chủ động hủy</td>
            <td>Hệ thống hủy</td>
            <td>Sl gia hạn</td>
            <td>Xem lẻ</td>
            <td>Hành động</td>
        </tr>
        <?php foreach($data as $item){ ?>
        <tr>
            <td><?php echo date('d-m-Y', strtotime($item->start_date)); ?> - <?php echo date('d-m-Y', strtotime($item->end_date)); ?></td>
            <td><?php echo $item->config_a; ?> %</td>
            <td><?php echo $item->config_b; ?> %</td>
            <td><?php echo $item->config_c; ?> %</td>
            <td><?php echo $item->config_d; ?> %</td>
            <td><?php echo $item->config_e; ?> %</td>
            <td><?php echo $item->config_f; ?> %</td>
            <td><a href="<?php echo Yii::app()->request->baseUrl . '/report/configSharingDel?id='.$item->id ?>" />Xóa</a></td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(function() {
        $( ".datepicker" ).datepicker({
            'dateFormat': 'dd/mm/yy'
        });
    });
</script>
<style>
    td{border: 1px solid}
</style>