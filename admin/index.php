<?php
require_once('../conf.php');

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
		<input type='button' value='Pedidos' onclick="pedidos()" class='btn'/><br><br>
		<input type='button' value='Produtos' onclick="produtos()" class='btn'/><br><br>
		<input type='button' value='Cupons' onclick="cupons()" class='btn'/><br><br>
		<input type='button' value='Relatório' onclick="relatorio()" class='btn'/><br><br>
		<input type='button' value='Logout' onclick="logout()" class='btn'/><br><br>
		<div id='loading'></div>
	</div>
	<div id='load'></div>
<?php
	include('footer.php');
}
?>