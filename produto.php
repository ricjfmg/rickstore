<?php
require_once('conf.php');
$id_produto = $_POST['id'];
if (!$id_produto) die;

$cliente = explode(' ', $_SESSION['nome']);
$cliente = $cliente[0].' '.substr(array_pop($cliente), 0, 1).'.';

if ($_POST['txt']) {
	#var_dump($_POST);
	$id_cliente = $_SESSION['id_cliente'];
	if (!$id_cliente) die('1');

	$sql = "INSERT INTO produto_comentario (id_produto, id_cliente, texto, datahora)
			VALUES ($id_produto, $id_cliente, '$_POST[txt]', NOW())";
	$r = $db->query($sql) or die(mysql_error());
	#var_dump($r);
	if ($r) die('2');
	die;
}

$r = $db->query("SELECT id, nome, valor, descricao FROM produto WHERE id=$id_produto") or die(mysql_error());
$p = $r->fetch_assoc();
if (!$p) die("<center>Produto não encontrado.</center>");

$r = $db->query("SELECT pc.texto, c.nome
	FROM produto_comentario pc JOIN cliente c ON pc.id_cliente=c.id
	WHERE id_produto=$id_produto") or die(mysql_error());
$rows = $r->fetch_all(MYSQLI_ASSOC);

foreach ($rows as $c) {
	$nome = explode(' ', $c[nome]);
	$nome = $nome[0].' '.substr(array_pop($nome), 0, 1).'.';
	$texto = nl2br($c[texto]);
	$comentarios[] = "
		<div class='c'>
			$nome
			<br>
			<div class='divisao'></div>
			<br>
			$texto
		</div>
	";
}
$comentarios = implode("\n", $comentarios);

if ($_SESSION['login'])
	$campo_comentar = "
	<form id='form-comentar'>
		<input class='id_produto' type='hidden' value='$id_produto'/>
		<input class='cliente' type='hidden' value='$cliente'/>
		<textarea class='txt' maxlength='400'></textarea><br>
		<input class='btn' type='submit' value='Comentar'/>
	</form>";
else
	$campo_comentar = "É necessário estar logado para comentar.";

?>

<div id='info-produto'>
<?php
#echo "<pre>"; var_dump($rows); echo "</pre>";
$valor = number_format($p[valor], 2, ',', '.');
echo "
	<div class='titulo'>$p[nome]</div>
	<div class='img' style='background-image:url(produtos/$p[id].jpg)'/>
	<div class='desc'>
		<h3>Preço:</h3> <div class='preco'>R$<span class='valor'>$valor</span></div>
		<br>
		<h2>Descrição do produto:</h2>
		<br>
		$p[descricao]
	</div>
	<br>
	<div class='divisao'></div>
	<div class='detalhes'>
		<br>
		<center><h2>Informações Técnicas</h2></center>
		<br>
		-
		<br>
		-
		<br>
		-
		<br>
		-
	</div>
	<br>
	<div class='divisao'></div>
	<div class='comentarios'>
		<br>
		<center><h2>Comentários</h2></center>
		<br>
		$comentarios
	</div>
	<br>
	<div class='divisao'></div>
	<br>
	<div class='comentar'>
		$campo_comentar
	</div>
";
?>
</div>

<?php
$db->close();
?>