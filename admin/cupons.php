<?php
require_once('../conf.php');

if ($_POST['gerar_cupom']) {
	if (!$_POST['tipo'] || !$_POST['cliente']) die('Selecione tipo e cliente.');
	$codigo = substr(strtoupper(md5(uniqid())), 0, 8);
	$sql = "INSERT INTO cupom (id_cliente, tipo, codigo) VALUES ($_POST[cliente], $_POST[tipo], '$codigo')";
	if($db->query($sql)) die("1");
	else die('Erro, gere novamente.');
}
?>

<form id='form-cupom'>
	<center class='titulo'>Gerar Cupom</center>
	<select class='tipo' name='tipo'>
		<option value='' disabled selected>Tipo</option>
		<option value='1'>Fixo (R$20)</option>
		<option value='2'>Perc. (10%)</option>
	</select>
	<br>
	<select class='cliente' name='cliente'>
		<option value='' disabled selected>Cliente</option>
<?php
	$sql = "SELECT id, nome FROM cliente";
	$r = $db->query($sql) or die(mysqli_error($db));
	$rows = $r->fetch_all(MYSQLI_ASSOC);
	foreach ($rows as $r) echo "<option value='$r[id]'>$r[nome]</option>";
?>
	</select>
	<br><br>
	<input type='hidden' value='1' name='gerar_cupom'/>
	<input type='submit' value='Gerar' class='btn'/>
</form>
<br>
<center class='titulo'>Gerados</center>
<table class='grid' border=1>
	<thead>
		<tr>
			<th>ID</th>
			<th>Tipo</th>
			<th>Cliente</th>
			<th>Código</th>
			<th>Status</th>
		</tr>
	</thead>
	<tbody>
<?php
$sql = "SELECT c.codigo, c.id, c.tipo, c.status, u.nome 'cliente'
		FROM cupom c JOIN cliente u ON c.id_cliente=u.id ORDER BY c.id";
$r = $db->query($sql) or die(mysqli_error($db));
$rows = $r->fetch_all(MYSQLI_ASSOC);
foreach($rows as $r) {
	$tipo = $r[tipo]==1 ? 'Fixo' : 'Perc';
	$status = $r[status] ? 'Usado' : 'Novo';
	echo "
		<tr>
			<td>$r[id]</td>
			<td>$tipo</td>
			<td>$r[cliente]</td>
			<td>$r[codigo]</td>
			<td>$status</td>
		</tr>";
}
?>
	</tbody>
</table>