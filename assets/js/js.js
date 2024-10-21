$(function () {

	$('.filtro').click(function () {
		$('.mostraFiltro').slideToggle();
		$(this).toggleClass('active');
		return false;
	});

	$('.mobmenu').click(function () {
		$('.menutopo').slideToggle();
		$(this).toggleClass('active');
		return false;
	});

	$('.senha').click(function () {
		$('.mostraCampo').slideToggle();
		$(this).toggleClass('active');
		return false;
	});

	// $("#accordion").accordion({
	// 	collapsible: true,
	// 	autoHeight: false,
	// 	active: false,
	// 	heightStyle: "content"
	// });

});

function excluir(obj) {
	var entidade = $(obj).attr('data-entidade');
	var id = $(obj).attr('data-id');
	if (confirm('Deseja realmente excluir ?')) {
		window.location.href = base_url + entidade + "/excluir/" + id;
	}
}
function excluirCom(obj) {
	var entidade = $(obj).attr('data-entidade');
	var id = $(obj).attr('data-id');
	if (confirm('Deseja realmente excluir ?')) {
		window.location.href = base_url + entidade + "/excluir/" + id;
	}
}
function pedidoEntregue(obj) {
	var entidade = $(obj).attr('data-entidade');
	var id = $(obj).attr('data-id');
	if (confirm('Confirma a entrega deste pedido ?')) {
		window.location.href = base_url + entidade + "/confEntrega/" + id;
	}
}
function pedidoVer(obj) {
    var entidade = $(obj).attr('data-entidade');
    var id = $(obj).attr('data-nr_pedido');

    // Faz a chamada AJAX para buscar os itens do pedido
    $.ajax({
        url: base_url + entidade + "/verPedido/" + id,
        method: "GET",
        dataType: "json",
        success: function(response) {
			console.log(response); // Verifique os dados aqui
		
			if (response.erro) {
				alert(response.erro);  // Exibe mensagem de erro se houver
			} else {
				var modalContent = '<h3>Itens do Pedido #' + id + '</h3>';
				modalContent += '<table border="1" width="100%">';
				modalContent += '<thead><tr><th>Produto</th><th>Quantidade</th><th>Valor (R$)</th></tr></thead>';
				modalContent += '<tbody>';
		
				// Itera sobre o array de itens e exibe os campos específicos
				response.forEach(function(item) {
					// Verifica se o item contém os valores necessários
					if (item.nome && item.quant && item.valor) {
						modalContent += '<tr>';
						modalContent += '<td>' + item.nome + '</td>';
						modalContent += '<td>' + item.quant + '</td>';
						modalContent += '<td>' + item.valor + '</td>';
						modalContent += '</tr>';
					}
				});
		
				modalContent += '</tbody></table>';
				modalContent += '<button onclick="$(\'#pedidoModal\').hide();">Fechar</button>'; // Adicione o botão aqui
		
				// Insere o conteúdo no modal
				$('#pedidoModal').html(modalContent);
		
				// Exibe o modal
				document.getElementById('pedidoModal').style.display = 'block';
			}
		}
    });
}

