<?php
$this->breadcrumbs=array(
	'Vod Categories'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Create VodCategory', 'url'=>array('create')),
);

?>

<h1>Manage Vod Categories</h1>
   

<table id="listCategories"></table> 
<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id'=>'deleteDialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Delete Category',
        'autoOpen'=>false,
        'buttons'=> array('OK'=>'js: function() {deleteCategory();}','Cancel'=>'js: function() {$( this ).dialog( "close" );}'),
        'modal'=>true
    ),
));
?>
<div id="dialog-message" title="Delete Category">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		Do you really want to delete this category?
	</p>
	
</div>
<?php 
    $this->endWidget('zii.widgets.jui.CJuiDialog'); 
?>

<script>
var selectedId = null; 
jQuery("#listCategories").jqGrid({
        url:'<?php echo CController::createUrl('getListCategories')?>', 
        datatype: "json", 
        height: "auto",
        colNames: ["Name","Status","Sort","ChildCount","Move","Delete"],
        colModel: [
            //{name: "id",width:1, hidden:true, key:true},
            {name: "category",classes:'colStyle', formatter:'showlink', formatoptions:{baseLinkUrl:'<?php echo CController::createUrl('view')?>', idName:'id'},width:300, resizable: false, sortable: false},
            {name: "status", width:120, resizable: false,align:'center', sortable: false,formatter:imageFormat},
            {name: "sort", width:100, resizable: false,align:'center', sortable: false,formatter:imageSortFormat},
            {name: "childCount", width:250, resizable: false,align:'center', sortable: false,hidden:true},
            {name: "move", width:100, resizable: false,align:'center', sortable: false,formatter:imageMoveFormat},
//            {name: "child_count", width:250, resizable: false,align:'center', sortable: false,hidden:true},
            {name:'action', width:120, resizable: false, align:'center', sortable: false,fixed:true, search:false, formatter:imageDeleteFormat},
        ],
        height:'auto',
        treeGrid: true,
        treeGridModel: "adjacency",
        caption: "Vod Categories",
        ExpandColumn: "category",
        ExpandColClick: false,
        //autowidth: true,
        rowNum: 100,
        //ExpandColClick: true,
        treeIcons: {leaf:'ui-icon-document-b'},
        jsonReader: {
            repeatitems: false,
            root: "response"
        },
        beforeSelectRow: function(rowid,e){return false;}
    }); 
function imageFormat(cellvalue, options, rowObject) {
    if (cellvalue == 1) {
    return '<img alt="" src="<?php echo Yii::app()->baseUrl.'/images/spacer.gif'?>" onclick="js: changeActive('+rowObject.id+');" id="active_'+rowObject.id+'" class="activeImage">';
    } else return '<img alt="" src="<?php echo Yii::app()->baseUrl.'/images/spacer.gif'?>" onclick="js: changeActive('+rowObject.id+');" id="active_'+rowObject.id+'" class="inactiveImage">';
}   

function imageSortFormat(cellvalue, options, rowObject) {
    var returnString='';
    if (cellvalue != 1) {
     returnString +='<img alt="up" src="<?php echo Yii::app()->baseUrl.'/images/spacer.gif'?>" class="upImage" onClick="moveCategory(1,'+rowObject.id+')">';
    } 
    if (cellvalue != rowObject.childCount) {
     returnString +='<img alt="down" src="<?php echo Yii::app()->baseUrl.'/images/spacer.gif'?>" class="downImage" onClick="moveCategory(2,'+rowObject.id+')">';
    }
    return returnString;
} 

function imageMoveFormat(cellvalue, options, rowObject) {
    var returnString='';
    if (cellvalue != 0) { // level cua category > 0, co the move len level cap parent
     returnString +='<img alt="back" src="<?php echo Yii::app()->baseUrl.'/images/spacer.gif'?>" class="backImage" onClick="moveCategory(3,'+rowObject.id+')">';
    } 
    if (rowObject.sort!=0) { // order_number cua category != 0, moveForward category nay de no thanh children cua category ngay phia 
     returnString +='<img alt="forward" src="<?php echo Yii::app()->baseUrl.'/images/spacer.gif'?>" class="forwardImage" onClick="moveCategory(4,'+rowObject.id+')">';
    }
    return returnString;
} 

function imageDeleteFormat(cellvalue, options, rowObject) {
    var returnString ='';
    if (rowObject.child_count<1) {
     returnString +='<img alt="forward" style="margin-left:13px;cursor:pointer" src="<?php echo Yii::app()->baseUrl.'/images/spacer.gif'?>" class="deleteImage" onClick="openDiaglog('+rowObject.id+')">';
    }
    return returnString;
} 
function moveCategory(urlType,id) {
    var url;
    switch (urlType) {
        case 1:
            url = "/moveup";
            break;
        case 2:
            url = "/movedown";
            break;
        case 3:
            url = "/moveback";
            break;
        case 4:
            url = "/moveforward";
            break;    
    }

        $.ajax({

        type:'GET',
        url: '<?php echo Yii::app()->createUrl('vodCategory') ?>'+ url,

        data: {'id':id},
        success:function(data) {
        $('#listCategories').trigger("reloadGrid");

        }
        });
}
function openDiaglog(id){
    selectedId = id;
    $('#deleteDialog').dialog('open');
}
function deleteCategory(){
    $.ajax({

        type:'POST',
        url: '<?php echo CController::createUrl('delete') ?>',

        data: {'id':selectedId},
        success:function(data) {
        $('#deleteDialog').dialog('close');    
        $('#listCategories').trigger("reloadGrid");       
        }
        });
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
      url:"<?php echo Yii::app()->createUrl('vodCategory/changeStatus') ?>",
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


</script>
