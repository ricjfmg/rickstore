<!--<input type='button' value='Voltar' onmouseup="voltar()" /><br><br>-->
<form id='form-produto' enctype="multipart/form-data" method="post">
	<center class='titulo'>Novo Produto</center>
	<label>Nome <input name='nome' class='nome' type='text' required/></label><br>
	<label>Valor <input name='valor' type='number' class='valor' min=0 max=9999 step='0.01' required/></label><br>
	<label>Quantidade <input name='qtd' type='number' class='qtd' min=0 max=9999 required/></label><br>
	<label>Imagem <input name='img' type='file' accept='image/*' required/></label><br>
	<label>Descrição <textarea name='desc'></textarea></label><br>
	<input type='hidden' value='1' name='novo_produto'/>
	<input type='submit' value='Adicionar' class='btn'/>
</form>
<br>
<center class='titulo'>Produtos</center>
<table class='grid' border=1>
	<thead>
		<tr>
			<th>ID</th>
			<th>Nome</th>
			<th>Qtd</th>
			<th>Valor</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php
$sql = "SELECT p.id, p.nome, p.qtd, p.valor, p.descricao FROM produto p";
$r = $db->query($sql) or die(mysqli_error($db));
$rows = $r->fetch_all(MYSQLI_ASSOC);
foreach($rows as $r) {
	$qtd = "<input type='number' class='qtd' value='$r[qtd]' min=0 max=9999/>";
	#$valor = number_format($r[valor], 2, ',', '.');
	$valor = "<input type='number' class='valor' value='$r[valor]' min=0 max=9999 step='0.01'/>";
	$acoes = "<img onclick='edit_produto($r[qtd])' src='img/edit.png'/>";

	echo "
		<tr data-id='$r[id]'>
			<td>$r[id]</td>
			<td>$r[nome]</td>
			<td>$qtd</td>
			<td>$valor</td>
			<td>$acoes</td>
		</tr>";
}
?>
	</tbody>
</table>
<input type='submit' value='Atualizar Produtos' class='btn'/>