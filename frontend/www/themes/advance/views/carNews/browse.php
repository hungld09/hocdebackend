<?php
$this->pageTitle = "xe247 - Danh sách tin tức";
$requestUrl = "";
$records = count($assets);
if ($type == 'browse') {
    $requestUrl = $this->createUrl('/carNews/browse');
    if (isset($category_id))
        $requestUrl .= "category/$category_id";

    if ($order_by != "")
        $requestUrl .= "/order/$order_by";
} else {
    $requestUrl = $this->createUrl('/carNews/search/q/' . $keyword);
}
?>

<div  style=" text-shadow : none; color: white;"id="main_page" data-theme="a">
        <div class="ui-bar ui-bar-d" style="text-align: center;">
            <h2><?php echo CHtml::encode(mb_strtoupper($category, "UTF-8")); ?></h2>     
        </div>
    <div class="ui-grid-a">
        <?php
        $j = 0;
        foreach ($assets as $i => $carNews) {
        	$posterUrl = CarNews::model()->getFirstImage($carNews['id']);
        	if($j%6==0){
        ?>
	        <div class="ui-block-a">
    		<div class="img_thumbnail_poster">
			    <a class="poster_img ui-link" href="<?php echo Yii::app()->baseUrl . "/carNews/" . $carNews['id'];?>">
							<img style="height: 240px; width: 100%;" src="<?php echo $posterUrl?>" alt="">
			     </a>
	     		<div class="thumbnail_title">
        		<span><?php echo $carNews['title']?></span>
    			</div>
    		</div>
    		</div>
        <?php } else {?>  
		        <div class="ui-block-a">
		            <?php
					$this->widget("application.widgets.CarNewsItem", array('carNews' => $carNews, 'posterUrl' => $posterUrl));
		            ?>
		        </div>
        	<?php }?>
        <?php 
        $j++;
        } ?>
    </div>
        
    <?php

    if ($records > 0) {
        $this->widget("application.widgets.Pager", array('pager' => $pager, 'baseUrl' => $requestUrl));
    }
    ?>
        
</div>

