<?php
require_once('header.php');

$_POST['carrinho'] = explode('|', $_POST['carrinho']);
foreach($_POST['carrinho'] as $c) {
	$c = explode('x', $c);
	$carrinho[$c[0]] = $c[1];
	$ids[] = $c[0];
}
$ids = implode(',', $ids);

if ($ids) {
	$sql = "SELECT id, nome, valor FROM produto WHERE id IN ($ids) ORDER BY field(id,$ids)";
	$r = $db->query($sql) or die(mysqli_error($db));
	$rows = $r->fetch_all(MYSQLI_ASSOC);
	if (!$rows) $txt = "<br><center class='vazio'>Sem produtos no carrinho.</center>";
}else $txt = "<br><center class='vazio'>Sem produtos no carrinho.</center>";
?>

	<div id='grid'>
		<div id='carrinho'>
<?php
if ($txt) echo $txt;
else {
?>
		<span class='titulo'>
			Seu carrinho de compras
			<input class='salvar btn blue' value='Salvar' type="button" />
			<input class='limpar btn red' value='Esvaziar' type="button" />
		</span>
		<br><br>
	<?php
	foreach($rows as $r) {
		$valor = number_format($r[valor], 2, ',', '.');
		$qtd = $carrinho[$r[id]];
		echo "
		<div class='linha p-$r[id]'>
			<label for='q-$r[id]' class='nome'>$r[nome]</label>
			<input class='qtd' type='number' value='$qtd' min=0 max=999 required data-id='$r[id]'/>
			&times; R$ <span class='valor'>$valor</span>
			<input class='remove btn' data-id='$r[id]' data-nome='$r[nome]' type='button' value='Remover'/>
		</div>";
	}
	if ($_SESSION['id_cliente'])
		$proximo = "
		<input class='btn green proximo' type='button' value='Próximo Passo'/>";
	else
		$proximo = "
		<center>É necessário estar logado para realizar o pedido.
			<input class='btn blue cadastre-se' type='button' value='Cadastre-se'/>
		</center>";
	echo "
		<div class='linha'>
			$proximo
		</div>";
}
	?>
		</div>
	</div>
<?php
require_once('footer.php');
?>
<script>
carrega_carrinho();
</script>