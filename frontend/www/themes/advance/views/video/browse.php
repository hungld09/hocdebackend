<?php
$this->pageTitle = "xe247 - Danh sách video";
$requestUrl = "";
$records = count($assets);
if ($type == 'browse') {
    $requestUrl = $this->createUrl('/video/browse');
    if (isset($category_id))
        $requestUrl .= "/category/$category_id";
    //$requestWithoutOrder = $requestUrl;

    if ($order_by != "")
        $requestUrl .= "/order/$order_by";
} else {
    $requestUrl = $this->createUrl('/video/search/q/' . $keyword);
}
?>
<script type="text/javascript">
    $(function() {

    });
</script>

<div  style=" text-shadow : none; color: white;"id="main_page" data-theme="a">
        <div class="box-film">
            <div class="box-title">
                        <div class="ui-bar ui-bar-d">
                            <h3><?php echo CHtml::encode(mb_strtoupper($category, "UTF-8")); ?></h3>
                        </div>
               
            </div>
                            <div class="ui-grid-a">
                            <?php
                                $j = 0;
								$ui_block = 'ui-block-a';
                                foreach ($assets as $i => $asset) {
                                    $j++;
                                ?>
                                <div class="<?php echo $ui_block; ?>">
                                    <?php
                                    $posterUrl = VodAsset::getFirstImage($asset['id']);
//                                $posterUrl = array_key_exists('poster_land', $asset) ? $asset['poster_land'] : null;
                                $this->widget("application.widgets.AssetItem", array('asset' => $asset, 'posterUrl' => $posterUrl, 'isFree' => 1));
                            ?>
                                </div>
                                <?php } ?>
                        

                </div>
        </div>
        
    <?php

    if ($records > 0) {
        $this->widget("application.widgets.Pager", array('pager' => $pager, 'baseUrl' => $requestUrl));
    }
    ?>
        
</div>

