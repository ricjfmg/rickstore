function logout() { 
	$('#menu').html("<img src='loading.gif'/>");
	$.post('', {logout:1}, function(r) { 
		window.location.replace('');
	})
}
function cupons() { 
	$('#load').html("<img src='loading.gif'/>");
	$('#load').load('', {cupons:1});
}
function produtos() { 
	$('#load').html("<img src='loading.gif'/>");
	$('#load').load('', {produtos:1});
}
function voltar() {
	$('#load').html("<img src='loading.gif'/>");
	window.location.replace('');
}
$(document).on('change blur', 'input[type=number]', function(e) {
	var max = parseInt($(this).attr('max'));
	var min = parseInt($(this).attr('min'));
	if ($(this).val() > max)
	    $(this).val(max);
	else if ($(this).val() < min)
	    $(this).val(min);
});
$(document).on('submit', "#form-cupom", function(r) {
	$.post('', $(this).serialize(), function(r) {
		if (r==1) {
			$("#form-cupom .btn").val('Gerado').addClass('green').prop('disabled', true);
			cupons();
		}
		else
			alert(r);
	});
	return false;
});
$(document).on('submit', "#form-produto", function(r) {
	$.ajax({
		type: 'POST',
		url: "",
		data: new FormData(this),
		processData: false,
		contentType: false,
		success: function(r) {
			console.log(r);
			switch(r) {
				case 1: alert('Upload permite apenas arquivos tipo imagem.'); return false;
				case 2: alert(''); return false;
				case 3: produtos(); break;
				default: console.log(r);
			}
	 	}
	});

	return false;
});
$(document).on('change', 'input[type="file"][accept="image/*"]', function(e) {
	var tipo = e.target.files[0]['type'];
	var permitidos = ['image/jpg', 'image/jpeg', 'image/png'];
	if ($.inArray(tipo, permitidos) == -1) {
		$(this).val(null);
		alert('Upload permite apenas arquivos tipo imagem.'); 
	}
})