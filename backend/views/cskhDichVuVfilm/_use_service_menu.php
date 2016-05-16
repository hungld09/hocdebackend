<?php
$action = Yii::app()->controller->action->id;
?>
<ul class='tabtracuusddv'>
    <li>
        <?php
        echo CHtml::link(
            'Lịch sử Đăng ký / Hủy',
            strtolower($action) == strtolower('useService') ? '#' : Yii::app()->createUrl('CskhDichVuVfilm/useService'),
            array('class' => strtolower($action) == strtolower('useService') ? 'select' : '' )
        )
        ?>
    </li>
    <li>
        <?php
        echo CHtml::link(
            'Lịch sử trừ cước',
            strtolower($action) == strtolower('chargingHistory') ? '#' : Yii::app()->createUrl('CskhDichVuVfilm/chargingHistory'),
            array('class' => strtolower($action) == strtolower('chargingHistory') ? 'select' : '' )
        )
        ?>
    </li>
    <li>
        <?php
        echo CHtml::link(
            'Lịch sử sử dụng',
            strtolower($action) == strtolower('useHistory') ? '#' : Yii::app()->createUrl('CskhDichVuVfilm/useHistory'),
            array('class' => strtolower($action) == strtolower('useHistory') ? 'select' : '' )
        )
        ?>
    </li>
    <li>
        <?php
        echo CHtml::link(
            'Lịch sử MO /MT',
            strtolower($action) == strtolower('MtMoHistory') ? '#' : Yii::app()->createUrl('CskhDichVuVfilm/MtMoHistory'),
            array('class' => strtolower($action) == strtolower('MtMoHistory') ? 'select' : '' )
        )
        ?>
    </li>
<!--    <li>-->
<!--        --><?php
//        echo CHtml::link(
//            'Tra cứu mã dự thưởng',
//            strtolower($action) == strtolower('bonusCode') ? '#' : Yii::app()->createUrl('CskhDichVuVfilm/bonusCode'),
//            array('class' => strtolower($action) == strtolower('bonusCode') ? 'select' : '' )
//        )
//        ?>
<!--    </li>-->
</ul>