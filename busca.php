<?php
require_once('conf.php');
$busca = $_POST['busca'];
$id_cliente = $_SESSION['id_cliente'] ? $_SESSION['id_cliente'] : 0;
$ip = user_ip();

$sql = "INSERT INTO busca (id_cliente, busca, ip, datahora) VALUES ($id_cliente, '$busca', '$ip', NOW())";
$db->query($sql) or die(mysql_error());

$sql = "SELECT id, nome, valor, descricao FROM produto WHERE nome LIKE '%$busca%' ORDER BY nome";
$r = $db->query($sql) or die(mysql_error());
$rows = $r->fetch_all(MYSQLI_ASSOC);
if (!$rows) $txt = "Sem resultado para busca:";
else $txt = "Resultado(s) para busca:";

$txt .= " <font size=5><u>$busca</u></font>";
echo $txt;
?>

<br><br><br>
<div id='resultados-busca'>
<?php
#echo "<pre>"; var_dump($rows); echo "</pre>";
foreach ($rows as $p) {
	$valor = number_format($p[valor], 2, ',', '.');
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
$db->close();
?>