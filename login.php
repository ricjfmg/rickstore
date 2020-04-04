<?php
require_once('conf.php');
#var_dump($_POST); die;

if ($_POST['register']) {
	$r = $db->query("SELECT 1 FROM cliente WHERE login='{$_POST['login']}' OR email='{$_POST['email']}'");
	if ($r->num_rows) die('0');
	else {
		$sql = "INSERT INTO cliente (login, senha, email) VALUES ('{$_POST['login']}', MD5('{$_POST['senha']}'), '{$_POST['email']}')";
		$db->query($sql) or die(mysqli_error());
		echo '1';
	}

}elseif ($_POST['login']) {
	$sql = "SELECT id FROM cliente WHERE login='{$_POST['login']}' AND senha=MD5('{$_POST['senha']}')";
	#die($sql);
	$r = $db->query($sql) or die(mysql_error());
	$u = $r->fetch_assoc();
	if ($r->num_rows) {
		$_SESSION['login'] = $_POST['login'];
		$_SESSION['nome'] = $_POST['nome'];
		$_SESSION['senha'] = $_POST['senha'];
		$_SESSION['id_cliente'] = $u['id'];
	}else
		$_GET['aviso'] = 'Login ou senha incorretos';

	include("menu.php");
	unset($_GET['aviso']);

}elseif ($_POST['logout']) {
	unset($_SESSION);
	session_destroy();
	include("menu.php");

}
$db->close();
?>