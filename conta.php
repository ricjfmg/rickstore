<?php
require_once('header.php');
?>
	<div id='grid'>
		<div id='conta'>
		 	<span class='titulo'>Seus pedidos</span>
			<br><br>
<?php
$sql = "SELECT id, id_endereco, data, status, valor, id_cupom FROM pedido WHERE id_cliente={$_SESSION[id_cliente]}";
$r = $db->query($sql);
$pedidos = $r->fetch_all(MYSQLI_ASSOC);
foreach($pedidos as $p) {
	$data = date('d/m/Y H:i:s', strtotime($p[data]));
	$valor = number_format($p[valor], 2, ',', '.');
	echo "
		<div class='linha pedido' data-id='$p[id]'>
			$data - R$$valor
		</div>";
}
?>
		</div>
	</div>

<?php
require_once('footer.php');
?>