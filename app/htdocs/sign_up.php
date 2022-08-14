<?php
declare(strict_types=1);

// 共通部分の読み込み
require_once(dirname(__DIR__) . '/library/common.php');

session_start();

if (isset($_SESSION['id'])) {
    header('Location: search.php');
    exit;
}


$loginId = '';
$userName = '';
$password = '';
$passwordConfirm = '';
$errorMessage = '';

//POST通信
if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    //ログイン認証SQLの実行
    $loginId = isset($_POST['sign_up_id']) ? $_POST['sign_up_id'] : '';
    $userName = isset($_POST['user_name']) ? $_POST['user_name'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $passwordConfirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';

    //POSTされたログインIDのチェック
    if (!validateRequired($loginId)) { //空白ではないか
        $errorMessage .= 'ログインIDを入力してください。<br>';
    } elseif (mb_strlen($loginId) > 50) { //50文字以内か
        $errorMessage .= 'ログインIDは50文字以内で入力してください。<br>';
    } else {
        //存在するログインIDか
        $sql = "SELECT COUNT(*) AS count FROM login_accounts WHERE login_id = :login_id";
        $param = ["login_id" => $loginId];
        $count = DataBase::fetch($sql, $param);
        if ($count['count'] >= 1) {
            $errorMessage .= "{$loginId} はすでに存在するログインIDです。<br>";
        }
    }

    //POSTされたログインIDのチェック
    if (!validateRequired($userName)) { //空白ではないか
        $errorMessage .= 'ユーザー名を入力してください。<br>';
    } elseif (mb_strlen($userName) > 50) { //50文字以内か
        $errorMessage .= 'ユーザー名は50文字以内で入力してください。<br>';
    } else {
        //存在するユーザー名か
        $sql = "SELECT COUNT(*) AS count FROM login_accounts WHERE name = :name";
        $param = ["name" => $userName];
        $count = DataBase::fetch($sql, $param);
        if ($count['count'] >= 1) {
            $errorMessage .= "{$userName} はすでに存在するユーザー名です。<br>";
        }
    }

    //POSTされたパスワードの入力チェック
    if (!validateRequired($password)) { //空白ではないか
        $errorMessage .= 'パスワードを入力してください。<br>';
    } elseif (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{6,50}+\z/i', $password)) { //半角英数字をそれぞれ1種類以上含む6文字以上50文字以下
        $errorMessage .= "パスワードは半角英数字をそれぞれ1種類以上含む6文字以上50文字以下で入力してください。<br>";
    }

    //POSTされたパスワード確認の入力チェック
    if (!validateRequired($password)) { //空白ではないか
        $errorMessage .= 'パスワード確認に値を入力してください。<br>';
    } elseif (!preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{6,50}+\z/i', $password)) { //半角英数字をそれぞれ1種類以上含む6文字以上50文字以下
        $errorMessage .= "パスワードは半角英数字をそれぞれ1種類以上含む6文字以上50文字以下で入力してください。<br>";
    }

    //POSTされたパスワー確認がパスワードと同じかチェック
    if (!$password === $passwordConfirm) {
        $errorMessage .= "入力したパスワードが確認用と一致しません";
    }

    if ($errorMessage === '') {

        DataBase::beginTransaction();

        //社員情報登録SQLの実行
        $sql = "INSERT INTO login_accounts ( ";
        $sql .=" login_id, ";
        $sql .=" password, ";
        $sql .=" name, ";
        $sql .=" created, ";
        $sql .=" updated ";
        $sql .=") VALUES (";
        $sql .=" :login_id, ";
        $sql .=" :password, ";
        $sql .=" :name, ";
        $sql .=" NOW(), "; //作成日時
        $sql .=" NOW() ";  //更新日時
        $sql .=")";
        $param = array(
            "login_id" => $loginId,
            "name" => $userName,
            "password" => password_hash($password, PASSWORD_DEFAULT)
        );
        DataBase::execute($sql, $param);

        //コミット
        DataBase::commit();

        $successMessage = '登録完了しました。';
        $sql = "SELECT * FROM login_accounts WHERE login_id = :login_id";
        $param = ['login_id' => $loginId];
        $loginAccount = DataBase::fetch($sql, $param);

        session_regenerate_id(true);
        $_SESSION['id'] = $loginAccount['id'];
        $_SESSION['login_id'] = $loginAccount['login_id'];
        $_SESSION['name'] = $loginAccount['name'];
        header('Location: search.php');
        exit;
    }

}

//各入力項目表示
$title = 'ログインユーザー登録';
require_once(TEMPLATE_DIR . 'sign_up.php');
