<?php
$this->pageTitle = "xe247 - " . $car->model;
?>
<style type="text/css">
    caption { font-size: larger; margin: 1em auto; }
</style>
<div style ="text-shadow:none;" id="main_page" data-theme="a">
        <div data-role="content" class="jqm-content" >
            <div class="content-top">
             <p class="orginal-title" style="text-align: center">
					<?php echo CHtml::encode($car['model']); ?>
                </p>
				<div class="separation_line">
				</div>
                            
        	</div>
        	<div class="content-bottom">
        		<?php echo $car->getHtmlContent();?>
        	</div>
        	<?php $this->widget("application.widgets.Footer", array('categories' => $this->categoriesCarNews)); ?> 
</div>
