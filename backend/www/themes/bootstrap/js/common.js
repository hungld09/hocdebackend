
function removeSign(str) {
	 str= str.toLowerCase(); 
	 str= str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g,"a");
	 str= str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g,"e");  
	 str= str.replace(/ì|í|ị|ỉ|ĩ/g,"i");
	 str= str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g,"o"); 
	 str= str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g,"u");  
	 str= str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g,"y");  
	 str= str.replace(/đ/g,"d");  
	 str= str.replace(/%/g,"#37;");
	 str= str.replace(/&/g,"#38;");
         str= str.replace(/[^a-zA-Z 0-9]+/g,'');
	 return str;  
}
function removeSpace(str) {
	 str = str.replace(/ +(?= )/g,'');
         return $.trim(str);
}

function getCodeName(str) {
    str = removeSign(str);
    str = removeSpace(str);
    str = str.replace(' ','_','g');
    return str;
}

function checkInt(str) {
    if (Math.ceil(str) != Math.floor(str)) {
        return 'Please, enter valid integer value'; 
    } else return null; 
}



function checkDate(str) {
        if (!$.trim(str).match(/^([1-2]\d{3}-([0]?[1-9]|1[0-2])-([0-2]?[0-9]|3[0-1])) ((20|21|22|23|[0-1]?\d{1}):([0-5]?\d{1}):([0-5]?\d{1}))$/)&& $.trim(str)!='') 
           return 'Please, enter valid datetime value like "yy-mm-dd hh:mm:ss"'; 
        else return null;
   
}

function checkFloat(str) {
        if (!/^[-+]?[0-9]+(\.[0-9]+)?$/.test(str)&& $.trim(str)!='')
         return 'Please, enter valid float value'; 
        else return null;
}