// Função para fechar o modal
function fecharModal() {
    $('#pedidoModal').fadeOut();
}
function excluiritem(obj) {
	var entidade = $(obj).attr('data-entidade');
	var id = $(obj).attr('data-id');
	var idc = $(obj).attr('data-idc');
	if (confirm('Deseja realmente excluir ?')) {
		window.location.href = base_url + entidade + "/excluiritem/" + id + "/" + idc;
	}
}
function excluirTodositem(obj) {
	var entidade = $(obj).attr('data-entidade');
	var id = $(obj).attr('data-id');
	if (confirm('Deseja realmente excluir ?')) {
		window.location.href = base_url + entidade + "/excluirtodositem/" + id;
	}
}
function fecharMsg(obj) {
	$(".msg").hide();
}
//tuta
function pegaArquivo(files) {
	var file = files[0];
	const fileReader = new FileReader();
	fileReader.onloadend = function () {
		$("#imgUp").attr("src", fileReader.result);
	}
	fileReader.readAsDataURL(file);

}
function excluir2(obj) {
	var entidade = $(obj).attr('data-entidade');
	var id = $(obj).attr('data-id');
	var id_etapas = $(obj).attr('data-id_etapas');
	if (confirm('Deseja realmente excluir ?')) {
		window.location.href = base_url + entidade + "/excluir/" + id + "/" + id_etapas;
	}
}
//pedidos tuta
function cadPedido(id) {
	
	var nr_pedido = $('#novoPed').val();
	if (nr_pedido === "novo") {
	    var cliente = "";
	    var nr_pedido = novoPedido;
		$.ajax({
			url: base_url + "Pedidos/salvarJson/",
			type: 'POST',
			data: { cliente: cliente, nr_pedido: nr_pedido },
			dataType: 'json',
			success: function (r) {
				
				window.location.reload();
	
			}
		});
	} else {
		var id_produto = id;
		var nr_pedido = $('#novoPed').val();
		$.ajax({
			url: base_url + "Pedidos/CadPedidoJson/",
			type: 'POST',
			data: { id_produto: id_produto, nr_pedido: nr_pedido },
			dataType: 'json',
			success: function (r) {

				window.location.reload();

			}
		});
	}

}
function cadPedido2(id) {

	var nr_pedido = $('#novoPed').val();
	if (nr_pedido === "novo") {
		alert("Selecione ou cadastre um cliente.");
	} else {
		var id_produto = id;
		var nr_pedido = $('#novoPed').val();
		$.ajax({
			url: base_url + "Pedidos/CadPedidoJson2/",
			type: 'POST',
			data: { id_produto: id_produto, nr_pedido: nr_pedido },
			dataType: 'json',
			success: function (r) {

				window.location.reload();

			}
		});
	}

}


$(function () {
	/*** modal **/
	$("a[rel=modal]").click(function (ev) {
		ev.preventDefault();

		var id = $(this).attr("href");
		tela(id);

	});

	$("#mascara").click(function () {
		$(this).hide();
		$(".window").hide();
	});

	$('.fechar').click(function (ev) {
		ev.preventDefault();
		$("#mascara").hide();
		$(".window").hide();
	});

	/*** fim modal 	**/

});

function abrirModal(id) {

	if (id == '#janela2') {
		if (nrpedido === 0) {
			alert("Selecione um cliente.")
			callbreak;
		}
	}
	document.getElementById('mostra').style.display = 'none';
	document.getElementById('mostra2').style.display = 'none';
	document.getElementById('mostra3').style.display = 'none';
	document.getElementById('mostra4').style.display = 'none';
	document.getElementById('mostra5').style.display = 'none';
	var alturaTela = $(document).height();
	var larguraTela = $(window).width();

	//colocando o fundo preto
	$('#mascara').css({ 'width': larguraTela, 'height': alturaTela });
	$('#mascara').fadeIn(1000);
	$('#mascara').fadeTo("slow", 0.8);

	var left = ($(window).width() / 2) - ($(id).width() / 2);
	var top = ($(window).height() / 2) - ($(id).height() / 2);

	$(id).css({ 'top': top, 'left': left });
	$(id).show();
	$(window).scrollTop(0);
}

function abrirModalAc(id) {

	var alturaTela = $(document).height();
	var larguraTela = $(window).width();

	//colocando o fundo preto
	$('#mascara').css({ 'width': larguraTela, 'height': alturaTela });
	$('#mascara').fadeIn(1000);
	$('#mascara').fadeTo("slow", 0.8);

	var left = ($(window).width() / 2) - ($(id).width() / 2);
	var top = ($(window).height() / 2) - ($(id).height() / 2);

	$(id).css({ 'top': top, 'left': left });
	$(id).show();
	$(window).scrollTop(0);
}

$('#ac_tipo').submit(function(e){
	e.preventDefault();
	var ac_tipo = $('#ac_tipoCad').val();
	$.ajax({
		url: base_url + "Salarioac/salvarJsonAc/",
		type:'POST',
		data: {ac_tipo: ac_tipo},
		dataType:'json',
		success: function(r){
			window.location.reload();
		}
	});
});

