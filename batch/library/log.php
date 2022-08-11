<?php

/**
 * rログを出力する
 * 
 * @param string $fileName 出力するログファイル名
 * @param string $message 出力するメッセージ
 * @return void
 */
function writeLog($fileName, $message) {
    $now = date("Y/m/d H:i:s");
    $log = "{$now} {$message}\n";

    $fp = fopen($fileName, "a");
    fwrite($fp, $log);
    fclose($fp);
}