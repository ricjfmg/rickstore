<?php
require_once('header.php');
?>
	<div id='grid'>
		<div id='conta'>
		 	<span class='titulo'>Seus pedidos</span>
			<br><br>
<?php
$sql = "SELECT id, id_endereco, data, status, valor, id_cupom FROM pedido WHERE id_cliente={$_SESSION[id_cliente]} ORDER BY id DESC";
$r = $db->query($sql);
$pedidos = $r->fetch_all(MYSQLI_ASSOC);
foreach($pedidos as $p) {
	$data = date('d/m/Y H:i:s', strtotime($p[data]));
	$valor = number_format2($p[valor], 2, ',', '.');
	switch($p[status]) {
		case 0: $status = "Pendente <input class='pagar btn blue' value='Pagar' type='button'/>"; break;
		case 1: $status = "Enviando"; break;
		case 2: $status = "Concluído"; break;
	}
	echo "
		<div class='linha pedido' data-id='$p[id]'>
			<div>
				<input class='ver btn grey' value='Ver' type='button'/>
				$data
			</div>
			<div>R$$valor</div>
			<div><span class='status'>$status</span></div>
		</div>";
}
?>
		</div>
	</div>

<?php
require_once('footer.php');
?>