<div class="export-btn" style="display: inline-block;margin: 20px">
    <button class="btn btn-primary" id="btnExportExcel">Export Excel</button>
    <button class="btn btn-primary" id="btnExportCsv">Export Csv</button>
</div>
<div id="exportTable" style="display: inline-block;width:100%;">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <?php echo $result; ?>

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