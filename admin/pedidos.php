<?php
require_once('../conf.php');

if ($_POST['atualizar_pedidos']) {
	$ids = implode(',', $_POST['ids']);
	$sql = "UPDATE pedido SET status=2, data_conclusao=NOW() WHERE id IN ($ids)";
	if($db->query($sql)) die("1");
	else die('Erro, tente novamente.');
}
?>

<center class='titulo'>Pedidos
	<select id='filtro-pedidos'>
		<option value=''>Todos</option>
		<option value='0'>Pendente</option>
		<option value='1'>Enviando</option>
		<option value='2'>Concluído</option>
	</select>
</center>
<table id='pedidos' class='grid' border=1 cellspacing="1" cellpadding="5">
	<thead>
		<tr>
			<th>ID</th>
			<th>Cliente</th>
			<th>Data</th>
			<th>Valor</th>
			<th class='status'>Status</th>
			<th>Pagamento</th>
			<th>Conclusão</th>
		</tr>
	</thead>
	<tbody>
<?php
$sql = "SELECT p.id, p.data, p.data_pagamento, p.data_conclusao, p.valor, p.status, p.identificacao_pagamento, u.nome 'cliente'
		FROM pedido p JOIN cliente u ON p.id_cliente=u.id ORDER BY p.id DESC";
$r = $db->query($sql) or die(mysqli_error($db));
$rows = $r->fetch_all(MYSQLI_ASSOC);
foreach($rows as $r) {
	$chkbox = "<input class='chk' type='checkbox' data-id='$r[id]' />";

	$data = date('d/m/Y H:i:s', strtotime($r[data]));
	$valor = number_format2($r[valor], 2, ',', '.');

	$data_pag = strtotime($r[data_pagamento]);
	if ($data_pag) $data_pag = date('d/m/Y H:i:s', $data_pag)."<br>$r[identificacao_pagamento]";

	$data_fim = strtotime($r[data_conclusao]);
	if ($data_fim) $data_fim = date('d/m/Y H:i:s', $data_fim);

	switch($r[status]) {
		case 0: $status = 'Pendente'; break;
		case 1: $status = 'Enviando'; break;
		case 2: $status = 'Concluído'; break;
	}
	echo "
		<tr class='s-$r[status]'>
			<td>$chkbox $r[id]</td>
			<td>$r[cliente]</td>
			<td>$data</td>
			<td>$valor</td>
			<td class='status'>$status</td>
			<td>$data_pag</td>
			<td>$data_fim</td>
		</tr>";
}
?>
	</tbody>
</table>
<input id='concluir-pedidos' type='submit' value='Concluír Pedidos Selecionados' class='btn'/>