<?php
//$this->breadcrumbs=array(
//	'Subscribers'=>array('index'),
//	'Manage',
//);


?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/frameworks.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl ?>/js/homux-stat_mini.js"></script>
<h1>Monitor</h1>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div class="h1Text">vFilm Streaming Server Statistics</div>
<div id="rt">
	<table id="info_table1" class="tbl">
		<tr>
			<th colspan="2" class="first">Connections</th>
			<th colspan="2">MessagesBitRate</th>
		</tr>
		<tr>
			<th class="first date">Total(Accepted/Rejected)</th>
			<th class="connect">Current</th>
			<th class="bytesrate">In</th>
			<th class="bytesrate">Out</th>
		</tr>
		<tr>
			<td><span id="TotConnect">0</span>(<span id="TotAccept">0</span>/<span id="TotReject">0</span>)</td>
			<td class="current"><span id="CurConnect">0</span></td>
			<td class="current"><span id="CurMsgIn">0</span></td>
			<td class="current"><span id="CurMsgOut">0</span></td>
		</tr>
	</table>
	<br />
	<div class="graph">
		<canvas id="connectGraph"></canvas><canvas id="messageGraph"></canvas><canvas id="connectGraphHour"></canvas><canvas id="messageGraphHour"></canvas><canvas id="connectGraphDay"></canvas><canvas id="messageGraphDay"></canvas>
		<div id="vmlConGraph"></div><div id="vmlMsgGraph"></div><div id="vmlConGraphHour"></div><div id="vmlMsgGraphHour"></div><div id="vmlConGraphDay"></div><div id="vmlMsgGraphDay"></div>
	</div>

	<div class="chk"><span class="tt">Detail View<span><input type="checkbox" id="detailViewChk" onclick="chkTbl();"></div>

	<table id="list_table" class="tbl" style="display:none;">
		<tr>
			<th class="first date">DateTime</th>
			<th class="connect">Connection</th>
			<th class="bytesrate">MessagesInBitRate</th>
			<th class="bytesrate">MessagesOutBitRate</th>
		</tr>
		<tbody id="list_tbody">
		</tbody>
	</table>

</div>
<div id="loading" style="display:none"></div>
<div id="debug" style="display:none"></div>
<div id="ver" style="display:none"></div>
</body>