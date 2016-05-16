<?php
$this->pageTitle = "xe247 - " . $carNews->title;
?>
<style type="text/css">
    caption { font-size: larger; margin: 1em auto; }
</style>
<div style ="text-shadow:none;" id="main_page" data-theme="a">
        <div data-role="content" class="jqm-content" >
            <div class="content-top">
            <!--<a class="poster_img" href="#" >
				<img style="height: 240px; width: 100%;"src="<?php echo $posterUrl; ?>" alt="">
            </a>
                 --><p class="orginal-title">
					<?php echo CHtml::encode($carNews['title']); ?>
                </p>
				<div class="separation_line">
				</div>
                            
        	</div>
             <div class="content-bottom">
                        <div class="textinfo"><?php echo (isset($carNews['content']) && $carNews['content'] != '') ? $carNews['content'] : "Đang cập nhật"?></div>
        	</div>
    	<div id="relateCarNews" class="box-film" >
                <div class="box-title">
                    <div class="ui-bar ui-bar-d">
                        <h3>ĐIỂM TIN XE 247 CÙNG THỂ LOẠI</h3>
                    </div>
                </div>
                <div class="ui-grid-a">
                            <?php
                            if (count($related) > 0) {
                                $j = 0;
                                foreach ($related as $i => $carNews) {
                                     $ui_block = 'ui-block-a';
                                    $j++;
                                ?>
                                <div class="<?php echo $ui_block; ?>">
                                    <?php
                                $posterUrl = CarNews::model()->getFirstImage($carNews['id']);
                                $this->widget("application.widgets.CarNewsItem", array('carNews' => $carNews, 'posterUrl' => $posterUrl));
                            ?>
                                </div>
                                <?php }
                    } else {
                        ?>
                        <div class="content-items">
                            <p style="color:black;">Không tìm thấy điểm tin xe 247 liên quan</p>
                        </div>
                        <?php }  ?>
                   
                </div>
            </div>
    
</div>
