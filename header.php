<?php
require_once('conf.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta charset="UTF-8">
	<title>Rickstore <?=$page_name?></title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div id='wrapper'>
		<div id='header'>
			<form id='form-busca'>
				<input id='busca' type='text' placeholder="Buscar produtos" maxlength="200" />
				<span class='recentes'></span>
				<img class='buscar' src='img/search.png' onclick='$("#form-busca").submit()'/>
				<input class='hide' type='submit'/>
			</form>

		<?php if ($_SESSION['login']) { ?>
			<div id='menu'>
				<a href='#'>Minha Conta</a>
				<a href='#'>Carrinho</a>
				<a id='logout' href='#'>Sair</a>
			</div>
		<?php }else{ ?>
			<form id='form-login'>
				<span class='aviso'><?=$_GET['aviso']?></span>
				<input id='login' type='text' placeholder='Login' maxlength="50" value='admin'/>
				<input id='senha' type='password' placeholder='Senha' maxlength="50" value='123'/>
				<input class='btn' type='submit' value='Entrar'/>
				<img class='loading' src='img/loading.gif'/>
			</form>
		<?php } ?>
		</div>