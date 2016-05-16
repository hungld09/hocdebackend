
<table id="listAssets"></table> <div id="pagerAsset"></div>

<script>
    
    $.cookie("jqsel_grid_id",null);
    jQuery("#listAssets").jqGrid({ 
        url:'<?php echo CController::createUrl('vodAsset/getListAsset?category='.$model->id)?>', 
        datatype: "json", 
        colNames:['Id','Name','Create Date','End Date', 'Is serie?', 'Status','Category'], 
        colModel:[ 
            {name:'id',index:'t.id', width:50, classes:'colStyle', align:'center',searchoptions:{sopt:['eq','ne']}}, 
            {name:'display_name',index:'t.display_name', width:250, classes:'colStyle', align:'center',searchoptions:{sopt:['eq','ne','cn','nc','bw','bn','ew','en']}}, 
            {name:'create_date',index:'t.create_date', width:320,align:'center', classes:'colStyle',
                searchoptions:{
                    sopt:['eq','ne','lt','le','gt','ge'],
                    dataInit : function (elem) {
                        if (elem.id!='gs_create_date') 
                            $(elem).datepicker({'dateFormat':'yy/mm/dd'});
                    }
                }
            }, 
            {name:'end_date',index:'end_date', width:150, classes:'colStyle', hidden:true, search:false},         
            {name:'is_series', hidden:true,index:'vodEpisode.display_name', width:150, classes:'colStyle',
                searchoptions:{
                    sopt:['eq','ne','cn','nc','bw','bn','ew','en'],
                    dataEvents: [
                   
        { type: 'change', fn: function(e) { this.value = removeSpace(removeSign(this.value)); } },
           
                    ]
//                    dataInit : function (elem) {
//         
//                        if (elem.id!='gs_series_name') {
//                            $(elem).autocomplete({source: '<?php 
//                            echo $this->createUrl('vodSeries/autocompleteSeries') ?>//'});
//                            
//                        }
//                    }
                     
                }
            }, 
            {name:'status',index:'status', width:90, classes:'colStyle',align:'center',  editoptions:{value:"1:Active;0:Inactive"},stype:'select',
                searchoptions:{
                    sopt:['eq'],
                    value:{1:'Active',0:'Inactive'}
                }
            }, 
            {name:'categories',index:'categories', hidden: true}, 
            
           
          
        ],
        multiselect: true,
        height:300,
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
        
    jQuery("#listAssets").jqGrid('navGrid','#pagerAsset',{edit:false,add:false,del:false,search:false},{},{},{},{});
//    ,
//          { // edit option
//              afterShowForm: function(form) { }
//          },
//          { // add option
//              afterShowForm: function(form) { form.replaceWith('<table id="listCategoriesForAdd"></table> ');addCategory();},
//              width: 400,
//              url:'<?php 
//echo CController::createUrl('changeCategory')?>',
//              onclickSubmit:function (params,posdata){
//                  return {assets:$.cookie("jqsel_grid_id"), categories:$("#categories").val()};
//              }}
         
    jQuery("#listAssets").jqGrid('filterToolbar',{ searchOnEnter: true, enableClear: false });
    $("#gs_create_date").replaceWith('<input onchange="trigger()" type="text" value="" id="gs_create_date" name="create_date" style="width: 45%; padding: 0px;">&nbsp;&nbsp;<input onchange="trigger()" type="text" value="" id="gs_end_date" name="end_date" style="width: 45%; padding: 0px;">'); 
   
    $(function() {
        $( "#gs_series_name" ).autocomplete({
                            source: '<?php echo $this->createUrl('vodSeries/autocompleteSeries') ?>'
        });
        $( "#gs_create_date" ).datepicker({'dateFormat':'yy/mm/dd'});
        $( "#gs_end_date" ).datepicker({'dateFormat':'yy/mm/dd'});
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
       
    
   }
   
   function ajaxChangeActive(id) {
    
   }
   
   

</script>