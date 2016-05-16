<?php 
?>
<?php

/** @var $asset VodAsset */
/** @var $this VideoController */
$this->pageTitle = "mobiphim - " . $asset->display_name;
$requestUrl = $this->createUrl('/video/watch?id=' . $this->crypt->encrypt($asset['id']));
if ($asset['is_series']){
    $episodes = VodEpisode::model()->findAllByAttributes(array('status' => 1, 'vod_asset_id' => $asset->id), array('order' => 'episode_order'));
    $episode_count = sizeof($episodes);
}
?>


<div  style ="text-shadow: none"id="main_page" data-theme="a">
        <!--<div class="divider header-bg"><h3 class="dtitle"><?php echo CHtml::encode($asset['display_name']) . ($asset['is_series'] ? " - Tập $episode" : ""); ?></h3></div>-->
        <div style ="color: #00ADFF; font-weight: bold;"class="box-title" align="center">
            <h3  class="video_title_header"><?php echo CHtml::encode($asset['display_name']) . ($asset['is_series'] ? " - Tập $episode" : ""); ?></h3>
        </div>
            <div>
                <div id="detail_play" align="center">
                    <?php if (!$this->detect->is('AndroidOS')){ ?>
                    <video id="videoplayer" controls  preload="auto" width="320" height="240"  poster="<?php echo CHtml::encode($posterUrl); ?>"
                           style="min-height:240px;">
                        <source src="<?php echo CHtml::encode($url) ?>" type='video/mp4'>
                    </video>
					<?php } else { ?>
                    <a  href="<?php echo CHtml::encode($url) ?>">
                        <img class="video_car_img" src="<?php echo $posterUrl; ?>" />
                        <img id="icon_play" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/icon_play.png" />
                    </a>
                <?php } ?>
                </div>
            </div>

            <div class="box-film">
                <div class="box-title">
                            <div class="ui-bar ui-bar-d">
                                <h3>VIDEO CÙNG THỂ LOẠI</h3>
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
                                $isFree = 1;
                                $this->widget("application.widgets.AssetItem", array('asset' => $vod, 'posterUrl' => $posterUrl, 'isFree' => $isFree));
                            ?>
                                </div>
                                <?php }
                    } else {
                        ?>
                        <div class="content-items">
                            <p style="color:black;">Không tìm thấy video liên quan</p>
                        </div>
                        <?php }  ?>

                </div>
                
            </div>
</div>

