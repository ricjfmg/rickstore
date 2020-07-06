<?php
require_once('conf.php');

if ($_POST['finalizar']) {

	$_POST['produtos'] = array_filter($_POST['produtos']);
	$novo_endereco = $_POST['novo_endereco'];
	$id_cliente = $_SESSION['id_cliente'];

	if (!$_POST['id_endereco']) {
		$sql = "INSERT INTO cliente_endereco (id_cliente, endereco, cidade, estado, cep, telefone)
			VALUES ($id_cliente, '$novo_endereco[endereco]',
		'$novo_endereco[cidade]', '$novo_endereco[estado]', '$novo_endereco[cep]', '$novo_endereco[telefone]')";
		$db->query($sql);
		$id_endereco = $db->insert_id;
	}else{
		$id_endereco = $_POST['id_endereco'];
	}

	if ($_POST['cupom']) {
		$sql = "SELECT id, tipo FROM cupom WHERE codigo='$_POST[cupom]'";
		$r = $db->query($sql);
		$cupom = $r->fetch_assoc();
		$tipo_desconto = $cupom['tipo'];
		$id_cupom = $cupom['id'];
	}else
		$id_cupom = 0;

	$sql = "INSERT INTO pedido (id_cliente, id_endereco, data, id_cupom)
			VALUES ($id_cliente, $id_endereco, NOW(), $id_cupom)";
	$db->query($sql) or die(mysqli_error($db));
	$id_pedido = $db->insert_id;

	foreach($_POST['produtos'] as $id_prod => $qtd) {
		$sql = "SELECT valor FROM produto WHERE id=$id_prod";
		$r = $db->query($sql);
		$prod = $r->fetch_assoc();
		$valor = $prod['valor'];
		$taxas += $taxa = $prod['valor']*0.375;
		$total += $produtos[$id_prod] = $qtd*$valor;
		$sql = "INSERT INTO pedido_produto (id_pedido, id_produto, qtd, valor, taxas)
				VALUES ($id_pedido, $id_prod, $qtd, $valor, $taxa)";
		$db->query($sql);
	}

	$total += 10; #FRETE

	if ($tipo_desconto==1)
		$desconto = 20;
	elseif ($tipo_desconto==2)
		$desconto = $total * 0.1;

	if ($desconto) {
		$total = $total - $desconto;
		$sql = "INSERT INTO pedido_produto (id_pedido, id_produto, qtd, valor)
				VALUES ($id_pedido, 0, $qtd, -$desconto)";
		$db->query($sql);

		$sql = "UPDATE cupom SET status=1 WHERE id=$id_cupom";
		$db->query($sql);
	}
	
	$sql = "UPDATE pedido SET valor=$total, taxas=$taxas WHERE id=$id_pedido";
	$db->query($sql);

	die("1");
}

if (isSet($_POST['cupom'])) {
	if (!$_POST[cupom]) die("0");
	$sql = "SELECT tipo FROM cupom
			WHERE codigo='$_POST[cupom]' AND id_cliente=$_SESSION[id_cliente] AND status=0";
	$r = $db->query($sql);
	if (!$r) die("0");

	$r = $r->fetch_assoc();
	die($r[tipo]);
}

###################################################################################################

require_once('header.php');
$id_pedido = $_POST['id_pedido'];
if (!$id_pedido) $id_pedido = array_keys($_GET)[0];

