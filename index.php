<?php
require_once('header.php');

$r = $db->query("SELECT id, nome, valor, descricao FROM produto WHERE inativo=0 ORDER BY nome") or die(mysqli_error($db));
$rows = $r->fetch_all(MYSQLI_ASSOC);
?>

	<div id='resultados-busca'>
	<?php
	foreach ($rows as $p) {
		$valor = number_format2($p[valor], 2, ',', '.');
		echo "
		<div class='result' data-id='$p[id]'>
			<div class='titulo'>$p[nome]</div>
			<div class='img' style='background-image:url(produtos/$p[id].jpg)'></div>
			<div class='preco'>R$<span class='valor'>$valor</span></div>
			<div class='desc'>$p[descricao]</div>
		</div>";
	}
	?>
	</div>

<?php
require_once('footer.php');
?>