<?php
require_once('conf.php');
if (!$_SESSION['id_cliente']) header('Location: index.php');

if ($_POST['token']) { //COMPRAR
	$url = 'https://cartao.davesmartins.com.br/compra';
	$_POST['validade'] = explode('/', $_POST['validade']);
	$_POST['validade'] = $_POST['validade'][1].$_POST['validade'][0];
	$r = ws($url, $_POST);
	if ($r['status'] == 'APROVADO') {
		$sql = "UPDATE pedido SET status=1, data_pagamento=NOW(), identificacao_pagamento='$r[identificacao]'
				WHERE id=$_POST[id_pedido]";
		$db->query($sql);

		$sql = "SELECT id_produto, qtd FROM pedido_produto WHERE id_pedido=$_POST[id_pedido]";
		$r = $db->query($sql) or die(mysqli_error($db));
		$prods = $r->fetch_all(MYSQLI_ASSOC);
		foreach ($prods as $p) {
			$sql = "UPDATE produto SET qtd = qtd - $p[qtd] WHERE id = $p[id_produto]";
			$db->query($sql) or die(mysqli_error($db));
		}
		die('1');
	}
	die;
}

require_once('header.php');
$id_pedido = $_POST['id_pedido'];
if (!$id_pedido) $id_pedido = array_keys($_GET)[0];

$sql = "SELECT id_cliente, id_endereco, data, status, valor, id_cupom FROM pedido WHERE id=$id_pedido";
$r = $db->query($sql);
$p = $r->fetch_assoc();
?>

	<div id='grid'>
		<form id='form-pagamento'>

<?php 
if ($p[id_cliente] <> $_SESSION[id_cliente]) die("<br><center class='vazio'>Acesso Negado.</center></div></div>");
?>
		 	<span class='titulo'>Efetuar Pagamento</span>
			<br><br>
<?php
$data = date('d/m/Y H:i:s', strtotime($p[data]));
$valor = number_format2($p[valor], 2, ',', '.');

echo "
			<div class='linha' data-id='$p[id]'>
";

if ($_SESSION['token']) {
	$tempo = strtotime(date('Y-m-d H:i:s')) - strtotime($_SESSION['token_criacao']);
	if ($tempo/60 > 14.5) {
		$novo = 1;
	}
}else $novo = 1;

$txt = "(novo token será gerado após 15min)";
if ($novo) {
	$url = 'https://cartao.davesmartins.com.br/auth';
	$dados = array('login' => 'ricardo', 'senha' => 'R1c@rdo');
	$r = ws($url, $dados);
	$dataCriacao = str_replace(' - ', ' ', $r['dataCriacao']);
	$dataCriacao = strtotime(str_replace('/', '-', $dataCriacao));
	$dataCriacao = date('Y-m-d H:i:s', $dataCriacao);
	$_SESSION['token'] = $r['token'];
	$_SESSION['token_criacao'] = $dataCriacao;
	$txt = "<b>(novo token foi gerado agora!)</b>";
}
#dumpa($_SESSION);
$token_criacao = date('d/m/Y H:i:s', strtotime($_SESSION['token_criacao']));
$cnpj = '48013728000184';
$nomeEmpresa = 'RickStore LTDA';
$nomeCliente = $_SESSION['nome'];
$numeroCartao = '5555666677778884';
$codigoVerificacao = '123';
$validade = '12/2022';
?>
				<small>
					<input name='id_pedido' value='<?=$id_pedido?>' type='hidden'/>
					<input name='cnpj' value='<?=$cnpj?>' type='hidden'/>
					<input name='nomeEmpresa' value='<?=$nomeEmpresa?>' type='hidden'/>
					<input name='nomeCliente' value='<?=$nomeCliente?>' type='hidden'/>
					Token: <input name='token' value='<?=$_SESSION['token']?>' readonly/>
					&nbsp;&nbsp;&nbsp;
					Gerado: <input value='<?=$token_criacao?>' disabled size=17 />
					<?=$txt?>
				</small>
			</div>
			<div class='linha'>
				<small>Cliente: <?=$nomeCliente?> | Pedido dia: <?=$data?></small><br>
				Valor: R$<b><?=$valor?></b> | Parcelar em
				<input name='qtdeParcelas' type='number' value=1 min=1 max=6 style='width:40px'/> vezes
				<input name='valor' value='<?=$p[valor]?>' type='hidden'/>
			</div>
			<div class='linha cartao'>
				N° Cartão: <input name='numeroCartao' value='<?=$numeroCartao?>' style='width:142px' required/>
				CVC: <input name='codigoVerificacao' value='<?=$codigoVerificacao?>' style='width:42px' required/>
				Val.: <input name='validade' value='<?=$validade?>' style='width:68px'/>
			</div>
			<div class='linha'>
				<input type='submit' class='btn green' value='Concluir'/>
			</div>

		</form>
	</div>

<?php
require_once('footer.php');
?>