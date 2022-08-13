<?php declare(strict_types=1); ?>
<?php require_once(dirname(__DIR__) . '/template/header.php'); ?>

<div class="clearfix">
<?php require_once(dirname(__DIR__) . '/template/menu.php'); ?>

  <div id="main">
    <div class="error_message"><?php echo $errorMessage; ?></div>
  </div>
</div>
<?php require_once(dirname(__DIR__) . '/template/footer.php'); ?>