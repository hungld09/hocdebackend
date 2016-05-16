<?php
$controller = Yii::app()->controller->id;
$action = Yii::app()->controller->action->id;

$array_use_service = array('useservice', 'charginghistory', 'usehistory', 'mtmohistory', 'bonuscode');
$role = Yii::app()->session['Role'];
?>
<?php /* var_dump($this->menu2);die; */?>
<div id="menutabs1" class='mt10'>
<?php if($role == 2){ ?>
    <a class="<?php echo strtolower($action) == strtolower('tracuuthuebao') ? 'selected' : '' ?>" href="<?php echo Yii::app()->createUrl('CskhDichVuVfilm/tracuuthuebao') ?>">
        <img class='icon1' src='<?php echo Yii::app()->request->baseUrl . '/images/icon1.png'; ?>'>
        <span>Tra cứu thuê bao</span>
    </a>
    <a class="<?php echo  in_array(strtolower($action), $array_use_service) ? 'selected' : '' ?>" href="<?php echo Yii::app()->createUrl('CskhDichVuVfilm/useService/') ?>">
        <img class='icon2' src='<?php echo Yii::app()->request->baseUrl . '/images/icon2.png'; ?>'>
        <span>Tra cứu sử dụng dịch vụ</span>
    </a>
    <a class="<?php echo strtolower($action) == strtolower('caidatdichvu') ? 'selected' : '' ?>" href="<?php echo Yii::app()->createUrl('CskhDichVuVfilm/caidatdichvu') ?>">
        <img class='icon3' src='<?php echo Yii::app()->request->baseUrl . '/images/icon3.png'; ?>'>
        <span>Cài đặt dịch vụ</span>
    </a>
    <a class="<?php echo strtolower($action) == strtolower('thongtindichvu') ? 'selected' : '' ?>" href="<?php echo Yii::app()->createUrl('CskhDichVuVfilm/thongtindichvu/') ?>">
        <img class='icon4' src='<?php echo Yii::app()->request->baseUrl . '/images/icon4.png'; ?>'>
        <span>Thông tin dịch vụ</span>
    </a>
<?php } ?>
    <?php if($role == 1){ ?>
        <a class="<?php echo strtolower($action) == strtolower('tracuuthuebao') ? 'selected' : '' ?>" href="<?php echo Yii::app()->createUrl('CskhDichVuVfilm/tracuuthuebao') ?>">
            <img class='icon1' src='<?php echo Yii::app()->request->baseUrl . '/images/icon1.png'; ?>'>
            <span>Tra cứu thuê bao</span>
        </a>
        <a class="<?php echo  in_array(strtolower($action), $array_use_service) ? 'selected' : '' ?>" href="<?php echo Yii::app()->createUrl('CskhDichVuVfilm/useService/') ?>">
            <img class='icon2' src='<?php echo Yii::app()->request->baseUrl . '/images/icon2.png'; ?>'>
            <span>Tra cứu sử dụng dịch vụ</span>
        </a>
        <a class="<?php echo strtolower($action) == strtolower('thongtindichvu') ? 'selected' : '' ?>" href="<?php echo Yii::app()->createUrl('CskhDichVuVfilm/thongtindichvu/') ?>">
            <img class='icon4' src='<?php echo Yii::app()->request->baseUrl . '/images/icon4.png'; ?>'>
            <span>Thông tin dịch vụ</span>
        </a>
    <?php } ?>
</div>
