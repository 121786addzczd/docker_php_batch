<?php declare(strict_types=1); ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
<title><?php echo $title; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<link rel="stylesheet" type="text/css" href="/css/style.css" />
</head>
<body>

<div id="header">
  <h1>
    <div class="clearfix">
      <div class="f1">
        社員管理システム
      </div>
      <?php if (isset($_SESSION['name'])) { ?>
        <div class="fr">
          <span class="font14">
            <?php echo "ようこそ" . htmlspecialchars($_SESSION['name']) . " さん"; ?>
            <a class="text_red" href="logout.php">ログアウト</a>
          </span>
        </div>
      <?php } ?>
    </div>
  </h1>
</div>

<?php if (isset($_SESSION['id'])) : ?>
<script>
//10分間操作がなければログアウトさせる
(function(){
    const sec = 600;
    const events = ['keydown', 'mousemove', 'click'];
    let timeoutId;

    // タイマー設定
    function setTimer() {
        timeoutId = setTimeout(logout, sec * 1000);
    }
    function resetTimer() {
        clearTimeout(timeoutId);
        setTimer();
    }

    // イベント設定
    function setEvents(func) {
        let len = events.length;
        while (len--) {
            addEventListener(events[len], func, false);
        }
    }

    // ログアウト
    function logout() {
        location.href = '<?php echo '/timeout.php'; ?>'; // ログアウト処理用URLに飛ばす
    }

    setTimer();
    setEvents(resetTimer);
})();
</script>
<?php endif ?>