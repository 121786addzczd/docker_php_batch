<?php
declare(strict_types=1);

$genderLists = [
    "男性",
    "女性",
];
$organizationLists = [
    "営業部",
    "人事部",
    "総務部",
    "システム開発1部",
    "システム開発2部",
    "システム開発3部",
    "システム開発4部",
    "システム開発5部",
];
$postLists = [
    "部長",
    "次長",
    "課長",
    "一般",
];

//各入力項目の変数
$id = '';
$name = '';
$nameKana = '';
$birthday = '';
$gender = '';
$organization = '';
$post = '';
$startDate = '';
$tel = '';
$mailAddress = '';
$errorMessage = '';
$successMessage = '';
$isEdit = false;
$isSave = false;

//データベース接続
$DB_USER = 'docker_php_batch_user';
$DB_PASSWORD = 'docker_php_batch_pass';
$DB_HOST = 'db';
$DB = "docker_php_batch_db";
$pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB};charset=utf8", $DB_USER, $DB_PASSWORD);

//POST通信、かつ登録ボタン押下
if (mb_strtolower($_SERVER['REQUEST_METHOD']) === 'post') {
    // var_dump($_POST);
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $nameKana = isset($_POST['name_kana']) ? $_POST['name_kana'] : '';
    $birthday = isset($_POST['birthday']) ? $_POST['birthday'] : '';
    $gender = isset($_POST['gender']) ? $_POST['gender'] : '';
    $organization = isset($_POST['organization']) ? $_POST['organization'] : '';
    $post = isset($_POST['post']) ? $_POST['post'] : '';
    $startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
    $tel = isset($_POST['tel']) ? $_POST['tel'] : '';
    $mailAddress = isset($_POST['mail_address']) ? $_POST['mail_address'] : '';

    $isSave = (isset($_POST['save']) && $_POST['save'] === '1') ? true : false;

    //trueならば既存データの更新ということ
    $isEdit = (isset($_POST['edit']) && $_POST['edit'] === '1') ? true : false;

    //社員検索画面の編集ボタン押下
    if ($isEdit === true && $isSave === false) {
        //POSTされた社員番号の入力チェック
        if ($id === '') { //空白でないか
            $errorMessage .= 'エラーが発生しました。もう一度やり直してください。<br>';
        } else if (!preg_match('/\A[0-9]{6}\z/', $id)) { //6桁の数値か
            $errorMessage .= 'エラーが発生しました。もう一度やり直してください。<br>';
        } else {
            //存在する社員番号か
            $sql = "SELECT COUNT(*) AS count FROM users WHERE id = :id";
            $param = array("id" => $id);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($param);
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($count['count'] === '0') {
                $errorMessage .= 'エラーが発生しました。もう一度やり直してください。<br>';
            }
        }

        //入力チェックOK?
        if ($errorMessage === '') {
            //社員情報取得SQLの実行
            $sql = "SELECT * FROM users WHERE id = :id";
            $param = array('id' => $id);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($param);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            $id = $user['id'];
            $name = $user['name'];
            $nameKana = $user['name_kana'];
            $birthday = $user['birthday'];
            $gender = $user['gender'];
            $organization = $user['organization'];
            $post = $user['post'];
            $startDate = $user['start_date'];
            $tel = $user['tel'];
            $mailAddress = $user['mail_address'];
        } else {
            //エラー画面表示
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>エラー</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<body>

<div id="header">
  <h1>社員管理システム</h1>
</div>

<div class="clearfix">
  <div id="menu">
    <h3>メニュー</h3>
    <div class="sub_menu"><a href="./search.php">社員検索</a></div>
    <div class="sub_menu"><a href="./input.php">社員登録</a></div>
  </div>

  <div id="main">
    <div class="error_message"><?php echo $errorMessage; ?></div>
  </div>
</div>
</body>
</html>
<?php
            exit; //処理終了
        }
    }

    //登録ボタン押下
    if ($isSave === true) {
        //POSTされた社員番号の入力チェック
        if ($id === '') { //空白ではないか
            $errorMessage .= '社員番号を入力してください。<br>';
        } elseif (!preg_match('/\A[0-9]{6}\z/', $id)) { //6桁の数値か
            $errorMessage .= '社員番号を6桁の数値で入力してください。<br>';
        } else {
            //存在しない社員番号か
            $sql = "SELECT COUNT(*) AS count FROM users WHERE id = :id";
            $param = array("id" => $id);
            $stmt = $pdo->prepare($sql);
            $stmt->execute($param);
            $count = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($isEdit === false && $count['count'] >= 1) {
                //新規登録時に同一社員番号が存在したらエラー
                $errorMessage .= '登録済みの社員番号です。<br>';
            } elseif ($isEdit === false && $count['count'] === "0") {
                //更新時に同一社員番号が存在しなかったらエラー
                $errorMessage .= '存在しない社員番号です。<br>';
            }
        }

        //POSTされた社員名の入力チェック
        if ($name === '') { //空白でないか
            $errorMessage .= '社員名を入力してください。<br>';
        } else if (mb_strlen($name) > 50) { //50文字以内か
            $errorMessage .= '社員名は50文字以内で入力してください。<br>';
        }

        //POSTされた社員名カナの入力チェック
        if ($nameKana === '') { //空白でないか
            $errorMessage .= '社員名カナを入力してください。<br>';
        } else if (mb_strlen($nameKana) > 50) { //50文字以内か
            $errorMessage .= '社員名カナは50文字以内で入力してください。<br>';
        }

        //POSTされた生年月日の入力チェック
        if ($birthday === '') { //空白でないか
            $errorMessage .= '生年月日を入力してください。<br>';
        } else {
            // yyyy/mm/dd形式か
            if (!preg_match('/\A[0-9]{4}-[0-9]{2}-[0-9]{2}\z/', $birthday)) {
                $errorMessage .= '生年月日を正しく入力してください。<br>';
            } else {
                // 存在する日付か
                list($year, $month, $day) = explode('-', $birthday);
                if (!checkdate((int)$month, (int)$day, (int)$year)) {
                    $errorMessage .= '生年月日を正しく入力してください。<br>';
                }
            }
        }

        //POSTされた性別の入力チェック
        //以下のいずれかか
        //男性、女性
        if (!in_array($gender, $genderLists)) {
            $errorMessage .= '性別を選択してください。<br>';
        }

        //POSTされた部署の入力チェック
        //以下のいずれかか
        //営業部、人事部、総務部、システム開発1部、システム開発2部、システム開発3部、
        //システム開発4部、システム開発5部
        if (!in_array($organization, $organizationLists)) {
            $errorMessage .= '部署を選択してください。<br>';
        }

        //POSTされた役職の入力チェック
        //以下のいずれかか
        //部長、次長、課長、一般
        if (!in_array($post, $postLists)) {
            $errorMessage .= '役職を選択してください。<br>';
        }

        //POSTされた入社年月日の入力チェック
        if ($startDate === '') { //空白でないか
            $errorMessage .= '入社年月日を入力してください。<br>';
        } else {
            //yyyy/mm/dd形式か
            if (!preg_match('/\A[0-9]{4}-[0-9]{2}-[0-9]{2}\z/', $startDate)) {
                $errorMessage .= '入社年月日を正しく入力してください。<br>';
            } else {
                //存在する日付か
                list($year, $month, $day) = explode('-', $startDate);
                if (!checkdate((int)$month, (int)$day, (int)$year)) {
                    $errorMessage .= '入社年月日を正しく入力してください。<br>';
                }
            }
        }

        //POSTされた電話番号の入力チェック
        if ($tel === '') { //空白でないか
            $errorMessage .= '電話番号を入力してください。<br>';
        } else if (!preg_match('/\A[0-9]{1,15}\z/', $id)) { //15桁以内の数値か
            $errorMessage .= '電話番号は15桁以内の数値で入力してください。<br>';
        }

        //POSTされたメールアドレスの入力チェック
        if ($mailAddress === '') { //空白でないか
            $errorMessage .= 'メールアドレスを入力してください。<br>';
        } else if (!preg_match(
            '/\A([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}\z/iD',
            $mailAddress
        )) { //メールアドレス形式か
            $errorMessage .= 'メールアドレスを正しく入力してください。<br>';
        }

        //入力チェックOK?
        if ($errorMessage === '') {
            //トランザクション開始
            $pdo->beginTransaction();

            //新規登録？
            if ($isEdit === false) {
                //新規登録
                //社員情報登録SQLの実行
                $sql = "INSERT INTO users ( ";
                $sql .=" id, ";
                $sql .=" name, ";
                $sql .=" name_kana, ";
                $sql .=" birthday, ";
                $sql .=" gender, ";
                $sql .=" organization, ";
                $sql .=" post, ";
                $sql .=" start_date, ";
                $sql .=" tel, " ;
                $sql .=" mail_address, ";
                $sql .=" created, ";
                $sql .=" updated ";
                $sql .=") VALUES (";
                $sql .=" :id, ";
                $sql .=" :name, ";
                $sql .=" :name_kana, ";
                $sql .=" :birthday, ";
                $sql .=" :gender, ";
                $sql .=" :organization, ";
                $sql .=" :post, ";
                $sql .=" :start_date, ";
                $sql .=" :tel, " ;
                $sql .=" :mail_address, ";
                $sql .=" NOW(), "; //作成日時
                $sql .=" NOW() ";  //更新日時
                $sql .=")";

            } else {
                //更新
                //社員情報登録SQLの実行
                $sql = "UPDATE users ";
                $sql .="SET name = :name, ";
                $sql .=" name_kana = :name_kana, ";
                $sql .=" birthday = :birthday, ";
                $sql .=" gender = :gender, ";
                $sql .=" organization = :organization, ";
                $sql .=" post = :post, ";
                $sql .=" start_date = :start_date, ";
                $sql .=" tel = :tel, ";
                $sql .=" mail_address = :mail_address, ";
                $sql .=" updated = NOW() "; //更新日時
                $sql .="WHERE id = :id ";
            }

            $param = array(
                "id" => $id,
                "name" => $name,
                "name_kana" => $nameKana,
                "birthday" => $birthday,
                "gender" => $gender,
                "organization" => $organization,
                "post" => $post,
                "start_date" => $startDate,
                "tel" => $tel,
                "mail_address" => $mailAddress,
            );
            $stmt = $pdo->prepare($sql);
            $stmt->execute($param);

            //コミット
            $pdo->commit();

            $successMessage = '登録完了しました。';
            $isEdit = true;
        }
    }
}



