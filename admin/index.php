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

}elseif ($_POST['cupons']) {
	include('cupons.php');
	die;

}elseif ($_POST['logout']) {
	unset($_SESSION['login_adm']);

}elseif (isSet($_POST['pass'])) {
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
<form id='menu'>
	Área Administrativa<br><br>
	<input type='text' id='user' name='user' placeholder='Usuário' /><br><br>
	<input type='password' id='pass' name='pass' placeholder='Senha' value='<?=$pass?>' /><br><br>
	<input type='submit' id='submit' value='Entrar' class='btn'/><br><br>
	<div id='loading'></div>
</form>

<script>
$("#menu").submit(function() {
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
	include('footer.php');

}else{ #LOGADO / PAINEL ADMIN
	include('header.php');
?>
	<div id='menu'>
		<input type='button' value='Cupons' onmouseup="cupons()" class='btn'/><br><br>
		<input type='button' value='Logout' onmouseup="logout()" class='btn'/><br><br>
		<div id='loading'></div>
	</div>
<script>
function logout() { 
	$('#menu').html("<img src='loading.gif'/>");
	$.post('', {logout:1}, function(r) { 
		window.location.replace('');
	})
}
function cupons() { 
	$('#menu').html("<img src='loading.gif'/>");
	$('#menu').load('', {cupons:1});
}
function voltar() { 
	$('#menu').html("<img src='loading.gif'/>");
	window.location.replace('');
}
$(document).on('submit', "#cupom", function(r) {
	$.post('', $(this).serialize(), function(r) {
		console.log(r);
		if (r==1) {
			$("#cupom .btn").val('Gerado').addClass('green').prop('disabled', true);
			voltar();
		}
		else
			alert(r);
	});
	return false;
});
</script>
<?php
	include('footer.php');
}
?>