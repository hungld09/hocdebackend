<table id="listStream"></table><div id="navStream"></div>

<script>
    var lastsel;
jQuery("#listStream").jqGrid({ 
        url:'<?php echo CController::createUrl('getListStream?id='.$model->id)?>', 
        datatype: "json", 
        colNames:['Url','Width','Height','Bitrate', 'Status','Status','Type','Type', 'Quality' ,'Protocol'], 
        colModel:[ 
            {name:'url',index:'url', width:350, classes:'colStyle',editable:true, align:'left',editoptions:{size:50, maxLength:500},editrules:{required:true}}, 
            {name:'width',hidden:true, index:'width', width:50,align:'center',width:70, editable:true, classes:'colStyle',editoptions:{size:7},editrules:{integer:true}}, 
            {name:'height',hidden:true, index:'height', align:'center',width:70, editable: true,classes:'colStyle',editoptions:{size:7},editrules:{integer:true}}, 
            {name:'bitrate',index:'bitrate', align:'center',width:70, editable: true,classes:'colStyle',editoptions:{size:7},editrules:{integer:true}}, 
            {name:'statusEdit',index:'statusEdit', align:'center',width:70, editable: false},
            {name:'status', index:'status', align:'center',width:70, hidden:true, editable: false,classes:'colStyle',edittype:"checkbox",editoptions:{value:"1:0", checked:true},editrules:{edithidden:true}},
            {name:'streamTypeEdit',index:'streamTypeEdit', align:'center',width:70, editable: false},
            {name:'streamType',index:'streamType', align:'center',width:70, hidden:true, editable: true,classes:'colStyle',edittype:"select",editoptions:{value:"1:video;2:trailer"},editrules:{edithidden:true}},
            {name:'streamQuality',index:'streamQuality', align:'center',width:70, hidden:true, editable: true,classes:'colStyle',edittype:"select",editoptions:{value:"1:nomar;2:hd"},editrules:{edithidden:true}},
             {name:'protocol',index:'protocol', width:70, classes:'colStyle',editable:false, align:'center',editoptions:{size:50, maxLength:500},editrules:{required:true}}, 
        ],
        width:880,
        height:'auto',
//        cellurl:,
//        cellEdit: true,
        multiselect: true,
        pager: '#navStream', 
        pgbuttons:false,
        pginput:false,
        sortname: 'url', 
        viewrecords: true, 
        sortorder: "asc", 
        caption:"List Streams",
        onSelectRow: function(id){ if(id && id!==lastsel){ jQuery('#listStream').jqGrid('restoreRow',lastsel); jQuery('#listStream').jqGrid('editRow',id,true); lastsel=id; } },
        editurl: "<?php echo Yii::app()->createUrl('vodAsset/updateStream') ?>",
        beforeSelectRow: function(rowid, e) {
            if (e.target.id.indexOf('active_')!==-1 || e.target.id.indexOf('trailer_')!==-1) {
                return false;
            }
            return true;
        }
        });
       
jQuery("#listStream").jqGrid('navGrid','#navStream',
{edit:true,add:true,del:true,search:false, refresh:true},{},
//add stream begin
{width:500,url:'<?php echo CController::createUrl('vodAsset/addStream/vod_asset_id/'.$model->id)?>'},
//add stream end
//remove stgream begin
{width:500,url:'<?php echo CController::createUrl('vodAsset/deleteStream/vod_asset_id/'.$model->id)?>'}
//remove stgream end
);
    
$("#alertmod").css('top',$("#listStream").offset().top-200);    
$("#alertmod").css('left',250);

  function changeStreamActive(id) {
       
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
          url:"<?php echo Yii::app()->createUrl('vodAsset/updateStream') ?>",
          data: {status: false, id:id },
          type: 'POST',
          success: function(data){
              $('#active_'+id).removeClass('loaderImage');
              if (data==1)
                $('#active_'+id).addClass('activeImage'); 
              else $('#active_'+id).addClass('inactiveImage');  
          }
        });
   }
   
   function changeStreamTrailer(id) {
       
       if ($('#trailer_'+id).hasClass('activeImage')) {
           $('#trailer_'+id).removeClass('activeImage');
                 
       } else {
           $('#trailer_'+id).removeClass('inactiveImage');          
       }
       $('#trailer_'+id).addClass('loaderImage');
       ajaxChangeTrailer(id);
   }
   
   function ajaxChangeTrailer(id) {
        $.ajax({
          url:"<?php echo Yii::app()->createUrl('vodAsset/updateStream') ?>",
          data: {streamType: false, id:id },
          type: 'POST',
          success: function(data){
              $('#trailer_'+id).removeClass('loaderImage');
              if (data==1)
                $('#trailer_'+id).addClass('activeImage'); 
              else $('#trailer_'+id).addClass('inactiveImage');  
          }
        });
   }
   
    
    
   
</script>
