<div class="pagination" style="text-align:center;">
    <a style="color: #00adff">Trang:</a>
<?php
//var_dump($pager);
$fullUrl = $delimiter == '=' ? (preg_match('/\?/', $requestUrl) ? "$requestUrl&page=" : "$requestUrl?page=") : "$requestUrl/page/";
if ($pager['page_number'] > 0)
	echo CHtml::link("&laquo;", $fullUrl . $pager['page_number'], array('class' => "pager gradient"));
$ignore = false;
for ($i = 0; $i < $pager['total_page']; $i++) {
	$page = $i + 1;
	if ($i > 1 && $i < $pager['page_number'] - 2) {
		if ($ignore) continue;
		if ($i + 1 < $pager['page_number'] - 2) { // only display `...` if have at least 2 pages in the middle 
			echo "<span class=\"pager gradient\">&hellip;</span>";
			$ignore = true;
		} else {
			echo CHtml::link($page, "$fullUrl$page", array('class' => 'pager gradient'));
		}
	} else if ($i == $pager['page_number']) {
		echo "<span class=\"pager active\">$page</span>";
		$ignore = false;
	} else if ($i > $pager['page_number'] + 2 && $i < $pager['total_page'] - 2) {
		if ($ignore) continue;
		if ($i + 1 < $pager['total_page'] - 2) { // only display `...` if have at least 2 pages in the middle
			echo "<span class=\"pager gradient\">&hellip;</span>";
			$ignore = true;
		} else {
			echo CHtml::link($page, "$fullUrl$page", array('class' => 'pager gradient'));
		}
	} else {
		echo CHtml::link($page, "$fullUrl$page", array('class' => 'pager gradient'));
		$ignore = false;
	}
}
$next = $pager['page_number'] + 1;
if ($next < $pager['total_page'])
	echo CHtml::link("&raquo;", "$fullUrl" . ($next + 1), array('class' => "pager gradient"), array('data-ajax' => 'false'));
?>
</div>