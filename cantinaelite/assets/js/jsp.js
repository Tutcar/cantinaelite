$(function (){
	
	$('.filtro').click (function(){
	$('.mostraFiltro').slideToggle();
	$(this).toggleClass('active');
		return false;
	});
	
	$('.mobmenu').click (function(){
	$('.menutopo').slideToggle();
	$(this).toggleClass('active');
		return false;
	});	
	
	$('.senha').click (function(){
		$('.mostraCampo').slideToggle();
		$(this).toggleClass('active');
		return false;
	});
				
	$( "#accordion" ).accordion({
		collapsible: true,
		autoHeight: false,
		active: false,
		heightStyle: "content" 
    });
	
	

});
$(function(){
	$(".btn-toggle").click(function(e){
		e.preventDefault();
		el = $(this).data('element');
		$(el).toggle();
	});
});

function excluir(obj){
	var entidade  = $(obj).attr('data-entidade');
	var id  = $(obj).attr('data-id');
	if(confirm('Deseja realmente excluir ?')){
		window.location.href = base_url + entidade +"/excluir/" + id;	
	}
}

function fecharMsg(obj){	
	$(".msg").hide();
}
//tuta
function pegaArquivo(files){
	var file = files[0];
	const fileReader = new FileReader();
	fileReader.onloadend = function(){
		$("#imgUp").attr("src", fileReader.result);
	}
	fileReader.readAsDataURL(file);
	
}
function excluir2(obj){
	var entidade  = $(obj).attr('data-entidade');
	var id  = $(obj).attr('data-id');
	var id_etapas  = $(obj).attr('data-id_etapas');
	if(confirm('Deseja realmente excluir ?')){
		window.location.href = base_url + entidade +"/excluir/" + id + "/" + id_etapas;	
	}
}
$('#nomeDesp').submit(function(e){
	e.preventDefault();
	var nome_desp = $('#nomeDespesas').val();
	var id_despesas = $('#id_despesas').val();
	$.ajax({
		url: base_url + "Despesas/salvarJson/",
		type:'POST',
		data: {nome_desp: nome_desp, id_despesas:id_despesas},
		dataType:'json',
		success: function(r){
			alert(r);
			window.location.reload();
			document.getElementById("cod_despesa").value = nome_desp;
		}
	});
});