function abrirModalDb(id) {

	var alturaTela = $(document).height();
	var larguraTela = $(window).width();

	//colocando o fundo preto
	$('#mascara').css({ 'width': larguraTela, 'height': alturaTela });
	$('#mascara').fadeIn(1000);
	$('#mascara').fadeTo("slow", 0.8);

	var left = ($(window).width() / 2) - ($(id).width() / 2);
	var top = ($(window).height() / 2) - ($(id).height() / 2);

	$(id).css({ 'top': top, 'left': left });
	$(id).show();
	$(window).scrollTop(0);
}

$('#db_tipo').submit(function(e){
	e.preventDefault();
	var db_tipo = $('#db_tipoCad').val();
	$.ajax({
		url: base_url + "Salariodb/salvarJsonDb/",
		type:'POST',
		data: {db_tipo: db_tipo},
		dataType:'json',
		success: function(r){
		
			window.location.reload();
		}
	});
});

function abrirModalDesp(id) {

	var alturaTela = $(document).height();
	var larguraTela = $(window).width();

	//colocando o fundo preto
	$('#mascara').css({ 'width': larguraTela, 'height': alturaTela });
	$('#mascara').fadeIn(1000);
	$('#mascara').fadeTo("slow", 0.8);

	var left = ($(window).width() / 2) - ($(id).width() / 2);
	var top = ($(window).height() / 2) - ($(id).height() / 2);

	$(id).css({ 'top': top, 'left': left });
	$(id).show();
	$(window).scrollTop(0);
}

function abrirModalQuant(id, obj) {
	var id_pedidos = $(obj).attr('data-id');
	var quant = $(obj).attr('data-quant');
	var valor = $(obj).attr('data-valor');
	var nome = $(obj).attr('data-nm_nome');
	var alturaTela = $(document).height();
	var larguraTela = $(window).width();

	//colocando o fundo preto
	$('#mascara').css({ 'width': larguraTela, 'height': alturaTela });
	$('#mascara').fadeIn(1000);
	$('#mascara').fadeTo("slow", 0.8);

	var left = ($(window).width() / 2) - ($(id).width() / 2);
	var top = ($(window).height() / 2) - ($(id).height() / 2);

	$(id).css({ 'top': top, 'left': left }); //modal.find('#minhaId').html(recipientId)


	$(id).show(obj);
	document.getElementById('nome').value = nome;
	document.getElementById('id_pedidos').value = id_pedidos;
	document.getElementById('quant').value = quant;
	document.getElementById('valorEnc').value = valor;
	$(window).scrollTop(0);
}

function abrirModalQuant2(id, obj) {
	var id_pedidos = $(obj).attr('data-idPd');
	var quant = $(obj).attr('data-quantPd');
	var valor = $(obj).attr('data-valorPd');
	var nome = $(obj).attr('data-nm_nomePd');
	var alturaTela = $(document).height();
	var larguraTela = $(window).width();

	//colocando o fundo preto
	$('#mascara').css({ 'width': larguraTela, 'height': alturaTela });
	$('#mascara').fadeIn(1000);
	$('#mascara').fadeTo("slow", 0.8);

	var left = ($(window).width() / 2) - ($(id).width() / 2);
	var top = ($(window).height() / 2) - ($(id).height() / 2);

	$(id).css({ 'top': top, 'left': left }); //modal.find('#minhaId').html(recipientId)


	$(id).show(obj);
	document.getElementById('nomePd').value = nome;
	document.getElementById('id_pedidosPd').value = id_pedidos;
	document.getElementById('quantPd').value = quant;
	document.getElementById('valorPd').value = valor;
	$(window).scrollTop(0);
}

function fecharModal() {
	//inicio();	
	$("#mascara").hide();
	$(".window").hide();
}

$('#nomePedido').submit(function (e) {
	
	e.preventDefault();
	var cliente = $('#nomeCliente').val();
	var nr_pedido = novoPedido;
	$.ajax({
		url: base_url + "Pedidos/salvarJson/",
		type: 'POST',
		data: { cliente: cliente, nr_pedido: nr_pedido },
		dataType: 'json',
		success: function (r) {
			
			window.location.reload();

		}
	});
});

