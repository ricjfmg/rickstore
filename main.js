function carrega_pagina(url, post, titulo) {
	u = url.split('?')[0];
	$("#main").html("<img class='loading' src='img/loading.gif'/>");
	$("#main").load(u+' #load', post);
	if (history.pushState) window.history.pushState("", titulo, url);
	else document.location.href = url;
	document.title = titulo;
}

function carrega_carrinho(id) {
	var novo = 1;
	var carrinho = [];

	var c = localStorage.getItem('carrinho');
	if (c) {
		c = c.split('|');
		for (i in c) {
			p = c[i].split('x');
			if (id && p[0] == id) { p[1]++; novo = 0; }
			carrinho[p[0]] = p[1];
		}
	}
	if (id && novo) carrinho[id] = 1;

	var carrinho_texto = [];
	for (i in carrinho) {
		carrinho_texto.push(i+'x'+carrinho[i]);
	}
	carrinho_texto = carrinho_texto.join('|');
	localStorage.setItem('carrinho', carrinho_texto);

	carrega_pagina('carrinho.php', {carrinho: carrinho_texto}, 'Carrinho');
}

$(document).on('keydown', 'input.numero', function(e) {
    // delete, backspace, tab, enter
    if ($.inArray(e.keyCode, [46, 8, 9, 13]) !== -1 ||
      // Ctrl+A, Ctrl+C, Ctrl+V, Command+A
      ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
      // home, end, left, right, down, up
      (e.keyCode >= 35 && e.keyCode <= 40)) {

      return;
    }
    // filtrar não numéricos
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
    }
});

$(document).on('focus', '.alerta', function(e) {
	$(this).removeClass('alerta');
});

$(document).on('change blur', 'input[type=number]', function(e) {
	var max = parseInt($(this).attr('max'));
	var min = parseInt($(this).attr('min'));
	if ($(this).val() > max)
	    $(this).val(max);
	else if ($(this).val() < min)
	    $(this).val(min);
});

$(document).on('submit', '#form-login', function(e) {
	var login = $("#login").val();
	var senha = $("#senha").val();

	if (login && senha) {
		$("#form-login .btn").attr('disabled', 1);
		$("#form-login .loading").css('visibility', 'visible');
		$("#header").load('login.php', {login: login, senha: senha});
	}else{
		$("#login").addClass('alerta');
		$("#senha").addClass('alerta');
		//$(".aviso").text('Digite login e senha');
	}
	return false;	
});

$(document).on('submit', '#form-cadastro', function(e) {
	var campos = $(this).serializeArray();
	var erro = 0;
	for (i in campos) {
		var c = campos[i];
		if (!c['value']) {
			$("[name='"+c['name']+"']").addClass('alerta');
			erro = 1;
		}
	}
	if (erro) {
		alert('Preencha todos os campos.');
		return false;
	}

	$.post('login.php', $(this).serialize(), function(r) {
		if (r==0) {
			alert('Login e/ou E-mail já utilizado(s).');
			return false;
		}else if (r==1) {
			$.post('login.php', {login: $("#c-login").val(), senha: $("#c-senha").val()});
			window.location.replace('index.php');
			alert('Cadastro realizado.');
		}
	});
	return false;
});

$(document).on('focus', '#form-login input', function(e) {
	$(".aviso").text('');
});

$(document).on('click', '#menu .logout', function(e) {
	$("#header").load('login.php', {logout: 1});
})

$(document).on('click', '.cadastre-se', function(e) {
	carrega_pagina('cadastro.php', null, 'Cadastro');
});

$(document).on('click', '#menu .inicio', function(e) {
	carrega_pagina('index.php', null, 'Rickstore');
})

$(document).on('click', '#menu .conta', function(e) {
	carrega_pagina('conta.php', null, 'Minha Conta');
})

$(document).on('click', '#menu .carrinho', function(e) {
	carrega_carrinho();
})


