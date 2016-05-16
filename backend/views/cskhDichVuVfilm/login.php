<!DOCTYPE html>
<html>
<head>
</head>
<body>

<form method="post" name="postForm">
    <script type="text/javascript">
        $(function() {
            $.get('http://10.211.0.250:8080/SSO/SSOService.svc/user/RequestToken', {},
                function(ssodata) {
//                    console.log('ssodata', ssodata);
                    // get url to logon page in case this operation fails
                    var logonPage = 'http://10.211.0.250:8080/SSO/Login.aspx?keyid=10020&URL=<?php echo Yii::app()->createAbsoluteUrl('CskhDichVuVfilm/tracuuthuebao') ?>';
                    if (ssodata.Status == 'SUCCESS') {
                        // verify the token is genuine
                        $.ajax({
                            type: "GET",
                            url: "<?php echo Yii::app()->createAbsoluteUrl('CskhDichVuVfilm/loginProcess') ?>",
                            data: { type: "CheckUser", token: ssodata.Token },
                            contentType: "application/json; charset=utf-8",
                            dataType: "text",
                            success: function(respone) {
                                console.log('RequestToken: ',respone);
                                if(respone == '1') {
                                    //đang nhập thành công điều hướng về trang index của CP
                                    window.location = '<?php echo Yii::app()->createAbsoluteUrl('CskhDichVuVfilm/tracuuthuebao'); ?>';
                                }
                                else{
                                    alert("Bạn không có quyền đăng nhập vào hệ thống");
                                }
                            }
                        }); // end ajax call
//                        $.ajax({
//                            url: '<?php //echo Yii::app()->createAbsoluteUrl('CskhDichVuVfilm/loginProcess') ?>//',
//                            type: 'GET',
//                            data: { type: "CheckUser", token: ssodata.Token },
//                            success: function(data) {
//                                console.log('',data);
//                            },
//                            error: function(e) {
//                                //called when there is an error
//                                //console.log(e.message);
//                            }
//                        });
                    } else {
                        // user needs to logon to SSO service
                        window.location = logonPage;
                    }
                    // tell jQuery to use JSONP
                }, 'jsonp');
        });
    </script>


</form>
</body>
</html>