$_POST['produtos'] = $produtos = array_filter($_POST['produtos']);
if ($_POST['produtos']) {
	$ids = implode(',', array_keys($produtos));
	$sql = "SELECT id, nome, valor FROM produto WHERE id IN ($ids) ORDER BY field(id,$ids)";
	$r = $db->query($sql) or die(mysqli_error($db));
	$rows = $r->fetch_all(MYSQLI_ASSOC);
	if (!$rows) $txt = "<br><center class='vazio'>Erro 1.</center>";

}elseif ($id_pedido) {
	$sql = "SELECT id_cliente, status FROM pedido WHERE id=$id_pedido ORDER BY id DESC";
	$r = $db->query($sql) or die(mysqli_error($db));
	$r = $r->fetch_assoc();
   	$pedido_cliente = $r['id_cliente'];
   	$status = $r['status'];
   	if ($pedido_cliente <> $_SESSION[id_cliente]) $txt = "<br><center class='vazio'>Acesso Negado.</center>";

	$sql = "SELECT id_produto 'id', p.nome, pp.qtd, pp.valor, pp.taxas
			FROM pedido_produto pp LEFT JOIN produto p ON pp.id_produto=p.id
			WHERE id_pedido=$id_pedido";
	$r = $db->query($sql) or die(mysqli_error($db));
	$rows = $r->fetch_all(MYSQLI_ASSOC);
	if (!$rows) $txt = "<br><center class='vazio'>Erro 2.</center>";

}
	else $txt = "<br><center class='vazio'>Erro 3.</center>";
?>

	<div id='grid'>
		<div id='pedido'>
<?php
if ($txt) echo $txt;
else {
?>
		<span class='titulo'>
			Seu pedido
			<input class='voltar btn' value='Voltar' type="button" data-id='<?=$id_pedido?>' />
		</span>
		<br><br>
	<?php
	foreach($rows as $r) {
		if (!$r['id']) {
			$valor = number_format2(abs($r[valor]), 2, ',', '');
			$desconto_div = "
			<div class='linha' id='desconto'>
				<span class='nome'>Desconto:</span>
				-R$ <span class='valor'>$valor</span>
			</div>";
			continue;
		}
		$qtd = $id_pedido ? $r[qtd] : $produtos[$r[id]];
		$taxas += $taxa = ($r[valor] * 0.375) * $qtd;
		$total += $valor = ($r[valor] * 0.625) * $qtd;

		$valor = number_format2($valor, 2, ',', '');
		$taxa = number_format2($taxa, 2, ',', '');

		$info = "title='Taxas e Impostos: R$$taxa' style='cursor:help'";
		echo "
		<div class='linha prod' data-id='$r[id]' data-qtd='$qtd'>
			<span class='nome'>$r[nome] (&times;$qtd):</span>
			R$ <span class='valor' $info>$valor</span>
		</div>";
	}


	$total += 10;
	$total += $taxas;
	$total = number_format2($total, 2, ',', '');
	$taxas = number_format2($taxas, 2, ',', '');

	if (!$id_pedido) {
		if ($_SESSION['id_cliente'])
			$finalizar = "<button class='btn green finalizar'><b>Finalizar Pedido</b></button>";
		else
			$finalizar = "<center>É necessário estar logado para realizar o pedido.</center>";

		include('endereco.php');

		$acoes = "
		<div class='linha' id='desconto'>
			<input class='cupom' type='text' placeholder='Cupom de Desconto' maxlength='14'/>
			<input class='aplicar btn' type='button' value='Aplicar'/>
		</div>
		<div class='linha'>
			$endereco
		</div>
		<div class='linha'>
			$finalizar
		</div>";
	}else{
		if (!$status) {
			$acoes = "
				<div class='linha pedido' data-id='$id_pedido'>
					<input class='pagar btn blue' value='Pagar' type='button'/>
				</div>
			";
		}
	}

	echo "
		<div class='linha'>
			<span class='nome'>Taxas e Impostos:</span>
			R$ <span class='valor'>$taxas</span>
		</div>
		<div class='linha'>
			<span class='nome'>Taxa de Entrega:</span>
			R$ <span class='valor'>10,00</span>
		</div>
		<div class='linha'></div>
		<div class='linha total'>
			<b class='nome'>TOTAL:</b>
			R$ <b class='valor'>$total</b>
		</div>
		$desconto_div
		$acoes";
}
	?>
		</div>
	</div>
<?php
require_once('footer.php');

if (!$id_pedido) { ?>
<script>carrega_carrinho();</script>
<?php } ?>