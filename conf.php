<?php
#phpinfo(); die;
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('memory_limit','256M');
set_time_limit(60);
header("Content-type: text/html; charset=utf-8");
date_default_timezone_set('America/Sao_Paulo');
session_start();

$db = new mysqli('localhost', 'root', '') or die(mysqli_connect_error());
$db->select_db("rickstore") or die(mysqli_error($db));

function user_ip() {
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}
?>