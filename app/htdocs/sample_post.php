<?php
// http://localhost/sample_post.php
echo "通信方式は" . $_SERVER['REQUEST_METHOD'] . "です。";
echo "user_idは" . $_POST['user_id'] . "です。";
echo "passwordは" . $_POST['password'] . "です。";
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sample_post</title>
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<body>
    <form action="sample_post.php" method="post">
        ユーザーID:<input type="text" name="user_id" /></input><br/>
        <div id="fieldPassword">
            パスワード:<input type="password" name="password" id="js-Password" /></input>
            <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
        </div><br>
        <input type="submit" value="送信"/>
    </form>
    <script language="javascript">
        function pushHideButton() {
            var txtPass = document.getElementById("js-Password");
            var btnEye = document.getElementById("buttonEye");
            if (txtPass.type === "text") {
                txtPass.type = "password";
                btnEye.className = "fa fa-eye";
            } else {
                txtPass.type = "text";
                btnEye.className = "fa fa-eye-slash";
            }
        }
    </script>
</body>

</html>