$(document).on('submit', '#form-busca', function(e) {
	$(".recentes").hide();
	var busca = $("#busca").val().replace(/\|/g, '').toLowerCase();
	var titulo = busca ? 'Busca: '+busca : 'Produtos';
	carrega_pagina('busca.php?'+busca, {busca: busca}, titulo);
	if (busca) {
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
			if (buscas[i]) $(".recentes").append("<div class='opt'>"+buscas[i]+"</div>");
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
	var nome = $(this).data('nome');
	carrega_pagina('produto.php?'+id, {id: id}, 'Produto: '+nome);
});

$(document).on('submit', '#form-comentar', function(e) {
	var txt = $("#form-comentar .txt").val();
	var nome = $("#form-comentar .cliente").val();
	if (txt.length < 5) return false;

	var post = {id: $(".id_produto").val(), txt: txt};
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

$(document).on('click', '#info-produto .add', function(e) {
	if (!confirm('Adicionar este produto ao carrinho?')) return false;
	var id = $(this).data('id');
	carrega_carrinho(id);
});

$(document).on('click', '#carrinho .remove', function(e) {
	if (!confirm('Remover '+nome+' do carrinho?')) return false;
	var id = $(this).data('id');
	var nome = $(this).data('nome');
	$("#carrinho .p-"+id).remove();
});

$(document).on('click', '#carrinho .salvar', function(e) {
	if (!confirm('Salvar alterações no carrinho?')) return false;
	var carrinho = [];
	$("#carrinho .qtd").each(function(i) {
		var id = $(this).data('id');
		var qtd = $(this).val();
		carrinho.push(id+'x'+qtd);
	});
	var carrinho_texto = carrinho.join('|');
	localStorage.setItem('carrinho', carrinho_texto);
	carrega_carrinho();
});

$(document).on('click', '#carrinho .limpar', function(e) {
	if (!confirm('Remover TODOS produtos do carrinho?')) return false;
	$("#carrinho .produto").remove();
	localStorage.setItem('carrinho', '');
	carrega_carrinho();
});

$(document).on('click', '#carrinho .proximo', function(e) {
	if (!confirm('Salvar carrinho e prosseguir para próximo passo?')) return false;
	var carrinho = [];
	var produtos = [];
	$("#carrinho .qtd").each(function(i) {
		var id = $(this).data('id');
		var qtd = $(this).val();
		if (id && qtd) {
			produtos[id] = qtd;
			carrinho.push(id+'x'+qtd);
		}
	});
	var carrinho_texto = carrinho.join('|');
	localStorage.setItem('carrinho', carrinho_texto);
	console.log(produtos);
	carrega_pagina('pedido.php', {produtos: produtos}, 'Pedido');
});

$(document).on('click', '#pedido .voltar', function(e) {
	if ($(this).data('id'))
		carrega_pagina('conta.php', null, 'Minha Conta');
	else
		carrega_carrinho();
});

$(document).on('keypress', '#desconto .cupom', function(e) {
	if (e.which == 13 || e.keyCode == 13) $("#desconto .aplicar").click();
});

$(document).on('click', '#desconto .aplicar', function(e) {
	var codigo = $("#desconto .cupom").val();
	if (!codigo) {
		alert('Preencha o código do cupom.');
		return false;
	}
	$.post('pedido.php', {cupom: codigo}, function(r) {
		if (r==0) {
			alert('Cupom inválido.');
			return false;
		}else{
			var desconto;
			if (r==1) {
				desconto = 20;
				$("#pedido #desconto").html(`
					<span class='nome'>Desconto (Fixo):</span>
					-R$ <span class='valor'>R$20,00</span>
				`);
			}else{
				var total = $("#pedido .total .valor").text().replace('.','').replace(',','.');
				desconto = total * 0.1;
				desconto = desconto.toFixed(2).toString().replace('.', ',');
				$("#pedido #desconto").html(`
					<span class='nome'>Desconto (10%):</span>
					-R$ <span class='valor'>${desconto}</span>
				`);
			}
			$("#pedido #desconto").append(`<input type='hidden' id='cupom' value='${codigo}'/>`);
		}
	});
	return false;
});

$(document).on('change', "#endereco_cliente", function(e) {
	console.log($(this).val());
	if ($(this).val() == 0) $("#form-endereco").show();
	else $("#form-endereco").hide();
});

$(document).on('click', '#pedido .finalizar', function(e) {
	var id_endereco = $("#endereco_cliente").val();
	if (id_endereco == 0) {
		var array_endereco = $("#form-endereco").serializeArray();
		var novo_endereco = {};
		var erro = 0;

		for (i in array_endereco) {
			var e = array_endereco[i];
			if (!e['value']) {
				$("[name='"+e['name']+"']").addClass('alerta');
				erro = 1;
			}
			novo_endereco[e['name']] = e['value'];
		}
		var campo_estado = $("[name='estado']");
		if (!campo_estado.val()) {
			campo_estado.addClass('alerta');
			erro = 1;
		}
		if (erro) {
			alert('Preencha todos os campos.');
			return false;
		}
	}

	var produtos = [];
	$("#pedido .prod").each(function(i) {
		var id = $(this).data('id');
		var qtd = $(this).data('qtd');
		produtos[id] = qtd;
	});
	var post = {
		finalizar: 1,
		cupom: $("#cupom").val(),
		produtos: produtos,
		id_endereco: id_endereco,
		novo_endereco: novo_endereco
	};

	$.post('pedido.php', post, function(r) {
		console.log(r);
		if (r==1) {
			localStorage.setItem('carrinho', '');
			alert('Pedido concluído.');
			carrega_pagina('conta.php', null, 'Minha Conta');
		}
	});
});

$(document).on('click', '#conta .pedido', function(e) {
	carrega_pagina('pedido.php', {id_pedido: $(this).data('id')}, 'Pedido');
});