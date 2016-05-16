<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div class="slide_content">
        <div class="m-carousel m-fluid m-carousel-photos">
             <div class="m-caption-top" style="color:white">
                <a href="<?php echo $this->createUrl("/car/news"); ?>" data-ajax="false">
                        <img class="m-xemtiep" src="<?php echo Yii::app()->theme->baseUrl."/images/xem_tiep_btn.png"?>" alt="">
                </a>
        	</div>
            <!-- the slider -->
            <div class="m-carousel-inner">
                <!-- the items -->
                <?php
                $i = 0;
                foreach ($newest as $i => $carNews) {
                    $posterUrl = CarNews::model()->getFirstImage($carNews['id']);
                    ?>
                    <a class="m-item" href="<?php echo $this->createUrl("/carNews/" . $carNews['id']); ?>" data-ajax="false">
                        <img src="<?php echo $posterUrl?>" alt="" style="height:240px;" />
                        <div class="m-caption" style="color:white">
                        <img  class="m-new-car" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/home_page_new_car_icon.png" alt="">
                        <span style="vertical-align: super;"><?php echo CHtml::encode($carNews['title']); ?></span>
                        </div>
                    </a>
                <?php } ?>
            </div>
            <div class="m-carousel-controls m-carousel-hud">
                <a class="m-carousel-prev" href="#" data-slide="prev">Previous</a>
                <a class="m-carousel-next" href="#" data-slide="next">Next</a>
            </div>
            <!-- the controls -->

            <div class="m-carousel-controls m-carousel-bulleted">
                <?php
                for ($i = 1; $i <= count($newest); $i++) {
                    $opts = array('data-slide' => $i);
                    if ($i == 1)
                        $opts['class'] = 'm-active';
                    echo CHtml::link($i, "#", $opts);
                }
                ?>
            </div>
        </div>
    </div>
    
    
    <a href="<?php echo Yii::app()->baseUrl; ?>/carNews/browse/category/9">
        <div class="ui-bar ui-bar-d">
            <h3>Điểm tin xe 247</h3>      
            <div class="more-car">
            <input type="image" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/xem_tiep_btn.png" value="MoreCar" data-role="none">
       		</div> 
        </div>
    </a>
    <div class="ui-grid-a">
        <?php
        $j = 0;
        foreach ($carNews247 as $i => $carNews) {
            $j++;
            $ui_block = "";
            switch ($j%3) {
                case 0:
                    $ui_block = 'ui-block-a';
                    break;
                case 1:
                    $ui_block = 'ui-block-b';
                    break;
                case 2:
                    $ui_block = 'ui-block-c';
                    break;
                default:
                    $ui_block = 'ui-block-a';
            }
        $ui_block = 'ui-block-a';
        ?>
        <div class="<?php echo $ui_block; ?>">
            <?php
            $posterUrl = CarNews::model()->getFirstImage($carNews['id']);
			$this->widget("application.widgets.CarNewsItem", array('carNews' => $carNews, 'posterUrl' => $posterUrl, 'isFree' => 1));
            ?>
        </div>
        <?php } ?>
    </div>
    
    
    <a href="<?php echo Yii::app()->baseUrl; ?>/carNews/browse/category/8">
        <div class="ui-bar ui-bar-d">
            <h3>Cẩm nang xa lộ</h3>      
            <div class="more-car">
            <input type="image" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/xem_tiep_btn.png" value="MoreCar" data-role="none">
       		</div> 
        </div>
    </a>
    <div class="ui-grid-a">
        <?php
        $j = 0;
        foreach ($carHighway as $i => $carNews) {
            $j++;
            $ui_block = "";
            switch ($j%3) {
                case 0:
                    $ui_block = 'ui-block-a';
                    break;
                case 1:
                    $ui_block = 'ui-block-b';
                    break;
                case 2:
                    $ui_block = 'ui-block-c';
                    break;
                default:
                    $ui_block = 'ui-block-a';
            }
        $ui_block = 'ui-block-a';
        ?>
        <div class="<?php echo $ui_block; ?>">
            <?php
            $posterUrl = CarNews::model()->getFirstImage($carNews['id']);
			$this->widget("application.widgets.CarNewsItem", array('carNews' => $carNews, 'posterUrl' => $posterUrl, 'isFree' => 1));
            ?>
        </div>
        <?php } ?>
    </div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.m-carousel').carousel();
    });

</script>