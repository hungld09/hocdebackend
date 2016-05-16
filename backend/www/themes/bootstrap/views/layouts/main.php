<?php
	Yii::app()->clientscript
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap.css' )
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/bootstrap-responsive.css' )
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/main_others.css' )
// 		->registerCssFile( Yii::app()->theme->baseUrl . '/css/main.css' )
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/form.css' )
		->registerCssFile( Yii::app()->theme->baseUrl . '/css/screen.css' )
		//->registerCssFile( Yii::app()->theme->baseUrl . '/css/comment.css' )
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title><?php echo $this->pageTitle; ?></title>
<meta name="description" content="">
<meta name="author" content="">

<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- Le styles -->
<style>
	body {
		padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
	}

	@media (max-width: 980px) {
		body{
			padding-top: 0px;
		}
	}
</style>

<!-- Le fav and touch icons -->
<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
<!--Uncomment when required-->
<!--<link rel="apple-touch-icon" href="images/apple-touch-icon.png">-->
<!--<link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">-->
<!--<link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">-->
<script src="<?php echo Yii::app()->baseUrl; ?>/ckeditor/ckeditor.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/grid.locale-en.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/jquery.jqGrid.min.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/jquery.cookie.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/common.js" type="text/javascript"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/msdropdown/js/jquery.dd.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/css/ui.jqgrid.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/js/msdropdown/dd.css" />
     
 
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/bootstrap/css/jquery-ui-timepicker-addon.css" />
</head>

<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="#"><?php echo Yii::app()->name ?></a>
				<div class="nav-collapse">
					<?php 
					if(isset(Yii::app()->user->id)) {
						$this->widget('bootstrap.widgets.TbMenu',array(
							'htmlOptions' => array( 'class' => 'nav' ),
							'activeCssClass'	=> 'active',
							'items'=>User::getArrayMenu(Yii::app()->user->id),
						));
					} 
					?>

				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>

	<div class="container">
		<?php echo $content ?>
	</div> <!-- /container -->
</body>
</html>
