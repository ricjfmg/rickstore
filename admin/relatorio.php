<?php
require_once('../conf.php');

$sql = "SELECT pp.id_produto, pp.qtd, pp.valor, pp.taxas, p.nome, p.base
		FROM pedido_produto pp JOIN produto p ON p.id=pp.id_produto
		WHERE pp.id_pedido IN (SELECT id FROM pedido WHERE status > 0)";
$r = $db->query($sql) or die(mysqli_error($db));
$rows = $r->fetch_all(MYSQLI_ASSOC);

foreach ($rows as $r) {
	$produtos[$r['id_produto']]['nome'] = $r['nome'];
	$produtos[$r['id_produto']]['base'] = $r['base'];

	$produtos[$r['id_produto']]['qtd'] += $r['qtd'];
	$produtos[$r['id_produto']]['valor'] += $r['qtd'] * $r['valor'];
	$produtos[$r['id_produto']]['taxas'] += $r['qtd'] * $r['taxas'];
}
?>

<center class='titulo'>Produtos Vendidos <img id='xls' src='img/xls.png' title='Exportar para Excel'/></center>
<table id='relatorio' class='grid' border=1 cellspacing="1" cellpadding="5">
	<thead>
		<tr>
			<th>ID</th>
			<th>Produto</th>
			<th>Custo Base</th>
			<th>Qtd Vendidos</th>
			<th>Total Obtido</th>
			<th>D. Fixas (10%)</th>
			<th>M. Lucro (20%)</th>
			<th>Impostos (30%)</th>
		</tr>
	</thead>
	<tbody>
<?php
foreach($produtos as $id => $p) {
	$total += $valor = $p[valor];

	$base = $p[base];
	$taxas = $p[taxas];
	$fixa = $valor * 0.1;
	$total_lucro += $lucro = $valor * 0.2;
	$imposto = $valor * 0.3;

	$base = number_format2($base, 2, ',', '.');
	$valor = number_format2($valor, 2, ',', '.');
	$fixa = number_format2($fixa, 2, ',', '.');
	$lucro = number_format2($lucro, 2, ',', '.');
	$imposto = number_format2($imposto, 2, ',', '.');

	echo "
		<tr>
			<td>$id</td>
			<td>$p[nome]</td>
			<td><span class='remove'>R$</span>$base</td>
			<td>$p[qtd]</td>
			<td><span class='remove'>R$</span>$valor</td>
			<td><span class='remove'>R$</span>$fixa</td>
			<td bgcolor=lightblue><span class='remove'>R$</span>$lucro</td>
			<td><span class='remove'>R$</span>$imposto</td>
		</tr>";
}
$total = number_format2($total, 2, ',', '.');
$total_lucro = number_format2($total_lucro, 2, ',', '.');
?>
	</tbody>
	<tfoot>
		<tr>
			<td colspan=4>Totais</td>
			<td colspan=2>R$<?=$total?></td>
			<td colspan=2 bgcolor=lightblue>R$<?=$total_lucro?></td>
		</tr>
	</tfoot>
</table>