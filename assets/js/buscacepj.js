function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    document.getElementById('nm_rua').value = ("");
    document.getElementById('nm_bairro').value = ("");
    document.getElementById('nm_cidade').value = ("");
    document.getElementById('sg_estado').value = ("");
    document.getElementById('nr_cep').value = ("");
    document.getElementById("nr_cep").focus();
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        document.getElementById('nm_rua').value = (conteudo.logradouro);
        document.getElementById('nm_bairro').value = (conteudo.bairro);
        document.getElementById('nm_cidade').value = (conteudo.localidade);
        document.getElementById('sg_estado').value = (conteudo.uf);
        document.getElementById("nr_numero").focus();
    } //end if.
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
        limpa_formulário_cep();
    }
}


function pesquisacep() {

    //Nova variável "cep" somente com dígitos.
    var cep = $('#nr_cep').val().replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

        //Expressão regular para validar o CEP. .replace(/\D/g, '')
        var validacep = /^[0-9]{8}$/;

        //Valida o formato do CEP.
        if (validacep.test(cep)) {

            //Preenche os campos com "..." enquanto consulta webservice.
            document.getElementById('nm_rua').value = "";
            document.getElementById('nm_bairro').value = "";
            document.getElementById('nm_cidade').value = "";
            document.getElementById('sg_estado').value = ".";


            //Cria um elemento javascript.
            var script = document.createElement('script');

            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);

        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();

    }
};