$('#nomePedido2').submit(function (e) {
	e.preventDefault();
	var cliente = $('#nm_cliente').val();
	var data_encomendas = $('#data_encomendas').val();
	var encomendas = $('#encomendas').val();
	var nr_pedido = novoPedido;

	$.ajax({
		url: base_url + "Pedidos/salvarJson2/",
		type: 'POST',
		data: { cliente: cliente, data_encomendas: data_encomendas, encomendas: encomendas, nr_pedido: nr_pedido },
		dataType: 'json',
		success: function (r) {
		
			window.location.reload();
		}
	});
});

function id(valor_campo) {
	return document.getElementById(valor_campo);
};
function getValor(valor_campo) {
	var valor = document.getElementById(valor_campo).value.replace(',', '.');
	return parseFloat(valor) * 100;
};

function darDesc() {
	var total = getValor('valor') - getValor('desconto') + getValor('aumento');
	id('vLiquido').value = total ;
}

function darAumento() {
	var total = getValor('valor') - getValor('desconto') + getValor('aumento');
	id('vLiquido').value = total ;
}



function mostraCampos(c) {
	if (c == "Dinheiro") {
		document.getElementById('mostra').style.display = 'block';
		document.getElementById('mostra2').style.display = 'block';
		document.getElementById('mostra3').style.display = 'block';
		document.getElementById('mostra4').style.display = 'block';
		document.getElementById('mostra5').style.display = 'block';
	} else {

		document.getElementById('mostra').style.display = 'block';
		document.getElementById('mostra2').style.display = 'block';
		document.getElementById('mostra5').style.display = 'block';
		document.getElementById('mostra3').style.display = 'none';
		document.getElementById('mostra4').style.display = 'none';
	}


};
function id2(valor_campo2) {
	return document.getElementById(valor_campo2);
};
function getTroco(valor_campo2) {
	var valor2 = document.getElementById(valor_campo2).value.replace(',', '.');
	return parseFloat(valor2) * 100;
};
function darTroco() {
	var total2 = getTroco('dinheiro') - (getTroco('valor') - getTroco('desconto') + getTroco('aumento'));
	id2('troco').value = formatar.format(total2 / 100);
};

function id3(valor_campo3) {
	return document.getElementById(valor_campo3);
};
function getDif(valor_campo3) {
	var valor3 = document.getElementById(valor_campo3).value.replace(',', '.');
	return parseFloat(valor3) * 100;
};

function calcDif() {
	var total3 = getDif('saldo_cx') - getDif('conferencia');
	id3('diferenca').value = total3 / 100;
}
const formatar = new Intl.NumberFormat('pt-BR', {
	style: "currency",
	currency: "BRL",
	minimumFractionDigits: 2,

})


function mostraAlerta(r) {
	if (r > 0) {
		window.location.href = base_url + "Pedidos/AtualizaPedJson/" + r;
	}
};
function mostraAlerta2(r) {
	if (r > 0) {
		window.location.href = base_url + "Pedidos/AtualizaPedJson2/" + r;
	}
};
$('#fecharPedido').submit(function (e) {
	e.preventDefault();

	var id_pedidos = $('#id_pedidos').val();
	var valor = $('#valor').val();
	var vLiquido = $('#vLiquido').val();
	var tipo_pg = $('#tipo_pg').val();
	$.ajax({
		url: base_url + "Pedidos/salvarFechaPedido/",
		type: 'POST',
		data: { id_pedidos: id_pedidos, valor: valor, vLiquido: vLiquido, tipo_pg: tipo_pg },
		dataType: 'json',
		success: function (r) {
		
			window.location.reload();

		}
	});
});

function excluir3(obj) {
	var entidade = $(obj).attr('data-entidade');
	var id = $(obj).attr('data-id');
	if (confirm('Deseja realmente excluir?')) {
		window.location.href = base_url + entidade + "/excluir/" + id;
	}
}

