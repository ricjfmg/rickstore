<?php
require_once('../conf.php');

if ($_POST['editar']) {
	$sql = "UPDATE produto SET nome='$_POST[nome]' WHERE id=$_POST[id];";
	$db->query($sql) or die("$sql\n".mysqli_error($db));
	die('1');
}

if ($_POST['deletar']) {
	$sql = "UPDATE produto SET inativo=1 WHERE id=$_POST[id];";
	$db->query($sql) or die("$sql\n".mysqli_error($db));
	die('1');
}

if ($_POST['estoque']) {
	foreach($_POST['produtos'] as $id => $p) {
		$valor = $p[valor] + $p[valor]*0.1 + $p[valor]*0.2 + $p[valor]*0.3;
		$sql[] = "UPDATE produto SET qtd=$p[qtd], base=$p[valor], valor=$valor WHERE id=$id;";
	}
	$sql = implode("\n", $sql);
	$db->multi_query($sql) or die("$sql\n".mysqli_error($db));
	die("1");
}

if ($_POST['novo_produto']) {
	$img = getimagesize($_FILES["img"]["tmp_name"]) or die('1');
	$w = $img[0];
	$h = $img[1];
	$tipo = $img[mime];
	$permitidos = array('image/jpg', 'image/jpeg', 'image/png');
	#var_dump($_POST); die;
	if (!in_array($tipo, $permitidos)) die('1');
	if ($_FILES['img']['size'] > 2097152) die('2');
	else{
		$base = $_POST[valor];
		$valor = $base + $base*0.1 + $base*0.2 + $base*0.3;
		$sql = "INSERT INTO produto (nome, qtd, base, valor, descricao)
				VALUES ('$_POST[nome]', $_POST[qtd], $base, $valor, '$_POST[desc]')";
		$db->query($sql) or die("$sql\n".mysqli_error($db));
		$id = $db->insert_id;
		$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
		$path = "../produtos/$id.$ext";
		$r = move_uploaded_file($_FILES['img']['tmp_name'], $path);
		die('3');
	}
}
?>

<!--<input type='button' value='Voltar' onmouseup="voltar()" /><br><br>-->
<center id='toggle-novo' class='titulo off'>Novo Produto [+]</center>
<form id='form-produto' enctype="multipart/form-data" method="post">
	<label>Nome <input name='nome' class='nome' type='text' required/></label><br>
	<label>Custo Base <input name='valor' type='number' class='valor' min=0 max=9999 step='0.01' required/></label><br>
	<label>
		<small>D. Fixas (10%) <input class='taxa fixa' disabled/></small>
		<small>M. Lucro (20%) <input class='taxa lucro' disabled/></small>
		<small>Impostos (30%) <input class='taxa imposto' disabled/></small>
	</label><br>
	<label>Quantidade <input name='qtd' type='number' class='qtd' min=0 max=9999 required/></label><br>
	<label>Imagem <input name='img' type='file' accept='image/*' required/></label><br>
	<label>Descrição <textarea name='desc'></textarea></label><br>
	<input type='hidden' value='1' name='novo_produto'/>
	<input type='submit' value='Adicionar' class='btn'/>
</form>
<br>
<center class='titulo'>Produtos</center>
<form id='form-estoque' method="post">
	<table class='grid' border=1>
		<thead>
			<tr>
				<th>ID</th>
				<th>Nome</th>
				<th>Qtd</th>
				<th>Custo Base</th>
				<th>D. Fixas (10%)</th>
				<th>M. Lucro (20%)</th>
				<th>Impostos (30%)</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
	<?php
	$sql = "SELECT p.id, p.nome, p.qtd, p.base, p.valor, p.descricao FROM produto p WHERE inativo=0";
	$r = $db->query($sql) or die(mysqli_error($db));
	$rows = $r->fetch_all(MYSQLI_ASSOC);
	foreach($rows as $r) {
		$qtd = "<input type='number' class='qtd' value='$r[qtd]' min=0 max=9999 required/>";
		#$valor = number_format2($r[valor], 2, ',', '.');
		$valor = "<input type='number' class='valor' value='$r[base]' min=0 max=9999 step='0.01' required/>";
		$fixa = "<input class='taxa fixa' disabled value='".$r[base]*0.1."'/>";
		$lucro = "<input class='taxa lucro' disabled value='".$r[base]*0.2."'/>";
		$imposto = "<input class='taxa imposto' disabled value='".$r[base]*0.3."'/>";
		$acoes = "
			<img class='edit_produto' src='img/edit.png'/>
			<img class='delete_produto' src='img/delete.png'/>";
		echo "
			<tr class='p' data-id='$r[id]'>
				<td>$r[id]</td>
				<td class='nome'>$r[nome]</td>
				<td>$qtd</td>
				<td>$valor</td>
				<td>$fixa</td>
				<td>$lucro</td>
				<td>$imposto</td>
				<td>$acoes</td>
			</tr>";
	}
	?>
		</tbody>
	</table>
	<input type='submit' value='Atualizar Produtos' class='btn'/>
</form>