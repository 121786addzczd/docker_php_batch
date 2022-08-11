<?php
// http://localhost/sample_get.php?test_param1=aaa&test_param2=bbb
echo "通信方式は" . $_SERVER['REQUEST_METHOD'] . "です。";
echo "test_param1は" . $_GET['test_param1'] . "です。";
echo "test_param2は" . $_GET['test_param2'] . "です。";