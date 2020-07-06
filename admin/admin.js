function logout() { 
	$('#menu').html("<img src='loading.gif'/>");
	$.post('', {logout:1}, function(r) { 
		window.location.replace('');
	})
}
function cupons() { 
	$('#load').html("<img src='loading.gif'/>");
	$('#load').load('cupons.php', {cupons:1});
}
function produtos() { 
	$('#load').html("<img src='loading.gif'/>");
	$('#load').load('produtos.php', {produtos:1});
}
function pedidos() { 
	$('#load').html("<img src='loading.gif'/>");
	$('#load').load('pedidos.php', {pedidos:1});
}
function relatorio() { 
	$('#load').html("<img src='loading.gif'/>");
	$('#load').load('relatorio.php', {relatorio:1});
}
function voltar() {
	$('#load').html("<img src='loading.gif'/>");
	window.location.replace('');
}

$(document).on('click', '#xls', function(e) {
    var file_name = "relatorio.xls";
    var meta = '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />';
    var table = $("#relatorio").clone();
    table.find('.remove').remove();
    var html = meta + table[0].outerHTML;
    var xData = new Blob([html], {type: 'text/csv'});
    var xUrl = URL.createObjectURL(xData);
    var a = document.createElement('a');
    a.setAttribute('href', xUrl);
    a.setAttribute('download', file_name);
    a.setAttribute('style', 'display:none');
    document.body.appendChild(a);
    a.click();
    a.parentNode.removeChild(a);
});

$(document).on('change blur', 'input[type=number]', function(e) {
	var max = parseInt($(this).attr('max'));
	var min = parseInt($(this).attr('min'));
	if ($(this).val() > max)
	    $(this).val(max);
	else if ($(this).val() < min)
	    $(this).val(min);
});

$(document).on('submit', "#form-cupom", function(r) {
	$.post('cupons.php', $(this).serialize(), function(r) {
		if (r==1) {
			$("#form-cupom .btn").val('Gerado').addClass('green').prop('disabled', true);
			cupons();
		}
		else
			alert(r);
	});
	return false;
});

$(document).on('change', "#form-produto .valor", function(r) {
	var val = $(this).val();
	$("#form-produto .fixa").val(val*0.1);
	$("#form-produto .lucro").val(val*0.2);
	$("#form-produto .imposto").val(val*0.3);
});

$(document).on('change', "#form-estoque .valor", function(r) {
	var val = $(this).val();
	var tr = $(this).closest('tr');
	tr.find(".fixa").val(val*0.1);
	tr.find(".lucro").val(val*0.2);
	tr.find(".imposto").val(val*0.3);
});

$(document).on('submit', "#form-produto", function(r) {
	$.ajax({
		type: 'POST',
		url: "produtos.php",
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function(r) {
			switch(r) {
				case '1': alert('Upload permite apenas arquivos tipo imagem.'); return false;
				case '2': alert('Selecione imagem menor que 2 megabytes.'); return false;
				case '3': produtos(); break;
				default: console.log(r);
			}
	 	}
	});
	return false;
});

$(document).on('click', '#toggle-novo', function(e) {
	if ($(this).hasClass('off')) {
		$(this).removeClass('off').addClass('on').text('Novo Produto [-]');
		$("#form-produto").css('height', '350px');
	}else{
		$(this).removeClass('on').addClass('off').text('Novo Produto [+]');
		$("#form-produto").css('height', '0px');
	}
});

$(document).on('change', 'input[type="file"][accept="image/*"]', function(e) {
	var tipo = e.target.files[0]['type'];
	var permitidos = ['image/jpg', 'image/jpeg', 'image/png'];
	if ($.inArray(tipo, permitidos) == -1) {
		$(this).val(null);
		alert('Upload permite apenas arquivos tipo imagem.'); 
	}
});

$(document).on('change', "#form-estoque .p input", function(r) {
	$(this).closest('.p').addClass('changed');
});

$(document).on('submit', "#form-estoque", function(r) {
	var alterados = $('#form-estoque .p.changed');
	if (!alterados.length) return false;

	var produtos = {};
	alterados.each(function(i) {
		var id = $(this).data('id');
		var qtd = $(this).find('.qtd').val();
		var valor = $(this).find('.valor').val();
		produtos[id] = {qtd: qtd, valor: valor};
	});

	$.post('produtos.php', {estoque: 1, produtos: produtos}, function(r) {
		console.log(r);
		if (r=='1') alert('Os produtos foram atualizados.');
		else alert(r);
	});
	return false;
});

$(document).on('click', "#concluir-pedidos", function(r) {
	var checked = $("#pedidos .chk:checked");
	if (!checked.length) return false;
	var ids = [];
	checked.each(function(i) {
		ids.push($(this).data("id"));
	});

	$.post('pedidos.php', {atualizar_pedidos: 1, ids: ids}, function(r) {
		if (r==1) pedidos();
		else alert(r);
	});
	return false;
});

$(document).on('change', '#filtro-pedidos', function(e) {
	var t = $(this).val();
	if (t) {
		$('#pedidos tbody tr, .grid .status').hide();
		$('#pedidos tr.s-'+t).show();
	}else{
		$('#pedidos tbody tr, .grid .status').show();
	}
});

$(document).on('click', '#form-estoque .edit_produto', function(e) {
	var r = window.prompt('Renomear produto?');
	if (r && r.length >3) {
		var tr = $(this).closest('tr');
		var id = tr.data('id');
		$.post('produtos.php', {editar: 1, id: id, nome: r}, function(rr) {
			if (rr=='1') tr.find('.nome').text(r);
			else alert(rr);
		});
	}
});

$(document).on('click', '#form-estoque .delete_produto', function(e) {
	var r = window.confirm('Deletar produto?');
	if (r) {
		var tr = $(this).closest('tr');
		var id = tr.data('id');
		$.post('produtos.php', {deletar: 1, id: id}, function(rr) {
			if (rr=='1') tr.remove();
			else alert(rr);
		});
	}
});