<?php declare(strict_types=1); ?>
<?php require_once(TEMPLATE_DIR . 'header.php'); ?>

<div class="clearfix">
<?php require_once(TEMPLATE_DIR . 'menu.php'); ?>

  <div id="main">
    <div class="error_message">一定時間操作がなかったためタイムアウトしました</div>
  </div>
  <a href="login.php">TOPページへ</a>
</div>
<?php require_once(TEMPLATE_DIR . 'footer.php'); ?>