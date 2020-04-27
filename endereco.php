<?php
$array_estados = array(
	'AC'=>'Acre',
	'AL'=>'Alagoas',
	'AP'=>'Amapá',
	'AM'=>'Amazonas',
	'BA'=>'Bahia',
	'CE'=>'Ceará',
	'DF'=>'Distrito Federal',
	'ES'=>'Espírito Santo',
	'GO'=>'Goiás',
	'MA'=>'Maranhão',
	'MT'=>'Mato Grosso',
	'MS'=>'Mato Grosso do Sul',
	'MG'=>'Minas Gerais',
	'PA'=>'Pará',
	'PB'=>'Paraíba',
	'PR'=>'Paraná',
	'PE'=>'Pernambuco',
	'PI'=>'Piauí',
	'RJ'=>'Rio de Janeiro',
	'RN'=>'Rio Grande do Norte',
	'RS'=>'Rio Grande do Sul',
	'RO'=>'Rondônia',
	'RR'=>'Roraima',
	'SC'=>'Santa Catarina',
	'SP'=>'São Paulo',
	'SE'=>'Sergipe',
	'TO'=>'Tocantins'
);

$endereco = "
	<select id='endereco_cliente'>
		<option value='0'>Novo Endereço</option>
		<option value='999'>ENDEREÇO TESTE</option>";

$sql = "SELECT id, telefone, endereco, cidade, estado, cep
		FROM cliente_endereco WHERE id_cliente={$_SESSION[id_cliente]} ORDER BY endereco";
$r = $db->query($sql) or die(mysqli_error($db));
$rows = $r->fetch_all(MYSQLI_ASSOC);
foreach ($rows as $r) {
	$texto_endereco = "$r[endereco], $r[cidade] - $r[estado]";
	$endereco .= "
		<option value='$r[id]'>$texto_endereco</option>";
}

$estados = "
			<option value='' disabled selected>UF</option>";

foreach(array_keys($array_estados) as $e) {
	$estados .= "
			<option value='$e'>$e</option>";
}

$endereco .= "
	</select>
	<br>
	<form id='form-endereco'>
		<label>Endereço <input name='endereco' type='text' maxlength=300></label><br>
		<label>Cidade <input name='cidade' type='text'maxlength=100></label><br>
		<label>Estado <select name='estado'>
			$estados
		</select></label><br>
		<label>CEP <input name='cep' class='numero' type='text' maxlength=8></label><br>
		<label>Telefone <input name='telefone' class='numero' type='text' maxlength=11></label><br>
	</form>";
?>