function fecharFolha(obj) {
	
	var datafh = $(obj).attr('data-datafh');
	var id = $(obj).attr('data-id');
	if (confirm('Deseja realmente fechar esta folha?')) {
		window.location.href = base_url + "salariofolha/fechafhfunc/" + datafh + "/" + id;
	}
}

function quantAlt(obj) {
	var id = $(obj).attr('data-id');
	alert(id);
}

$('#alteraPedido').submit(function (e) {
	e.preventDefault();
	var id_pedidos = $('#id_pedidos').val();
	var nome = $('#nome').val();
	var quant = $('#quant').val();
	var valor = $('#valorEnc').val();

	$.ajax({
		url: base_url + "Pedidos/alteraPedidoJson/",
		type: 'POST',
		data: { id_pedidos: id_pedidos, nome: nome, quant: quant, valor: valor },
		dataType: 'json',
		success: function (r) {
		
			window.location.reload();
		}
	});
});

$('#alteraPedido2').submit(function (e) {
	e.preventDefault();
	var id_pedidos = $('#id_pedidosPd').val();
	var nome = $('#nomePd').val();
	var quant = $('#quantPd').val();
	var valor = $('#valorPd').val();

	$.ajax({
		url: base_url + "Pedidos/alteraPedido2Json/",
		type: 'POST',
		data: { id_pedidos: id_pedidos, nome: nome, quant: quant, valor: valor },
		dataType: 'json',
		success: function (r) {
		
			window.location.reload();
		}
	});
});

function quantItem() {
	var valorliquido = parseFloat(document.getElementById("valorLiquido").value);
	var quantidade = parseFloat(document.getElementById("quantidadeItem").value);
	var PDESCONTO = parseFloat((quantidade * valorliquido));
	alert(PDESCONTO);
}

function id4(valor_campo3) {
	return document.getElementById(valor_campo3);
};
function getValor(valor_campo3) {
	var valor4 = document.getElementById(valor_campo3).value.replace(',', '.');
	return parseFloat(valor4);
};
//colocar no input onblur="valTotal()"
function valTotal() {
	//calcula
	var total4 = getValor('quantidadeItem') * getValor('valorLiquido');
	//id que vai receber o valor
	id4('totalItem').value = total4.toLocaleString();
}

function abrirModalquantFat(id) {
	var quantiP =  $('#quantParcela').val();
	var id = id + quantiP;
	
	if (id == '#parcela') {
		if (quantiP < 1) {
			alert("Parcelas tem que ser acima de uma.")
			callbreak;
		}
	}
	var alturaTela = $(document).height();
	var larguraTela = $(window).width();

	//colocando o fundo preto
	$('#mascara').css({ 'width': larguraTela, 'height': alturaTela });
	$('#mascara').fadeIn(1000);
	$('#mascara').fadeTo("slow", 0.8);

	var left = ($(window).width() / 2) - ($(id).width() / 2);
	var top = ($(window).height() / 2) - ($(id).height() / 2);

	$(id).css({ 'top': top, 'left': left });
	$(id).show();
	$(window).scrollTop(0);
}

function mostraBtnQuant(e){
	let el = document. getElementById(e);
	var quantiPv =  $('#quantParcela').val();
	if (quantiPv > 0) {
		el. classList. remove('ocDiv');
		el. classList. add('exDiv');
	}
	if(quantiPv < 1){
		el. classList. remove('exDiv');
		el. classList. add('ocDiv');
	}
}

$('#cadParcelas').submit(function () {
	alert('#faturas');
	callbreak;
	e.preventDefault();
	var id_pedidos = $('#id_pedidos').val();
	var nome = $('#nome').val();
	var quant = $('#quant').val();
	var valor = $('#valor2').val();

	$.ajax({
		url: base_url + "Pedidos/alteraPedidoJson/",
		type: 'POST',
		data: { id_pedidos: id_pedidos, nome: nome, quant: quant, valor: valor },
		dataType: 'json',
		success: function (r) {
			
			window.location.reload();
		}
	});
});


