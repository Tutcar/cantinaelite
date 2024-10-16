$(function () {

    $('input[name=small]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor do pr贸ximo small" });
    $('input[name=ante]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor do ante" });
    $('input[name=valor_arrecadado]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor arrecadado" });
    $('input[name=valor_rake]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor do rake" });
    $('input[name=divisao_entre]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor da divis茫o" });
    $('input[name=valor_desp]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor da despesa" });
    $('input[name=premio]').mask('000.000.000.000.000,000', { reverse: true, placeholder: "Insira o valor do premio" });
    $('input[name=pontos]').mask('000.000.000.000.000,000', { reverse: true, placeholder: "Insira o valor dos pontos" });
    $('input[name=dinheiro]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor arrecadado" });
    $('input[name=desconto]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor arrecadado" });
    $('input[name=entrada]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor arrecadado" });
    $('input[name=retirada]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor arrecadado" });
    $('input[name=custo]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor arrecadado" });
    $('input[name=venda]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor arrecadado" });
    $('input[name=valor_debito]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor debito" });
    $('input[name=valor_credito]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor credito" });
    $('input[name=valor]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor credito" });
    $('input[name=valor_nf]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Insira o valor" });
    $('input[name=nf_preco]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor unitario nf" });
    $('input[name=nf_desc]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor desconto nf" });
    $('input[name=ft_valor]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor desconto nf" });
    $('input[name=ft_valor_pg]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor pagamento" });
    $('input[name=salario]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor salário" });
    $('input[name=sl_comissao]').mask('00,00', { reverse: true, placeholder: "Percentual comissão" });
    $('input[name=ac_valor]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor acréscimo" });
    $('input[name=db_valor]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor débito" });
    $('input[name=aumento]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor aumento" });
    $('input[name=valorEnc]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor aumento" });
     $('input[name=limite]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Limite aluno" });
});
function checkRodada(rodada) {

    if (document.getElementById('rodada').value.length < 1) {
        alert('Por favor, preencha o campo Rodada!');
        document.getElementById('rodada').value = "";
        document.getElementById("rodada").focus();
        return false
    } else {

        $.ajax({
            'url': base_url + "premiacao/premia/" + rodada,
            'type': "GET",
            'dataType': 'json',
            'success': function (data) {
                document.getElementById('valor_arrecadado').value = data['valorArrecadado'].toLocaleString('pt-br', { minimumFractionDigits: 2 });
                document.getElementById('valor_rake').value = data['percentualRake'].toLocaleString('pt-br', { minimumFractionDigits: 2 });
                document.getElementById('divisao_entre').value = (data['valorArrecadado'] - data['percentualRake']).toLocaleString('pt-br', { minimumFractionDigits: 2 });
                document.getElementById('valor_pago').value = (data['valorArrecadado'] - data['percentualRake']).toLocaleString('pt-br', { minimumFractionDigits: 2 });
                document.getElementById('id_etapas').value = data['id_etapas'];

            }
        });
    }

}
function showOlh() {
    var senha = document.getElementById("senha");
    if (senha.type === "password") {
        senha.type = "text";
    } else {
        senha.type = "password";
    }
}

function mudarType(value) {
    if (value === "descricao") {
        limparType(value);
        document.getElementById('confData').type = 'text';
    } else if (value === "nr_doc_banco") {
        limparType(value);
        document.getElementById('confData').type = 'text';
    } else if (value === "confirma") {
        limparType(value);
        document.getElementById('confData').type = 'text';
        document.getElementById('confData').value = 'S';
        $("#btnConf").click();
    } else if (value === "confirmaN") {
        limparType(value);
        document.getElementById('confData').type = 'text';
        document.getElementById('confData').value = 'N';
        $("#btnConf").click();
    } else if (value === "confirmaU") {
        limparType(value);
        document.getElementById('confData').type = 'text';
        var compens = document.getElementById('confCompensado').value;
        if (compens || "") {
            document.getElementById('confData').value = compens;
            $("#btnConf").click();
        }
    } else if (value === "data_comp") {
        document.getElementById('confData').value = '';
        document.getElementById('confData').type = 'date';
    } else if (value === "data_confirma") {
        limparType(value);
        document.getElementById('confData').type = 'date';
    } else if (value === "cod_despesa") {
        limparType(value);
        document.getElementById('confData').type = 'text';
    } else if (value === "obs") {
        limparType(value);
        document.getElementById('confData').type = 'text';
    } else if (value === "data_cad") {
        limparType(value);
        document.getElementById('confData').type = 'date';
    } else if (value === "data_cond") {
        document.getElementById('confData').value = '';
        document.getElementById('confData').type = 'date';
    } else if (value === "valor_credito") {
        limparType(value);
        $('input[name=valor2]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor credito" });
    } else if (value === "valor_debito") {
        limparType(value);
        $('input[name=valor2]').mask('000.000.000.000.000,00', { reverse: true, placeholder: "Valor debito" });
    } else if (value === "data_compM") {
        document.getElementById('confData').value = '';
        document.getElementById('confData').type = 'date';
        var data = new Date();
        var dia = String(data.getDate()).padStart(2, '0');
        var mes = String(data.getMonth() + 1).padStart(2, '0');
        var ano = data.getFullYear();
        dataAtual = dia + '/' + mes + '/' + ano;
        document.getElementById('confData').value = dataAtual;
        $("#btnConf").click();
    }

}

function limparType(value) {
    document.getElementById('confData').value = '';
    if (value === "valor_credito" || value === "valor_debito") {
        document.getElementById('confData').value = '0';
        $("#confValor").show();
        $("#confData").hide();
    } else {
        $("#confValor").hide();
        $("#confData").show();
    }

}
function validaCampoCredito() {
    if (document.getElementById('valor_debito').value > '0' && document.getElementById('valor_credito').value > '0') {
        document.getElementById('valor_debito').value = '0';
    }
}
function validaCampoDebito() {
    if (document.getElementById('valor_credito').value > '0' && document.getElementById('valor_debito').value > '0') {
        document.getElementById('valor_credito').value = '0';
    }
} 