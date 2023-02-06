<?php
include(__DIR__ . '/../api/api.php');

$year = htmlspecialchars($_POST['year'], ENT_QUOTES, 'UTF-8');
$month = htmlspecialchars($_POST['month'], ENT_QUOTES, 'UTF-8');
$maxDate = htmlspecialchars($_POST['date'], ENT_QUOTES, 'UTF-8');

$api = new API();
$res = $api->getEvent($year, $month, $maxDate);
echo(json_encode($res));
