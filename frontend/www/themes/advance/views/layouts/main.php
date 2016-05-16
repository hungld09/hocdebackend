<?php /* @var $this Controller */ 
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
        <meta name="format-detection" content="telephone=no" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/css/themes/xe247/xe247.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/css/themes/xe247/style.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/css/jquery.mobile.structure-1.3.0.min.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/css/jQMxe247.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/js/carousel/carousel.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/js/carousel/carousel-style.css" type="text/css" />
        <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl;?>/images/xe247-icon.ico" type="image/x-icon" />
        
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/vinaphim.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.mobile-1.3.1.min.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/carousel/carousel.js"></script>
        <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl ?>/js/jquery.raty.min.js"></script>

        
    </head>
    <body >
        <div data-role="page" class="jqm-page" id="<?php echo isset($this->page_id)?$this->page_id:"home_page"; ?>" >
           <!--Header-->
            <?php
            $this->widget("application.widgets.NavMenu", array('categoriesCarNews' => $this->categoriesCarNews, 'carBrand' => $this->carBrand, 'carVodCat' => $this->carVodCat));
            $this->widget("application.widgets.SearchBox");
            ?>
            <!--End Header-->
            <!--Cotent-->
            <div data-role="content" class="jqm-content" id="view-content">
            	<?php echo $content; ?>
            </div>
            <!--End Content-->
            
            <!--Footer-->
            
            <!--End Footer-->
       </div>
    </body>
    <script type="text/javascript">
        $(document).ready(function(){
           
           $( "#sliding_menu" ).on( "panelopen",  function( event, ui ) {
               maxHeight = $( "#sliding_menu .ui-panel-inner" ).height();
               console.log("open slide:" + maxHeight);
               $('#view-content').height(maxHeight);
            });
           $( "#sliding_menu" ).on( "panelclose",  function( event, ui ) {
               console.log("close slide");
               $('#view-content').removeAttr('style');
            }); 
        });
    </script>
</html>
