
<table id="listAssets"></table> <div id="pagerAsset"></div>

<script>
    
    $.cookie("jqsel_grid_id",null);
    jQuery("#listAssets").jqGrid({ 
        url:'<?php echo CController::createUrl('getListAsset')?>', 
        datatype: "json", 
//        colNames:['Id','Name','Create Date','End Date', 'Status','Category'], 
        colNames:['Id','Name','Create Date', 'Views', 'Status','Actor','Director', 'Original title','Modify user','Modify date','Name Category','Name provider','Category'], 
        colModel:[ 
            {name:'id',index:'id', width:50, classes:'colStyle', align:'center',searchoptions:{sopt:['eq','ne']}}, 
            {name:'keyword',index:'keyword', width:320, classes:'colStyle', align:'center',searchoptions:{sopt:['eq','ne','cn','nc','bw','bn','ew','en']}}, 
            {name:'create_date',index:'create_date', width:160,align:'center', classes:'colStyle', search:false},
            {name:'view_count',index:'view_count', width:100, classes:'colStyle',align:'center', search : false},
            {name:'status',index:'status', width:100, classes:'colStyle',align:'center',  editoptions:{value:"1:Active;2:Inactive"},stype:'select',
                searchoptions:{
                    sopt:['eq'],
                    value:{1:'Active',2:'Inactive'}
                }
            }, 
            {name:'actors',index:'actors', width:150, classes:'colStyle', align:'center',searchoptions:{sopt:['eq','ne','cn','nc','bw','bn','ew','en']}},
            {name:'director',index:'director', width:150, classes:'colStyle', align:'center',searchoptions:{sopt:['eq','ne','cn','nc','bw','bn','ew','en']}},
            {name:'original_title',index:'original_title', width:150, classes:'colStyle', align:'center',searchoptions:{sopt:['eq','ne','cn','nc','bw','bn','ew','en']}},
            {name:'username',index:'username', width:100, classes:'colStyle',align:'center', search : false},
            {name:'modify_date',index:'modify_date', width:150,align:'center', classes:'colStyle', search:false},
            {name:'Category',index:'name_category', width:250,align:'center', classes:'colStyle', search:false},
            {name:'content_provider_id',index:'content_provider_id', width:150, classes:'colStyle',align:'center',  editoptions:{value:"0:Chọn nhà cung cấp;1:Nam Viet;3:Thien Ngan;4:Hang Phim VN;5:Media One;6:HTQ;7:Hang phim hoat hinh;8:ThangLong AV;9:VTC;10:Smart Media;11:VTV;13:Hãng phim HHVN"},stype:'select',
                searchoptions:{
                    sopt:['eq'],
                    value:{0:'Chọn nhà cung cấp',1:'Nam Viet',3:'Thien Ngan',4:'Hang Phim VN',5:'Media One',6:'HTQ',7:'Hang phim hoat hinh',8:'ThangLong AV',9:'VTC',10:'Smart Media',11:'VTV',13:'Hãng Phim HHVN'}
                }
            }, 
            {name:'categories',index:'categories', hidden: true}, 
        ],
        multiselect: true,
        height:'auto',
        rowNum:10, 
        rowList:[10,20,30], 
        pager: '#pagerAsset', 
        sortname: 't.display_name', 
        viewrecords: true, 
        sortorder: "asc", 
        caption:"List Assets",
        recreateFilter:true,
//        multikey:'altKey',''
        onSelectRow: function(id,selected)
                        { 
                                if($.cookie("jqsel_grid_id") == null && selected == true)
                                {
                                        $.cookie("jqsel_grid_id",id);
                                } else {
                                        var selected_jq_ids;
                                        selected_jq_ids = $.cookie("jqsel_grid_id");

                                        selected_jq_ids_array = new Array();
                                        selected_jq_ids_array = selected_jq_ids.split(",");

                                        if(selected == true)
                                        {
                                                var currIndex = selected_jq_ids_array.length;
                                                selected_jq_ids_array[currIndex] = id;
                                        }
                                        else
                                        {
                                                var delete_id;

                                                for (i=0; i < selected_jq_ids_array.length; i++)
                                                        if (selected_jq_ids_array[i] == id)
                                                                delete_id = i;

                                                //Delete Index
                                                tmpdArray = new Array();
                                                selected_jq_ids_array[delete_id] = tmpdArray[delete_id];
                                        }

                                        filteredArray = new Array();
                                        var newCounter = 0;

                                        //Filter array
                                        for (i=0; i < selected_jq_ids_array.length; i++)
                                                if (selected_jq_ids_array[i] != null && selected_jq_ids_array[i] != "")
                                                {
                                                        filteredArray[newCounter] = selected_jq_ids_array[i];
                                                        newCounter = newCounter+1;
                                                }

                                        //Store values
                                        $.cookie("jqsel_grid_id",filteredArray);
                                }

                        },
        onSelectAll: function(ids,selected) 
                                { 
                                        if($.cookie("jqsel_grid_id") == null)
                                        {
                                                $.cookie("jqsel_grid_id",ids);
                                        } else {
                                                var selected_jq_ids;
                                                selected_jq_ids = $.cookie("jqsel_grid_id");

                                                selected_jq_ids_array = new Array();

                                                selected_jq_ids_array = selected_jq_ids.split(",");

                                                        var i;
                                                        var e;
                                                        var tmpdArray = new Array();
                                                        var selected_ids_lenght = selected_jq_ids_array.length;
                                                        var onSelect_ids_lenght = ids.length;
                                                        var indexCounter = selected_ids_lenght;
                                                        var value_exists = null;

                                                        for (e=0; e < onSelect_ids_lenght; e++)
                                                        {
                                                                for (i=0; i < selected_ids_lenght; i++)
                                                                {
                                                                        if (selected_jq_ids_array[i] == ids[e])
                                                                        {
                                                                                value_exists = i;
                                                                        }
                                                                }
                                                                if (value_exists == null)
                                                                {
                                                                        if (selected == true)
                                                                        {
                                                                                indexCounter = indexCounter + 1;
                                                                                selected_jq_ids_array[indexCounter] = ids[e];
                                                                        }
                                                                }
                                                                else
                                                                {
                                                                        if (selected == false)
                                                                        {
                                                                                selected_jq_ids_array[value_exists] = tmpdArray[value_exists];
                                                                                value_exists = null;
                                                                        }
                                                                        else
                                                                        {
                                                                                value_exists = null;
                                                                        }
                                                                }
                                                        }

                                                filteredArray = new Array();
                                                var newCounter = 0;

                                                //Filter array
                                                for (i=0; i < selected_jq_ids_array.length; i++)
                                                        if (selected_jq_ids_array[i] != null && selected_jq_ids_array[i] != "")
                                                        {
                                                                filteredArray[newCounter] = selected_jq_ids_array[i];
                                                                newCounter = newCounter+1;
                                                        }

                                                //Store values
                                                $.cookie("jqsel_grid_id",filteredArray);
                                        }
                                },
        gridComplete: function()
                                { //Ver se ha algum event que liste as rows para ser melhor performance
                                        selected_jq_ids = $.cookie("jqsel_grid_id");


                                        if (selected_jq_ids != null)
                                        {
                                                currentGridIds = new Array();
                                                currentGridIds = jQuery("#listAssets").getDataIDs();

                                                selected_jq_ids_array = new Array();
                                                selected_jq_ids_array = selected_jq_ids.split(",");

                                                //Make Selection
                                                var e;
                                                var i;
                                                for (e=0; e < currentGridIds.length; e++)
                                                        for (i=0; i < selected_jq_ids_array.length; i++)
                                                                if (selected_jq_ids_array[i] == currentGridIds[e])
                                                                        jQuery("#listAssets").setSelection(selected_jq_ids_array[i],false);
                                        }
                                },
        beforeSelectRow: function(rowid, e) {
            if (e.target.id.indexOf('active_')!==-1) {
               
                return false;
            }
            return true;
        }

        }); 
        jQuery("#listAssets").jqGrid('navGrid','#pagerAsset',{edit:false,add:false,del:true},{},{},
                {url:'<?php echo CController::createUrl('deleteAsset')?>',
                 onclickSubmit : function(params) {                       
                                    return {listAsset: $.cookie("jqsel_grid_id")};
                                 },
                 afterComplete : function (response, postdata, formid) {
                                    $.cookie("jqsel_grid_id",null);
                                    $('#listAssets').trigger('reloadGrid');
                                 } 
                },
                {multipleSearch:true,closeAfterSearch: true,closeAfterReset:true,closeOnEscape:true,width:800,onSearch:toggleSearch,onReset:toggleReset,showQuery: true,multipleGroup:true} 
        );
         
    jQuery("#listAssets").jqGrid('filterToolbar',{ searchOnEnter: true, enableClear: false });
   
    $(function() {
        $( "#gs_series_name" ).autocomplete({
                            source: '<?php echo $this->createUrl('vodSeries/autocompleteSeries') ?>'
        });
        $('#gs_status').prepend(
        $('<option></option>').val('').html('All')
        );
        $("#gs_status option:first").attr('selected','selected');



            
    });
    
    
   function trigger() {
   var sgrid = $("#listAssets")[0];
   
   sgrid.triggerToolbar();
   }
   
   function changeActive(id) {
       
       if ($('#active_'+id).hasClass('activeImage')) {
           $('#active_'+id).removeClass('activeImage');
                 
       } else {
           $('#active_'+id).removeClass('inactiveImage');          
       }
       $('#active_'+id).addClass('loaderImage');
       ajaxChangeActive(id);
   }
   
   function ajaxChangeActive(id) {
        $.ajax({
          url:"<?php echo Yii::app()->createUrl('vodAsset/changeActive') ?>",
          data: {id: id },
          type: 'POST',
          success: function(data){
              $('#active_'+id).removeClass('loaderImage');
              if (data==1)
                $('#active_'+id).addClass('activeImage'); 
              else $('#active_'+id).addClass('inactiveImage');  
          }
        });
   }

   function active(){
        selected_jq_ids = $.cookie("jqsel_grid_id");
        if(selected_jq_ids == null){
            alert("Bạn chưa chọn phim nào !");
        }       

        url = '<?php echo Yii::app()->createUrl('vodAsset/changeMultiveActive') ?>';
        jQuery.ajax({
            url : url,
            data : "array_id="+selected_jq_ids,
            type : 'POST',
            success : function(data) {
                location.reload();
            }
        });
    }

    function inactive(){
        selected_jq_ids = $.cookie("jqsel_grid_id");
        if(selected_jq_ids == null){
            alert("Bạn chưa chọn phim nào !");
        }       

        url = '<?php echo Yii::app()->createUrl('vodAsset/changeMultiveInactive') ?>';
        jQuery.ajax({
            url : url,
            data : "array_id="+selected_jq_ids,
            type : 'POST',
            success : function(data) {
                location.reload();
            }
        });
    }
   
   function toggleSearch() {

    jQuery("#listAssets").jqGrid('setGridParam',{postData:{searchString:$(".query").first().text()} });
    $("#gs_id").val('');
    $("#gs_status").val('');
    $("#gs_display_name").val('');  
    $("#gs_categories").val(''); 
    
    $("#listAssets")[0].clearToolbar();
   }
   
   function toggleReset() {
    jQuery("#listAssets").jqGrid('setGridParam',{postData:{searchString:''} });
    $("#gs_id").val('');
    $("#gs_status").val('');
    $("#gs_display_name").val('');  
    $("#gs_categories").val(''); 
    $("#listAssets")[0].clearToolbar();
   }
</script>