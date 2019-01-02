<?php

require_once 'functions/ConfigClass.php';

echo 'Starting....';

$order = mysql_query("delete FROM orders where STR_TO_DATE(msgdate, '%Y-%m-%d') < (NOW() - INTERVAL 3 MONTH)");

echo 'Deleted.';