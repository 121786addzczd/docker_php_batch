<?php declare(strict_types=1); ?>
<?php require_once(TEMPLATE_DIR . 'header.php'); ?>

<div class="clearfix">
    <?php require_once(TEMPLATE_DIR . 'menu.php'); ?>

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

            <?php //エラーメッセージを表示 ?>
            <?php if ($errorMessage !== '') { ?>
                <p class="error_message"><?php echo $errorMessage; ?></p>
            <?php } ?>

            <?php //完了メッセージを表示 ?>
            <?php if ($successMessage !== '') { ?>
                <p class="success_message"><?php echo $successMessage; ?></p>
            <?php } ?>

            <?php //件数表示 ?>
            <div id="page_area">
                <div id="page_count"><?php echo htmlspecialchars($count); ?>件ヒットしました</div>
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
                        <?php if ($count >= 1) { ?>
                            <?php //社員情報取得結果を1行ずつ読込、終端まで繰り返し ?>
                            <?php foreach ($data as $row) { ?>
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
                                    <button class="edit_button" onclick="editUser(<?php echo htmlspecialchars($row['id']); ?>);">編集</button>
                                    <button class="delete_button" onclick="deleteUser(<?php echo htmlspecialchars($row['id']); ?>);">削除</button>
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

<form action="input.php" name="edit_form" method="POST">
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="edit" value="1">
</form>

<form action="search.php" name="delete_form" method="POST">
    <input type="hidden" name="id" value="" />
    <input type="hidden" name="delete" value="1">
</form>


<script>
function editUser(id) {
    document.edit_form.id.value = id;
    document.edit_form.submit();
}

//JavaScriptでform内のhidden項目[id]に社員情報をセットしてsubmitする
function deleteUser(id) {
    //削除確認ダイアログ表示
    if (!window.confirm(`社員番号${id}を削除してもよろしいですか？`)) {
        //キャンセルが押されたら処理終了
        return false;
    }
    //OKが押されたら社員番号をhidden項目[id]に社員番号をセットしてsubmit
    document.delete_form.id.value = id;
    document.delete_form.submit();
}
</script>
<?php require_once(TEMPLATE_DIR . 'footer.php'); ?>
