<?php
require_once('../conf.php');
#var_dump($_SESSION);
#var_dump($_POST);
?>
<?php
if ($_POST['gerar_cupom']) {
	if (!$_POST['tipo'] || !$_POST['cliente']) die('Selecione tipo e cliente.');
	$codigo = substr(strtoupper(md5(uniqid())), 0, 8);
	$sql = "INSERT INTO cupom (id_cliente, tipo, codigo) VALUES ($_POST[cliente], $_POST[tipo], '$codigo')";
	#die($sql);
	if($db->query($sql)) die("1");
	else die('Erro, gere novamente.');
}
if ($_POST['cupons']) {
	include('cupons.php');
	die;
}
if ($_POST['produtos']) {
	include('produtos.php');
	die;
}
if ($_POST['novo_produto']) {
	var_dump($_POST);
	var_dump($_FILES);
	$img = getimagesize($_FILES["img"]["tmp_name"]) or die('1');
	$w = $img[0];
	$h = $img[1];
	$tipo = $img[mime];
	$permitidos = array('image/jpg', 'image/jpeg', 'image/png');
	if (!in_array($tipo, $permitidos)) die('1');
	var_dump($_FILES['img']['size']);###
	die;
}

if ($_POST['logout']) {
	unset($_SESSION['login_adm']);
}
if (isSet($_POST['pass'])) {
	$sql = "SELECT id, login FROM admin WHERE login='{$_POST['user']}' AND senha=MD5('{$_POST['pass']}')";
	$r = $db->query($sql) or die(mysqli_error($db));
	$a = $r->fetch_assoc();
	if ($r->num_rows) {
		$_SESSION['login_adm'] = $_POST['user'];
		$_SESSION['id_adm'] = $a['id'];
		die("1");
	}else
		die("0");
}

if (!$_SESSION['login_adm']) { #TELA DE LOGIN
	include('header.php');
?>
<form id='login'>
	Área Administrativa<br><br>
	<input type='text' id='user' name='user' placeholder='Usuário' /><br><br>
	<input type='password' id='pass' name='pass' placeholder='Senha' value='<?=$pass?>' /><br><br>
	<input type='submit' id='submit' value='Entrar' class='btn'/><br><br>
	<div id='loading'></div>
</form>

<script src='../jquery-3.3.1.min.js'></script>
<script>
$("#login").submit(function() {
	$('#loading').html("<img src='loading.gif'/>");
	$.post('', $(this).serialize(), function(r) {
		if (r==1)
			window.location.replace('');
		else {
			$('#loading').html('');
			alert('Login ou Senha incorreto(s)!');
		}
	});
	return false;
});
</script>
<?php
}else{ #LOGADO / PAINEL ADMIN
	include('header.php');
?>
	<div id='menu'>
		<input type='button' value='Produtos' onclick="produtos()" class='btn'/><br><br>
		<input type='button' value='Cupons' onclick="cupons()" class='btn'/><br><br>
		<input type='button' value='Logout' onclick="logout()" class='btn'/><br><br>
		<div id='loading'></div>
	</div>
	<div id='load'></div>
<?php
	include('footer.php');
}
?>