//Init config 
$(document).bind("mobileinit", function(){
	$.mobile.defaultPageTransition = 'slide';
        $.mobile.ajaxEnabled = false;
});
function closeNofiticate(){$('.notification').hide();}

function confirmPurchase(price) {
    if (confirm("Quý khách đã chọn mua nội dung với giá " + price + " VNĐ. Thời gian sử dụng 24 giờ. Đồng ý?")) {
      return true;
    }
    return false;
}
function confirmCancel(url) {
    if (confirm("Ngay sau khi huỷ thì gói cước của quý khách sẽ là gói mặc định. Quý khách có đồng ý không?")) {
        location.href = url;
    }
}

function confirmPackage(url, des) {
    if (confirm("Quý khách có chắc chắn muốn đăng ký gói cước?\n" + des)) {
        location.href = url;
    }
}
function view_video(url){
    location.href = url;
}