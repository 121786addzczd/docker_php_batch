<?php
// http://localhost/sample_post.php
// echo "通信方式は" . $_SERVER['REQUEST_METHOD'] . "です。";
// echo "user_idは" . $_POST['user_id'] . "です。";
// echo "passwordは" . $_POST['password'] . "です。";
var_dump($_POST);
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
    <form action="sample_post.php" method="post" onsubmit="return cancelsubmit()";>
        ユーザーID:<input type="text" name="user_id" /></input><br/>
        <div id="fieldPassword">
            パスワード:<input type="password" name="password" id="js-Password" /></input>
            <span id="buttonEye" class="fa fa-eye" onclick="pushHideButton()"></span>
        </div><br/>
        お問い合わせ:<textarea name="question" cols="40" rows="5"></textarea><br/>
        <input type="radio" name="yes_no" value="yes">はい
        <input type="radio" name="yes_no" value="no">いいえ<br/>
        都道府県:
        <select name="pref" id="js-select-pref">
            <option value="" selected>選択してください</option>
            <option value="1">北海道</option>
            <option value="2">青森県</option>
            <option value="3">岩手県</option>
            <option value="4">宮城県</option>
            <option value="5">秋田県</option>
            <option value="6">山形県</option>
            <option value="7">福島県</option>
            <option value="8">茨城県</option>
            <option value="9">栃木県</option>
            <option value="10">群馬県</option>
            <option value="11">埼玉県</option>
            <option value="12">千葉県</option>
            <option value="13">東京都</option>
            <option value="14">神奈川県</option>
            <option value="15">新潟県</option>
            <option value="16">富山県</option>
            <option value="17">石川県</option>
            <option value="18">福井県</option>
            <option value="19">山梨県</option>
            <option value="20">長野県</option>
            <option value="21">岐阜県</option>
            <option value="22">静岡県</option>
            <option value="23">愛知県</option>
            <option value="24">三重県</option>
            <option value="25">滋賀県</option>
            <option value="26">京都府</option>
            <option value="27">大阪府</option>
            <option value="28">兵庫県</option>
            <option value="29">奈良県</option>
            <option value="30">和歌山県</option>
            <option value="31">鳥取県</option>
            <option value="32">島根県</option>
            <option value="33">岡山県</option>
            <option value="34">広島県</option>
            <option value="35">山口県</option>
            <option value="36">徳島県</option>
            <option value="37">香川県</option>
            <option value="38">愛媛県</option>
            <option value="39">高知県</option>
            <option value="40">福岡県</option>
            <option value="41">佐賀県</option>
            <option value="42">長崎県</option>
            <option value="43">熊本県</option>
            <option value="44">大分県</option>
            <option value="45">宮崎県</option>
            <option value="46">鹿児島県</option>
            <option value="47">沖縄県</option>
        </select><br/>
        好きなフルーツ:
        <input type="checkbox" name="fruits[]" value="apple">リンゴ
        <input type="checkbox" name="fruits[]" value="banana">バナナ
        <input type="checkbox" name="fruits[]" value="orange">みかん
        <br/>
        <input type="hidden" name="hidden_param" value="隠しパラメータaaa">
        <input type="submit" onclick="onButtonClick();" value="送信"/>
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

        function cancelsubmit() {
            if(document.getElementById("js-select-pref").value === "") {
                alert("都道府県を選択してください。");
                return false;
            }
        }

    </script>
</body>

</html>