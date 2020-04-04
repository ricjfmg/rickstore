<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
date_default_timezone_set('America/Sao_Paulo');
session_start();
?>
<?php
if ($_POST['logout']) {
	unset($_SESSION['adm']);
}

if (isset($_POST['pass'])) {
	$p1 = array('', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom')[date('N')];
	$p2 = sprintf('%02d', date('m'));
	$p3 = sprintf('%02d', date('d')+date('H'));
	if ($_POST['pass'] == $p1.$p2.$p3) {
		$_SESSION['adm'] = 'admin';
		echo 1;
	}else{
		echo 0;
	}
}elseif (!$_SESSION['adm']) { #TELA DE LOGIN
	include('header.php');
	$p1 = array('', 'seg', 'ter', 'qua', 'qui', 'sex', 'sab', 'dom')[date('N')];
	$p2 = sprintf('%02d', date('m'));
	$p3 = sprintf('%02d', date('d')+date('H'));
	$pass = "$p1$p2$p3";
?>
<form action='#' id='login' method='POST'>
	Área Administrativa<br><br>
	<!--<input type='text' id='user' name='user' placeholder='Usuário' /><br><br>-->
	<input type='text' id='pass' name='pass' placeholder='Senha' value='<?=$pass?>' /><br><br>
	<input type='submit' id='submit' value='Entrar' /><br><br>
	<div id='loading'></div>
</form>

<script>
$("#login").submit(function() {
	$('#loading').html("<img src='loading.gif'/>");
	$.post('', $(this).serialize(), function(r) {
		if (r==1)
			window.location.replace('');
		else {
			$('#loading').html('');
			alert('Senha incorreta!');
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
	<div id='login'>
		<input type='button' value='Logout' onmouseup="logout()" /><br><br>
		<div id='loading'></div>
	</div>
<script>
function logout() { 
	$('#loading').html("<img src='loading.gif'/>");
	$.post('', {logout:1}, function(r) { 
		window.location.replace('');
	})
}
</script>
<?php
	include('footer.php');
}
?>