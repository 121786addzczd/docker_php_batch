<?php
declare(strict_types=1);

require_once(dirname(__DIR__) . '/library/common.php');

session_start();

//ログアウト処理

//セッションの削除
$_SESSION = [];

//Cookieの削除
setcookie('PHPSESSID', '', time() - 1800, '/');

//セッションの破棄
session_destroy();

$errorMessage = '一定時間操作がなかったためタイムアウトしました';

//各入力項目表示
$title = 'タイムアウト';
require_once(TEMPLATE_DIR . 'timeout.php');
