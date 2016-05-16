    <div class="img_thumbnail" onclick="return view_video('<?php echo Yii::app()->baseUrl . "/carNews/" . $carNews['id'];?>')">
        <a href="<?php echo Yii::app()->baseUrl . "/carNews/" . $carNews['id'];?>" data-ajax="false">
        	<img class="img-mask" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/mask.png" alt="mask ">
            <img style="width: 120px; height: 80px" src="<?php echo $posterUrl;?>" alt="<?php echo CHtml::encode($carNews['title']);?>">
        </a>
        <div class="noidung">
        <span class="film_title"><?php echo CHtml::encode($carNews['title']);?></span>
    	</div>
    	<div class="img_detail">
	        <a href="<?php echo Yii::app()->baseUrl . "/carNews/" . $carNews['id'];?>" data-ajax="false">
	            <img class="img-icon-detail" src="<?php echo Yii::app()->theme->baseUrl; ?>/images/view_new_detail_icon.png">
			</a>
		</div>
    </div>