?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>社員登録</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<body>

<div id="header">
  <h1>社員管理システム</h1>
</div>

<div class="clearfix">
  <div id="menu">
    <h3>メニュー</h3>
    <div class="sub_menu"><a href="./search.php">社員検索</a></div>
    <div class="sub_menu">社員登録</div>
  </div>

  <div id="main">
    <h3 id="title">社員登録画面</h3>

    <div id="input_area">
      <form action="input.php" method="POST">
        <p><strong>社員情報を入力してください。全て必須です。</strong></p>
        <?php //エラーメッセージを表示 ?>
        <?php if ($errorMessage !== '') { ?>
            <p class="error_message"><?php echo $errorMessage; ?></p>
        <?php } ?>

        <?php //完了メッセージを表示 ?>
        <?php if ($successMessage !== '') { ?>
            <p class="success_message"><?php echo $successMessage; ?></p>
        <?php } ?>

        <?php //各入力項目表示 ?>
        <table>
          <tbody>
            <tr>
              <td>社員番号</td>
              <td>
                <?php if ($isEdit === false) { ?>
                <!-- 新規登録 -->
                <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" />
                <?php } else { ?>
                <!-- 更新 -->
                <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" disabled/>
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>" />
                <?php }?>
            </td>
            </tr>
            <tr>
              <td>社員名</td>
              <td><input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" /></td>
            </tr>
            <tr>
              <td>社員名カナ</td>
              <td><input type="text" name="name_kana" value="<?php echo htmlspecialchars($nameKana); ?>" /></td>
            </tr>
            <tr>
              <td>生年月日</td>
              <td><input type="date" name="birthday" value="<?php echo htmlspecialchars($birthday); ?>" /></td>
            </tr>
            <tr>
              <td>性別</td>
              <td>
                <?php foreach($genderLists as $value) { ?>
                <input type="radio" name="gender" value="<?php echo $value; ?>" 
                <?php echo $gender === $value ? "checked" : ""; ?>>
                <?php echo $value; ?>
                <?php } ?>
              </td>
            </tr>
            <tr>
              <td>部署</td>
              <td>
                <select name="organization">
                <?php foreach($organizationLists as $value) { ?>
                  <option value="<?php echo $value; ?>" 
                  <?php echo $organization === $value ? "selected" : ""; ?>>
                  <?php echo $value; ?></option>
                <?php } ?>
                </select>
               </td>
             </tr>
            <tr>
              <td>役職</td>
              <td>
                <select name="post">
                <?php foreach($postLists as $value) { ?>
                  <option value="<?php echo $value; ?>" 
                  <?php echo $post === $value ? "selected" : ""; ?>>
                  <?php echo $value; ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <td>入社年月日</td>
              <td><input type="date" name="start_date" value="<?php echo htmlspecialchars($startDate); ?>" /></td>
            </tr>
            <tr>
              <td>電話番号(ハイフン無し)</td>
              <td><input type="text" name="tel" value="<?php echo htmlspecialchars($tel); ?>" /></td>
            </tr>
            <tr>
              <td>メールアドレス</td>
              <td><input type="text" name="mail_address" value="<?php echo htmlspecialchars($mailAddress); ?>" /></td>
            </tr>
          </tbody>
        </table>
        <div class="clearfix">
          <div class="input_area_right">
            <input type="hidden" name="save" value="1" />
            <input type="hidden" name="edit" value="<?php echo $isEdit === true ? '1' : ''; ?>" />
            <input type="submit" id="input_button" value="登録">
            <input type="button" id="back_button" value="戻る" onclick="location.href='search.php'; return false;">
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>
