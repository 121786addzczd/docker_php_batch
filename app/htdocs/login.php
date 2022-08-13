<?php
declare(strict_types=1);

// 共通部分の読み込み
require_once(dirname(__DIR__) . '/library/common.php');

$loginId = '';
$password = '';
$errorMessage = '';

//POST通信
if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    //ログイン認証SQLの実行
    $loginId = isset($_POST['login_id']) ? $_POST['login_id'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $sql = "SELECT * FROM login_accounts WHERE login_id = :login_id";
    $param = ['login_id' => $loginId];
    $loginAccount = DataBase::fetch($sql, $param);

    //ログイン認証OK？
    if (empty($loginAccount['id'])) {
        $errorMessage .= 'ログインID不一致';
    } elseif (password_verify($password, $loginAccount['password']) === false) {
        $errorMessage .= 'パスワード不一致';
    }
    if ($errorMessage === '') {
        echo 'ログイン成功';
    }

    //ログイン処理

    //社員検索画面に遷移

    //エラーメッセージ表示
    //・例)ログインID、またはパスワードに誤りがあります。

}

//各入力項目表示
$title = 'ログイン';
require_once(TEMPLATE_DIR . 'login.php');