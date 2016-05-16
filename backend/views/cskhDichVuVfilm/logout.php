<!DOCTYPE html>
<html>
<head>
</head>
<body>

<form method="post" name="postForm">
    <script type="text/javascript">
        $(function() {
        // log user out from SSO service
            $.get('http//10.211.0.250:8080/SSO/SSOService.svc/user/Logout?callback=?', {},
                function(ssodata) {
                    // client's no longer logged in, redirect to logon page
                    // giá trị trả về dạng json
                    //?( {"LogoutResult":true} );
                    <?php
                        unset(Yii::app()->session['Username']);
                        unset(Yii::app()->session['Role']);
                    ?>
                    document.location = 'http//10.211.0.250:8080/SSO/login.aspx?keyid=10020&URL=<?php echo Yii::app()->createAbsoluteUrl('CskhDichVuVfilm/'); ?>';
                }, 'jsonp');
        });
    </script>


</form>
</body>
</html>