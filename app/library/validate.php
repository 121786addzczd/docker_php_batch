<?php
declare(strict_types=1);

/**
 * 必須チェック
 *
 * @param string $str
 * @return bool true:入力値アリ／false:未入力
 */
function validateRequired(string $str): bool
{
    if ($str === '') {
        return false;
    }
    return true;
}

/**
 * 数値チェック
 *
 * @param string $str
 * @return bool true:数値／false:数値以外
 */
function validateNumeric(string $str): bool
{
    if (!preg_match('/\A[0-9]+\z/', $str)) {
        return false;
    }
    return true;
}

/**
 * 最大文字数チェック
 *
 * @param string $str
 * @param int $length 指定文字数
 * @return bool true:指定文字数以内／false:指定文字数を超える
 */
function validateMaxLength(string $str, int $length): bool
{
    return mb_strlen($str, 'UTF-8') <= $length;
}

/**
 * 指定文字数チェック
 *
 * @param string $str
 * @param int $minLength 最小文字数
 * @param int $maxLength 最大文字数
 * @return bool true:指定文字数に収まる／false:指定文字数に収まらない
 */
function validateBetweenLength(string $str, int $minLength, int $maxLength): bool
{
    $length = mb_strlen($str, 'UTF-8');
    return ($length >= $minLength && $length <= $maxLength);
}

/**
 * 社員番号チェック
 * 6桁の数値
 *
 * @param string $str
 * @return bool true:社員番号として正しい／false:社員番号として正しくない
 */
function validateId(string $str): bool
{
    if (!validateNumeric($str) || !validateBetweenLength($str, 6, 6)) {
        return false;
    }
    return true;
}

/**
 * 日付(yyyy-mm-dd)チェック
 *
 * @param string $str
 * @return bool true:日付として正しい／false:日付として正しくない
 */
function validateDate(string $str): bool
{
    if (!preg_match('/\A[0-9]{4}-[0-9]{2}-[0-9]{2}\z/', $str)) {
        return false;
    } else {
        list($year, $month, $day) = explode('-', $str);
        if (!checkdate((int)$month, (int)$day, (int)$year)) {
            return false;
        }
    }
    return true;
}

/**
 * 電話番号チェック
 * 15桁以内の数値
 *
 * @param string $str
 * @return bool true:電話番号として正しい／false:電話番号として正しくない
 */
function validateTel(string $str): bool
{
    if (!validateNumeric($str) || !validateMaxLength($str, 15)) {
        return false;
    }
    return true;
}

/**
 * メールアドレスチェック
 *
 * @param string $str
 * @return bool true:メールアドレスとして正しい／false:メールアドレスとして正しくない
 */
function validateMailAddress(string $str): bool
{
    if (!preg_match(
        '/\A([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}\z/iD', 
        $str)) {
        return false;
    }
    return true;
}

/**
 * 性別チェック
 *
 * @param string $str
 * @return bool true:性別として正しい／false:性別として正しくない
 */
function validateGender(string $str): bool
{
    if (!in_array($str, GENDER_LISTS)) {
        return false;
    }
    return true;
}

/**
 * 部署チェック
 *
 * @param string $str
 * @return bool true:部署として正しい／false:部署として正しくない
 */
function validateOrganization(string $str): bool
{
    if (!in_array($str, ORGANIZATION_LISTS)) {
        return false;
    }
    return true;
}

/**
 * 役職チェック
 *
 * @param string $str
 * @return bool true:役職として正しい／false:役職として正しくない
 */
function validatePost(string $str): bool
{
    if (!in_array($str, POST_LISTS)) {
        return false;
    }
    return true;
}
