<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
ini_set('memory_limit','256M');
ini_set('allow_url_fopen', 'On');
ini_set("default_socket_timeout", '300');
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

function ws($url, $dados) {
	$token = $_SESSION['token'];
	if ($token) $authorization = "Authorization: ".$token;
	$dados = json_encode($dados);
	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_HTTPHEADER => array('Content-Type:application/json', $authorization),
	    CURLOPT_POST => 1,
	    CURLOPT_RETURNTRANSFER => 1,
	    CURLOPT_SSL_VERIFYPEER => 0,
	    CURLOPT_URL => $url,
	    CURLOPT_POSTFIELDS => $dados
	));
	$r = curl_exec($ch);
	$e = curl_error($ch); if ($e) dumpa($e);
	$r = json_decode($r, true);
	curl_close($ch);
	return $r;
}

function number_format2($valor, $casas, $simb_dec, $simb_mil) {
	$valor = explode('.', (string)$valor);
	$v1 = str_split(strrev($valor[0]), 3);
	$v1 = strrev(implode($simb_mil, $v1));
	$v2 = substr($valor[1], 0, $casas);
	$v2 = str_pad($v2, $casas, '0', STR_PAD_RIGHT);
	$valor = $v1.$simb_dec.$v2;
	return $valor;
}

function dumpa($v) {
	echo '<pre>'; var_dump($v); echo '</pre>';
}
?>