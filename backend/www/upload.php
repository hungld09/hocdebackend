<?php
    $mimes = array('application/vnd.ms-excel','text/csv','text/plain');
    sleep(2);
    if (isset($_FILES['myfile'])) {
	$fileName = $_FILES['myfile']['name'];
	$fileType = $_FILES['myfile']['type'];
	$fileError = $_FILES['myfile']['error'];
	$fileStatus = array(
		'status' => 0,
		'message' => ''	
	);
	if ($fileError== 1) {
		$fileStatus['message'] = 'Dung lượng quá giới hạn cho phép';
	} elseif (!in_array($fileType, $mimes)) {
		$fileStatus['message'] = 'Không cho phép định dạng này';
	} else { //Không có lỗi nào
		move_uploaded_file($_FILES['myfile']['tmp_name'], '/var/www/html/vfilmbackend/backend/www/upload/'.$fileName);
		$fileStatus['status'] = 1;
		$fileStatus['message'] = "Bạn đã upload $fileName thành công";
         }
	echo json_encode($fileStatus);
	exit();
}
?>