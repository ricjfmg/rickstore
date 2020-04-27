			<form id='form-busca'>
				<input id='busca' type='text' placeholder="Buscar produtos" maxlength="200" />
				<span class='recentes'></span>
				<img class='buscar' src='img/search.png' onclick='$("#form-busca").submit()'/>
				<input class='hide' type='submit'/>
			</form>

		<?php if ($_SESSION['login']) { ?>
			<div id='menu'>
				<a class='inicio'>Início</a>
				<a class='carrinho'>Carrinho</a>
				<a class='conta'>Minha Conta</a>
				<a class='logout' href='#'>Sair</a>
			</div>
		<?php }else{ ?>
			<form id='form-login'>
				<span class='aviso'><?=$_GET['aviso']?></span>
				<input id='login' type='text' placeholder='Login' maxlength="50" value='admin'/>
				<input id='senha' type='password' placeholder='Senha' maxlength="50" value='123'/>
				<input class='btn' type='submit' value='Entrar'/>
				<input class='btn blue cadastre-se' type='button' value='Cadastre-se'/>
				<img class='loading' src='img/loading.gif'/>
			</form>
			<div id='menu'>
				<a class='inicio'>Início</a>
				<a class='carrinho'>Carrinho</a>
			</div>
		<?php } ?>