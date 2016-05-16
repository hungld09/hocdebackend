<?php
/** @var $asset VodAsset */
/** @var $this VideoController */
$this->pageTitle = "xe247 - " . $asset->display_name;
//$hasService = count($this->usingServices) > 0 ? true : false;
if ($asset['is_series']){
    $episodes = VodEpisode::model()->findAllByAttributes(array('status' => 1, 'vod_asset_id' => $asset->id), array('order' => 'episode_order'));
    $episode_count = sizeof($episodes);
}
?>
<style type="text/css">
    caption { font-size: larger; margin: 1em auto; }
</style>
<div style ="text-shadow:none; margin-top: 10px;" id="main_page" data-theme="a">
        <div data-role="content" class="jqm-content" >
            <div class="content-top">
            <div class="content-top-left"  style=" position: relative;">
                <a class="poster_img" href="#" >
				<img style="height: 150px; width: 100px;"src="<?php echo $posterUrl; ?>" alt="">
                </a>
                            <a style ="position: absolute; top: 20%; left: 33%;"id="icon_play" href="<?php echo $watchUrl;?>" data-ajax="false">
                                <img class="detail-play" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/btn_detail_play_normal.png">
                            </a>
          </div>        
            <div class ="content-top-right">
                            <h3 class="name">
				<?php echo CHtml::encode($asset['display_name']); ?>
                            </h3>

                    <a href="#popuprate" data-rel="popup" data-position-to="window"  data-theme="a" data-transition="pop">
                        <div id="half-demo" style="margin-bottom: 10px; background-color: #30455E;">
                        </div>
                    </a>
                <div data-role="popup" data-theme="b" id="popuprate" data-overlay-theme="a" data-position-to="window" data-corners="true">
                    <a href="#" data-rel="back" data-role="button" data-theme="a"
                       data-icon="delete" data-iconpos="notext" class="ui-btn-left">Close</a>
                    <div data-role="content" style="color:#fff; text-shadow: none;">
                        <h3 >Đánh giá của bạn</h3>
                        <div id="rate_star" ></div>
                        <div id="title_star" ></div>
                        <form action="" onsubmit="return rateStar();" class="search">
                            <input id="fnSearchSubmit" type="submit" name="submit" value="Submit" />
                        </form>
                    </div>
                </div>
                
                            <div class="space">
				<span class="textlabel">Thời lượng: </span>
                                <span class="textinfo"><?php echo (isset($asset['duration']) && $asset['duration'] != '') ? CHtml::encode($asset['duration']) . ' phút ': "Đang cập nhật" ?></span>
                            </div>
                            <div class="space">
				<span class="textlabel">Lượt xem: </span>
                                <span class="textinfo"><?php echo (isset($asset['view_count']) && $asset['view_count'] != '') ? CHtml::encode($asset['view_count']) . ' lượt ': "Đang cập nhật" ?></span>
                            </div>
                           <div class="space">
				<span class="textlabel">Giá: </span>
                                <span class="textinfo"><?php echo (isset($asset['price']) && $asset['price'] != '') ? CHtml::encode($asset['price']) . ' đồng ': "Đang cập nhật" ?></span>
                            </div>
                            <div class="space">
				<span class="textlabel">Thể loại: </span>
                                <span class="textinfo"><?php echo $catenames;?></span>
                            </div>
                            <div class="space">
				<span class="textlabel">Đạo Diễn:  </span>
                                <span class="textinfo"><?php echo (isset($asset['director']) && $asset['director'] != '') ? CHtml::encode($asset['director']) : "Đang cập nhật" ?></span>
                            </div >
                            <div class="space">
				<span class="textlabel">Diễn viên: </span>
                                <span class="textinfo"><?php echo (isset($asset['actors']) && $asset['actors'] != '') ? CHtml::encode($asset['actors']) : "Đang cập nhật" ?></span>
                            </div>
                        </div>
            <div class="trailer" style="border-bottom: 1px solid #000; padding-bottom: 5px;"></div>
        </div>
             <div class="content-bottom">
                        <p id="" class="textinfo"><?php echo (isset($asset['description']) && $asset['description'] != '') ? CHtml::encode($asset['description']) : "Đang cập nhật"?></p>
            </div>
        </div>
    <div id="relateVOD" class="box-film" >
                <div class="box-title">
                    <div class="ui-bar ui-bar-d">
                        <h3>VIDEO XE CÙNG THỂ LOẠI</h3>
                    </div>
                </div>
                        <div class="ui-grid-a">
                            <?php
                            if (count($related) > 0) {
                                $j = 0;
                                $ui_block = 'ui-block-a';
                                foreach ($related as $i => $vod) {
                                    $j++;
                                ?>
                                <div class="<?php echo $ui_block; ?>">
                                    <?php
                                    $posterUrl = VodAsset::getFirstImage($vod['id']);
//                                $rPosterUrl = array_key_exists('poster_land', $vod) ? $vod['poster_land'] : null;
                                $this->widget("application.widgets.AssetItem", array('asset' => $vod, 'posterUrl' => $posterUrl, 'isFree' => 1));
                            ?>
                                </div>
                                <?php }
                    } else {
                        ?>
                        <div class="content-items">
                            <p style="color:black;">Không tìm thấy phim liên quan</p>
                        </div>
                        <?php }  ?>
                   
                </div>
        
            </div>
    
</div>

