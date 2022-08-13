<?php
declare(strict_types=1);

session_start();

//ログアウト処理

//セッションの削除
$_SESSION = [];

//Cookieの削除
setcookie('PHPSESSID', '', time() - 1800, '/');

//セッションの破棄
session_destroy();

//ログイン画面に遷移
header('Location: login.php');
