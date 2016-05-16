
<div class="export-btn" style="display: inline-block;margin: 20px">
    <button class="btn btn-primary" id="btnExportExcel">Export Excel</button>
    <button class="btn btn-primary" id="btnExportCsv">Export Csv</button>
</div>
<div id="exportTable" style="display: inline-block;width:100%;">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <table border="1" cellpadding="1" cellspacing="1" style="width:100%">
        <tbody id="data.body">
        <tr>
            <td colspan="1" rowspan="3" style="text-align: center;"><strong>Ng&agrave;y</strong></td>
            <td colspan="5" rowspan="1" style="text-align: center;"><strong>Sản lượng g&oacute;i vtv</strong></td>
            <td colspan="4" rowspan="1" style="text-align: center;"><strong>Doanh thu g&oacute;i vtv</strong></td>
        </tr>
        <tr>
            <td colspan="2" rowspan="1" style="text-align: center;"><strong>Đăng k&yacute;</strong></td>
            <td colspan="1" rowspan="2" style="text-align: center;"><strong>Hủy</strong></td>
            <td colspan="1" rowspan="2" style="text-align: center;"><strong>Gia hạn</strong></td>
            <td colspan="1" rowspan="2" style="text-align: center;"><strong>Xem lẻ</strong></td>
            <td colspan="1" rowspan="2" style="text-align: center;"><strong>Đăng k&yacute;</strong></td>
            <td colspan="1" rowspan="2" style="text-align: center;"><strong>Gia hạn</strong></td>
            <td colspan="1" rowspan="2" style="text-align: center;"><strong>Xem lẻ</strong></td>
            <td colspan="1" rowspan="2" style="text-align: center;"><strong>Tổng</strong></td>
        </tr>
        <tr>
            <td style="text-align: center;"><strong>Miễn ph&iacute;</strong></td>
            <td style="text-align: center;"><strong>T&iacute;nh ph&iacute;</strong></td>
        </tr>
        <?php
        $totalSlDkFree = 0;
        $totalSlDkNotFree = 0;
        $totalSlCancel = 0;
        $totalSlExtend = 0;
        $totalSlview = 0;

        $totalDtDk = 0;
        $totalExtend = 0;
        $totalDtView = 0;
        $totalTotal = 0;
        foreach($model as $key => $item){
            $totalSlDkFree = $totalSlDkFree + round($item[0],0);
            $totalSlDkNotFree = $totalSlDkNotFree + round($item[1], 0);
            $totalSlCancel = $totalSlCancel + round($item[2], 0);
            $totalSlExtend = $totalSlExtend + round($item[3], 0);
            $totalSlview = $totalSlview + round($item[4], 0);

            $totalDtDk = $totalDtDk + $item[5];
            $totalExtend = $totalExtend + $item[6];
            $totalDtView = $totalDtView + $item[7];
            $totalTotal = $totalTotal + ($item[5] + $item[6] + $item[7]);
            ?>
            <tr>
                <td style="text-align: center;"><?php echo date('d/m/Y', strtotime($key)); ?></td>
                <td style="text-align: center;"><?php echo round($item[0], 0); ?></td>
                <td style="text-align: center;"><?php echo round($item[1], 0); ?></td>
                <td style="text-align: center;"><?php echo round($item[2], 0); ?></td>
                <td style="text-align: center;"><?php echo round($item[3], 0); ?></td>
                <td style="text-align: center;"><?php echo round($item[4], 0); ?></td>
                <td style="text-align: center;"><?php echo number_format($item[5]); ?></td>
                <td style="text-align: center;"><?php echo number_format($item[6]); ?></td>
                <td style="text-align: center;"><?php echo number_format($item[7]); ?></td>
                <td style="text-align: center;"><?php echo number_format($item[5] + $item[6] + $item[7]); ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td style="text-align: center;"><strong>Tổng</strong></td>
            <td style="text-align: center;"><?php echo round($totalSlDkFree, 0); ?></td>
            <td style="text-align: center;"><?php echo round($totalSlDkNotFree, 0); ?></td>
            <td style="text-align: center;"><?php echo round($totalSlCancel, 0); ?></td>
            <td style="text-align: center;"><?php echo round($totalSlExtend, 0); ?></td>
            <td style="text-align: center;"><?php echo round($totalSlview, 0); ?></td>
            <td style="text-align: center;"><?php echo number_format($totalDtDk); ?></td>
            <td style="text-align: center;"><?php echo number_format($totalExtend); ?></td>
            <td style="text-align: center;"><?php echo number_format($totalDtView); ?></td>
            <td style="text-align: center;"><?php echo number_format($totalTotal); ?></td>
        </tr>
        </tbody>
    </table>

    <p>&nbsp;</p>


    <p>&nbsp;</p>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#btnExportExcel").click(function (e) {
            //getting values of current time for generating the file name
            var dt = new Date();
            var day = dt.getDate();
            var month = dt.getMonth() + 1;
            var year = dt.getFullYear();
            var hour = dt.getHours();
            var mins = dt.getMinutes();
            var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
            //creating a temporary HTML link element (they support setting file names)
            var a = document.createElement('a');
            //getting data from our div that contains the HTML table
            var data_type = 'data:application/vnd.ms-excel';
            var table_div = document.getElementById('exportTable');
            var table_html = table_div.outerHTML.replace(/ /g, '%20');
            a.href = data_type + ', ' + table_html;
            //setting the file name
            a.download = 'report_' + postfix + '.xls';
            //triggering the function
            a.click();
            //just in case, prevent default behaviour
            e.preventDefault();
        });
    });

    $(document).ready(function() {
        $("#btnExportCsv").click(function(e) {
            var table = document.getElementById('data.body');
            var rows = table.getElementsByTagName("tr");
            var csv = "";
            for(var n = 0; n < rows.length; n++){
                var cells = rows[n].getElementsByTagName("td");
                for(var i = 0; i < cells.length; i++){
                    if(cells[i].innerHTML.replace(/,/g,"").match(/\//) || isNaN(cells[i].innerHTML.replace(/,/g,""))){
                        if(i == cells.length - 1) csv = csv + '\''+ cells[i].innerHTML.replace(/,/g,"") + '\'' + '%0A';
                        else csv = csv + '\'' + cells[i].innerHTML.replace(/,/g,"") + '\'' + '%2C';
                    }
                    else{
                        if(i == cells.length - 1) csv = csv+ cells[i].innerHTML.replace(/,/g,"")+ '%0A';
                        else csv = csv + cells[i].innerHTML.replace(/,/g,"")+ '%2C';
                    }
                }
            }
            var dt = new Date();
            var day = dt.getDate();
            var month = dt.getMonth() + 1;
            var year = dt.getFullYear();
            var hour = dt.getHours();
            var mins = dt.getMinutes();
            var postfix = day + "." + month + "." + year + "_" + hour + "." + mins;
            var a = document.createElement('a');
            var data_type = 'data:application/csv;charset=utf-8';
            var table_div = document.getElementById('exportTable');
            if(csv=='') {
                alert('Không có dữ liệu');
                return;
            }
            a.href = data_type + ', ' + csv;
            a.download = 'report_' + postfix + '.csv';
            a.click();
            e.preventDefault();
        });
    });
</script>