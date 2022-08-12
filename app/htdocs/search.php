<?php
declare(strict_types=1); // 厳格な型チェックをする

//データべース接続
$DB_USER = 'docker_php_batch_user';
$DB_PASSWORD = 'docker_php_batch_pass';
$DB_HOST = 'db';
$DB = "docker_php_batch_db";
$pdo = new PDO("mysql:host={$DB_HOST};dbname={$DB};charset=utf8", $DB_USER, $DB_PASSWORD);

$id = '';
$nameKana = '';
$gender = '';
$whereSql = '';
$param = [];

//検索条件が指定されている
if (isset($_GET['id']) && isset($_GET['name_kana'])) {
    $id = $_GET['id'];
    $nameKana = $_GET['name_kana'];
    $gender = isset($_GET['gender']) ? $_GET['gender'] : '';

    // 社員番号が入力されている
    if ($id !== '') {
        // 検索条件に社員番号を追加
        $whereSql .= 'AND id = :id ';
        $param['id'] = $id;
    }

    // 社員名にカナが入力されている
    if ($nameKana !== '') {
        // 検索条件に社員名カナを追加
        $whereSql .= 'AND name_kana LIKE :name_kana ';
        $param['name_kana'] = $nameKana . '%';
    }

    // 性別が入力されている
    if ($gender !== '') {
        // 検索条件に性別を追加
        $whereSql .= 'AND gender = :gender ';
        $param['gender'] = $gender;
    }
}

//件数取得SQLの実行
$sql = "SELECT COUNT(*) AS count FROM users WHERE 1 = 1 {$whereSql}";
// $param = [];
$stmt = $pdo->prepare($sql);
$stmt->execute($param);
$count = $stmt->fetch(PDO::FETCH_ASSOC);
// var_dump($count);

//社員情報取得SQLの実行
$sql = "SELECT * FROM users WHERE 1 = 1 {$whereSql} ORDER BY id";
$stmt = $pdo->prepare($sql);
$stmt->execute($param);
// while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     var_dump($row);
// }

// ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title>社員検索</title>
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
        <div class="sub_menu">社員検索</div>
        <div class="sub_menu"><a href="input.php">社員登録</a></div>
    </div>

    <div id="main">
        <h3 id="title">社員検索画面</h3>

        <div id="search_area">
            <div id="sub_title">検索条件</div>
                <form action="search.php" method="GET">
                    <div id="form_area">
                        <div class="clearfix">
                            <div class="input_area">
                                <span class="input_label">社員番号(完全一致)</span>
                                <input type="text" name="id" value="<?php echo htmlspecialchars($id); ?>" />
                            </div>
                            <div class="input_area">
                                <span class="input_label">社員名カナ(前方一致)</span>
                                <input type="text" name="name_kana" value="<?php echo htmlspecialchars($nameKana); ?>" />
                            </div>
                            <div class="input_area"><span class="input_label">性別</span>
                                <input type="radio" name="gender" value="男性" id="gender_male" <?php echo $gender === "男性" ? "checked" : ""; ?> >
                                <label for="gender_male">男性</label>
                                <input type="radio" name="gender" value="女性" id="gender_female" <?php echo $gender === "女性" ? "checked" : ""; ?> >
                                <label for="gender_female">女性</label>
                            </div>
                        </div>

                        <div class="clearfix">
                            <div class="input_area_right">
                                <input type="submit" id="search_button" value="検索">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <?php //件数表示 ?>
            <div id="page_area">
                <div id="page_count"><?php echo htmlspecialchars($count['count']); ?>件ヒットしました</div>
            </div>

            <div id="search_result">
                <table>
                    <thead>
                        <tr>
                            <th>社員番号</th>
                            <th>社員名</th>
                            <th>性別</th>
                            <th>部署</th>
                            <th>役職</th>
                            <th>電話番号</th>
                            <th>メールアドレス</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php //件数が1件以上 ?>
                        <?php if ($count['count'] >= 1) { ?>
                            <?php //社員情報取得結果を1行ずつ読込、終端まで繰り返し ?>
                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                <tr>
                                    <?php //社員情報の表示 ?>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?>(<?php echo htmlspecialchars($row["name_kana"]); ?>)</td>
                                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                                    <td><?php echo htmlspecialchars($row['organization']); ?></td>
                                    <td><?php echo htmlspecialchars($row['post']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tel']); ?></td>
                                    <td><?php echo htmlspecialchars($row['mail_address']); ?></td>
                                    <td class="button_area">
                                    <button class="edit_button">編集</button>
                                    <button class="delete_button">削除</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>