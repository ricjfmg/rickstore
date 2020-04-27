<?php
require_once('header.php');
?>

<div id='grid'>
	<form id='form-cadastro'>
		<input type='hidden' name='cadastro' value='1'/>
		<div class='linha'>
			<h2>Cadastro de Cliente</h2>
		</div>
		<label class='linha'>
			Login
			<input name='login' placeholder='Login' type='text' id='c-login'
				readonly onfocus="this.removeAttribute('readonly');"/>
		</label>
		<label class='linha'>
			Senha
			<input name='senha' placeholder='Senha' type='password' id='c-senha'			
				readonly onfocus="this.removeAttribute('readonly');"/>
		</label>
		<label class='linha'>
			Nome
			<input name='nome' placeholder='Nome' type='text' readonly onfocus="this.removeAttribute('readonly');"/>
		</label>
		<label class='linha'>
			E-Mail
			<input name='email' placeholder='E-Mail' type='text' readonly onfocus="this.removeAttribute('readonly');"/>
		</label>
		<div class='linha'>
			<input type='submit' value='Cadastrar' class='btn green'/>
		</div>
	</form>
</div>

<?php
require_once('footer.php');
?>