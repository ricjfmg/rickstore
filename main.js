$(document).on('submit', '#form-login', function(e) {
	var login = $("#login").val();
	var senha = $("#senha").val();

	if (login && senha) {
		$("#form-login .btn").attr('disabled', 1);
		$("#form-login .loading").css('visibility', 'visible');
		$("#header").load('login.php', {login: login, senha: senha});
	}else{
		$(".aviso").text('Digite login e senha');
	}
	return false;	
});

$(document).on('focus', '#form-login input', function(e) {
	$(".aviso").text('');
});

$(document).on('click', '#logout', function(e) {
	$("#header").load('login.php', {logout: 1}, function(r) {console.log(r)});
})

$(document).on('submit', '#form-busca', function(e) {
	$(".recentes").hide();
	var busca = $("#busca").val().replace(/\|/g, '').toLowerCase();
	if (busca) {
		$("#main").html("<img class='loading' src='img/loading.gif'/>");
		$("#main").load('busca.php', {busca: busca});
		var buscas = localStorage.getItem('buscas');
		if (buscas) {
			buscas = buscas.split('|');
			buscas = buscas.filter(function(e) { return e !== busca })
			buscas.unshift(busca);
			buscas = buscas.slice(0,5);
			buscas = buscas.join('|');
		}
		else buscas = busca;
		localStorage.setItem('buscas', buscas);
	}
	return false;
});

$(document).on('mouseenter', '#busca', function(e) {
	var buscas = localStorage.getItem('buscas');
	if (buscas) {
		buscas = buscas.split('|');
		$(".recentes .opt").remove();
		$(buscas).each(function(i) {
			//console.log(buscas[i]);
			$(".recentes").append("<div class='opt'>"+buscas[i]+"</div>");
		});
	}
	$(".recentes").show();
});

$(document).on('click', '#form-busca .opt', function(e) {
	$(".recentes").hide();
	$("#busca").val($(this).text());
	$("#form-busca").submit();
});

$(document).on('click', '#resultados-busca .result', function(e) {
	var id = $(this).data('id');
	$("#main").html("<img class='loading' src='img/loading.gif'/>");
	$("#main").load('produto.php', {id: id});
});

$(document).on('submit', '#form-comentar', function(e) {
	var txt = $("#form-comentar .txt").val();
	var nome = $("#form-comentar .cliente").val();
	if (txt.length < 5) return false;

	var post = {id: $(".id_produto").val(), txt: txt};
	console.log(post);
	$.post('produto.php', post, function(r) {
		txt = txt.replace(/(?:\r\n|\r|\n)/g, '<br>');
		if (r==1) alert('É necessário estar logado para comentar.');
		if (r==2) {
			$("#comentar .txt").val('');
			$("#info-produto .comentarios").append(`
				<div class='c'>
					${nome}
					<br>
					<div class='divisao'></div>
					<br>
					${txt}
				</div>
			`);
		}

	});
	return false;
});