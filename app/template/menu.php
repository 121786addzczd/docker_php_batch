<?php declare(strict_types=1); ?>
<div id="menu">
    <h3>メニュー</h3>
    <?php if (mb_strpos($_SERVER['REQUEST_URI'], 'search.php') !== false) { ?>
        <div class="sub_menu">社員検索</div>
        <div class="sub_menu"><a href="input.php">社員登録</a></div>
    <?php } else { ?>
        <div class="sub_menu"><a href="search.php">社員検索</a></div>
        <div class="sub_menu">社員登録</div>
    <?php } ?>
</div>