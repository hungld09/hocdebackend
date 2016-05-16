<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>GUI - VFILM</title>
    <link media="screen" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . '/css/reset.css'; ?>" />
    <link media="screen" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . '/css/style.css'; ?>" />
    <link media="screen" rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl . '/css/jquery-ui.css'; ?>" />
    <script language='text/javascript' src="<?php echo Yii::app()->request->baseUrl . '/js/jquery-1.7.1.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/jtabber.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl . '/js/jquery-ui.js'; ?>"></script>
</head>
<body onload="mymenupopup()">
<div class="contain_popup">
    <div class="p8">
        <div class='title_containpopup'>
            <h1>GUI - VFILM
                <div style="float: right; padding-right: 20px">

                <?php if (isset(Yii::app()->session['Username'])): ?>
                    Xin chào <?php echo Yii::app()->session['Username'] ?> |
                    <?php echo CHtml::link('Logout', $this->createUrl('CskhDichVuVfilm/logout'), array('style' => 'color: white')) ?>
                <?php else: ?>
                    <?php echo CHtml::link('Login', $this->createUrl('CskhDichVuVfilm/login'), array('style' => 'color: white')) ?>
                <?php endif; ?>
                </div>
            </h1>
        </div>
        <div class='containdatapopup'>
            <div class='supportarea'>
                <li class='labelsp'>Đầu mối giải quyết khiếu nại dịch vụ: </li>
                <li class='username'>Hoàng Thu Hà</li>
                <li class='email'>haht@namviet-corp.vn</li>
                <li class='mobile'>0984.051.535</li>
            </div>

            <?php $this->renderPartial('//layouts/_menu') ?>
            <?php echo $content; ?>
        </div>
    </div>
</div>
</body>
</html>
