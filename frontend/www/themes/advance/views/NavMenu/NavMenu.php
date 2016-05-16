<div data-role="panel" class="jqm-nav-panel jqm-navmenu-panel"
     data-position="left" data-display="push" data-theme="b"
     id="sliding_menu" data-swipe-close="false" >
    <ul data-role="listview" data-theme="b" data-divider-theme="b"
        data-icon="false" data-global-nav="docs" class="jqm-list">
        <li>
<!--            <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/ic_mobiphone_small.png" style="width: auto;height: 30px; float: left; margin-left: 5px; margin-top: 5px;">-->
            <a href="<?php echo Yii::app()->baseUrl; ?>/account" >TÀI KHOẢN CỦA BẠN</a>
        </li>
        <li>
            <a href="<?php echo Yii::app()->baseUrl ?>/" data-ajax="false">Trang chủ</a>
        </li>
        <?php if ($accesType == Controller::ACCESS_VIA_WIFI) { ?>
            <li>
                <?php
                if ($moibleNumber != '') {
                    $title = 'Thoát tài khoản Wifi';
                } else {
                    $title = 'Truy cập bằng Wifi';
                }
                echo CHtml::link($title, array('/account/login'));
                ?>
            </li>
<?php } ?>


        <li data-role="list-divider">TIN TỨC</li>

        <?php
        /* @var $cat VodCategory */
        $i = 0;
        $lengthCat = count($categoriesCarNews);
        foreach ($categoriesCarNews as $cat) {
            $i++;
            ?>
            <li><?php echo CHtml::link($cat->name, array("/carNews/browse/category/" . $cat->id), array('data-ajax' => "false")); ?></li>
            <?php if ($i < $lengthCat) { ?> 
            <?php } ?>
		<?php } ?>

		<li data-role="list-divider">HÃNG XE</li>

        <?php
        /* @var $cat VodCategory */
        $i = 0;
        $lengthCat = count($carBrand);
        foreach ($carBrand as $cat) {
            $i++;
            ?>
            <li><?php echo CHtml::link($cat->name, array("/car/browse/category/" . $cat->id), array('data-ajax' => "false")); ?></li>
            <?php if ($i < $lengthCat) { ?> 
            <?php } ?>
		<?php } ?>


		<li data-role="list-divider">Video Xe</li>

        <?php
        /* @var $cat VodCategory */
        $i = 0;
        $lengthCat = count($carVodCat);
        foreach ($carVodCat as $cat) {
            $i++;
            ?>
            <li><?php echo CHtml::link($cat->display_name, array("/video/browse/category/" . $cat->id), array('data-ajax' => "false")); ?></li>
            <?php if ($i < $lengthCat) { ?> 
            <?php } ?>
		<?php } ?>
</div>
