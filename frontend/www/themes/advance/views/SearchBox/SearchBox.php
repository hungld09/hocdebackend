<!--		<header>
			<div class="top-head">
				<a href="#" class="main-menu-link icon-menu fn-nav-show"></a>
				<form name="frmSearch" id="frmSearch" class="frm-search" action="<?php echo CHtml::encode(Yii::app()->baseUrl . "/video/search");?>">
					<p class="text-box">
						<input autocomplete="off" type="text" id="q" name="q" placeholder="Tìm kiếm" class="search-text-box" value="" />
						<a href="#" class="delete-btn icon-cancel none" id="fnSearchReset"></a>
						<a href="#" class="search-btn icon-search" id="fnSearchSubmit"></a>
					</p>
				</form>
			</div>
		</header>-->

<div data-role="header" data-position="fixed"  class="jqm-header">
    <a href="#sliding_menu" class="ui-btn-left" data-iconpos="notext"
       data-icon="slide-menu"></a>
       <img class="delimeter-logo-left" border="0" src="<?php echo Yii::app()->theme->baseUrl."/images/delimiter_action_bar.png"?>">
    <h1 class="jqm-logo">
        <a href="<?php echo Yii::app()->baseUrl ?>/" data-ajax="false">
        <img class="logo-header" src="<?php echo Yii::app()->theme->baseUrl."/images/home_page_logo_header.png"?>">
        </a>
    </h1>
    <a href="#search_page"  data-icon="btn-search" data-rel="popup"
       class="ui-btn-right" data-iconpos="notext"></a>
       <img class="delimeter-logo-right" border="0" src="<?php echo Yii::app()->theme->baseUrl."/images/delimiter_action_bar.png"?>">
    <div data-role="popup" data-theme="b" id="search_page" data-overlay-theme="a" data-position-to="window" data-corners="true">
        <a href="#" data-rel="back" data-role="button" data-theme="a"
           data-icon="delete" data-iconpos="notext" class="ui-btn-left">Close</a>
        <div data-role="content">
            <form action="<?php echo CHtml::encode(Yii::app()->baseUrl . "/video/search");?>" class="search">
                <input type="search" name="q" id="q" value="" />
                <input id="fnSearchSubmit" type="submit" name="submit" value="Go" />
            </form>
        </div>
    </div>
</div>
