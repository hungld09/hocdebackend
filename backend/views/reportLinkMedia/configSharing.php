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

<h2>Cài đặt % ăn chia kênh truyền thông:</h2><br>
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
            <span>Tỉ lệ % sản lượng đk mới: </span>
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
            <span>Tỉ lệ % sản lượng hủy: </span>
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
            <span>Tỉ lệ % sản lượng charge cước: </span>
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
            <span>Tỉ lệ % sản lượng charge cước thành công: </span>
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
            <span>Tỉ lệ % sản lượng charge cước không thành công: </span>
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
    <div class="form-group">
        <div class="col-xs-2">
            <span>Tỉ lệ % lượt click: </span>
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
    <div class="date">
        <br>
        <p>Ngày bắt đầu: <input type="text" data-format="dd-mm-YYYY" name="start" class="datepicker start" <?php echo !empty($_GET['start']) ? 'value="' . $_GET['start'] . '"' : ''; ?>></p>
        <p>Ngày kết thúc: <input type="text" data-format="dd-mm-YYYY" name="end" class="datepicker end" <?php echo !empty($_GET['end']) ? 'value="' . $_GET['end'] . '"' : ''; ?>></p>
        <div class="showcontent">

        </div>
    </div>
    <p>Chọn kênh truyền thông để lưu cấu hình %:</p>
    <select class="partnerId" name="partnerId">
        <?php foreach($arrPartner as $item){ ?>
            <option value="<?php echo $item->id ?>"><?php echo $item->display_name ?></option>
        <?php } ?>
    </select><br>
    <div class="col-xs-12" style="float: left">
        <?php echo CHtml::button('Save', array(
            'type' => 'submit',
            'class '=> 'btn btn-primary'
        )); ?>
    </div><br>
    <div class="space"></div>
    <?php $this->endWidget(); ?>
</div>

<div>
    <table>
        <tbody>
        <tr>
            <td>Ngày</td>
            <td>Kênh TT</td>
            <td>Sl Đk mới</td>
            <td>Sl Hủy</td>
            <td>Sl charge cước</td>
            <td>Sl charge cước thành công</td>
            <td>Sl charge cước không thành công</td>
            <td>Sl click</td>
<!--            <td>Hành động</td>-->
        </tr>
        <?php foreach($data as $item){ ?>
        <tr>
            <td><?php echo date('d-m-Y', strtotime($item->start_date)); ?> - <?php echo date('d-m-Y', strtotime($item->end_date)); ?></td>
            <td>
                <?php
                $partne = Partner::model()->findByPk($item->service_id);
                echo $partne['display_name'];
                ?>
            </td>
            <td><?php echo $item->config_a; ?> %</td>
            <td><?php echo $item->config_b; ?> %</td>
            <td><?php echo $item->config_c; ?> %</td>
            <td><?php echo $item->config_d; ?> %</td>
            <td><?php echo $item->config_f; ?> %</td>
            <td><?php echo $item->config_e; ?> %</td>
<!--            <td><a href="--><?php //echo Yii::app()->request->baseUrl . '/reportLinkMedia/configSharingDel?id='.$item->id ?><!--" />Xóa</a></td>-->
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