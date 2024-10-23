// Armazena os itens do carrinho
let carrinho = [];
let total = 0;

document.addEventListener('DOMContentLoaded', () => {
    // Verifica se há itens no carrinho da sessão
    if (carrinhoSessao.length > 0) {
        carrinho = carrinhoSessao;

        // Calcula o total e renderiza o carrinho
        carrinho.forEach(item => {
            total += item.preco;
        });

        renderizarCarrinho();
        atualizarContador(); // Atualiza o contador do carrinho
    }
});

// Função para atualizar o badge de quantidade
function atualizarContador() {
    const countElement = document.getElementById('cart-count');
    const count = carrinho.length;
    countElement.textContent = count;
    if(count > 0){
        countElement.style.display = 'block';
    } else {
        countElement.style.display = 'none';
    }
}
function getSelectedPrice(idProduto) {
    // Pegamos todos os radio buttons com o nome do produto específico
    const radios = document.getElementsByName('preco_' + idProduto);
    
    for (let i = 0; i < radios.length; i++) {
        if (radios[i].checked) {
            // Retornamos o valor do radio button selecionado
            return parseFloat(radios[i].value);
        }
    }

    return 0; // Caso não seja encontrado (o que não deve ocorrer se um está marcado por padrão)
}

// Função para adicionar um item ao carrinho
function adicionarAoCarrinho(idProduto, categoriaProduto, nomeProduto, precoProduto, event) {
    event.preventDefault();
    precoProduto = parseFloat(precoProduto.toString().replace(',', '.'));
    if (precoProduto > 0) {
        carrinho.push({
            id: idProduto,
            categoria: categoriaProduto,
            nome: nomeProduto,
            preco: precoProduto
        });

        total += precoProduto;
        renderizarCarrinho();
        atualizarContador();
        salvarCarrinhoNaSessao(); // Salva o carrinho na sessão após adicionar um item
    } else {
        alert('Por favor, selecione um preço válido.');
    }
}


// Função para remover um item do carrinho
function removerDoCarrinho(index) {
    total -= carrinho[index].preco;
    carrinho.splice(index, 1);
    renderizarCarrinho();
    atualizarContador();
    salvarCarrinhoNaSessao(); // Salva o carrinho na sessão após remover um item
    buscarTotalCarrinho();  // Chama a função para atualizar o total
}

// Função para renderizar os itens do carrinho no modal
function renderizarCarrinho() {
    const carrinhoElement = document.getElementById('cart');
    const totalElement = document.getElementById('totalcart');

    carrinhoElement.innerHTML = '';

    carrinho.forEach((item, index) => {
        const li = document.createElement('li');
        const precoFormatado = item.preco.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        
        const itemInfo = document.createElement('div');
        itemInfo.className = 'item-info';
        itemInfo.textContent = `${item.nome} - ${precoFormatado}`;

        const btnRemover = document.createElement('button');
        const icon = document.createElement('i');
        icon.className = 'fa-solid fa-trash'; // Alterado para um ícone de lixeira comum
        btnRemover.appendChild(icon);
        btnRemover.onclick = () => removerDoCarrinho(index);

        li.appendChild(itemInfo);
        li.appendChild(btnRemover);
        carrinhoElement.appendChild(li);
    });

    totalElement.textContent = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

// Inicializa o contador na carga da página
document.addEventListener('DOMContentLoaded', () => {
    atualizarContador();

    // Implementação do modal (abrir, fechar)
    const modal = document.getElementById('myModal');
    const btnOpenModal = document.getElementById('openModal');
    const btnCloseModal = document.getElementById('closeModal');

    btnOpenModal.onclick = () => {
        modal.style.display = 'block';
    }

    btnCloseModal.onclick = () => {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }

    // Implementação do botão de pagamento
        
    const botaoPagamento = document.getElementById('botaoPagamento');
    botaoPagamento.onclick = function() {
        if (total > 0) {
            window.location.href =  base_url + "Homepage/cadastrar_carrinho/?saldo=1"; // Altere para a URL real da página de pagamento
        } else {
            alert('Seu carrinho está vazio. Adicione itens antes de continuar.');
        }
    }
    const botaoPagamento2 = document.getElementById('botaoPagamento2');
    botaoPagamento2.onclick = function() {
        if (total > 0) {
            window.location.href =  base_url + "Homepage/cadastrar_carrinho/?saldo=2"; // Altere para a URL real da página de pagamento
        } else {
            alert('Seu carrinho está vazio. Adicione itens antes de continuar.');
        }
    }
});

function salvarCarrinhoNaSessao() {
    // Envia os dados do carrinho via AJAX para o PHP
    fetch(base_url + "Homepage/salvar_carrinho/", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(carrinho),
    })
    .then(response => response.json())
    .then(data => {
        console.log('Carrinho salvo na sessão:', data);
        // Mensagem de confirmação ao usuário
    })
    .catch((error) => {
        console.error('Erro ao salvar o carrinho:', error);
    });
}

function buscarTotalCarrinho() {
    fetch(base_url + "Homepage/obter_total_carrinho", {
        method: 'GET',
    })
    .then(response => response.json())
    .then(data => {
        if (data.total) {
            document.getElementById('totalcart').textContent = data.total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        }
    })
    .catch((error) => {
        console.error('Erro ao buscar o total do carrinho:', error);
    });
}
// Aguarde o carregamento do DOM
document.addEventListener("DOMContentLoaded", function() {
    // Obtenha o modal
    var modal = document.getElementById("myModalcarda");

    // Obtenha o link que abre o modal
    var openModalLink = document.getElementById("openModalLink");

    // Obtenha o elemento <span> que fecha o modal
    var span = document.getElementsByClassName("closecarda")[0];

    // Verifique se o link existe antes de tentar adicionar o evento
    if (openModalLink) {
        openModalLink.onclick = function(event) {
            event.preventDefault(); // Evita o comportamento padrão do link
            modal.style.display = "block";
        }
    }

    // Quando o usuário clicar em <span> (x), fecha o modal
    if (span) {
        span.onclick = function() {
            modal.style.display = "none";
        }
    }

    // Quando o usuário clicar em qualquer lugar fora do modal, fecha-o
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

//alt us
// Abrir o modal
document.getElementById('openModalus').onclick = function(event) {
    event.preventDefault();
    document.getElementById('changePasswordModal').style.display = "block";
  };
  
  // Fechar o modal
  document.getElementsByClassName('closeus')[0].onclick = function() {
    document.getElementById('changePasswordModal').style.display = "none";
  };
  
  // Fechar o modal ao clicar fora do conteúdo
  window.onclick = function(event) {
    if (event.target == document.getElementById('changePasswordModal')) {
      document.getElementById('changePasswordModal').style.display = "none";
    }
  };

  //alt cr
// Abrir o modal
document.getElementById('openModalcr').onclick = function(event) {
    event.preventDefault();
    document.getElementById('creditos').style.display = "block";
  };
  
  // Fechar o modal
  document.getElementsByClassName('closecr')[0].onclick = function() {
    document.getElementById('creditos').style.display = "none";
  };
  
  // Fechar o modal ao clicar fora do conteúdo
  window.onclick = function(event) {
    if (event.target == document.getElementById('credito')) {
      document.getElementById('crditos').style.display = "none";
    }
  };
  document.getElementById('currency').addEventListener('input', function (e) {
    let value = e.target.value;

    // Remove qualquer caractere que não seja número
    value = value.replace(/\D/g, '');

    // Formata para moeda (BRL)
    value = (value / 100).toFixed(2) // Divide por 100 e fixa duas casas decimais
               .replace('.', ',')    // Substitui o ponto por vírgula
               .replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Adiciona pontos nos milhares

    e.target.value = value ? 'R$ ' + value : '';
});

document.getElementById('formulario').addEventListener('submit', function (e) {
    e.preventDefault(); // Impede o envio automático do formulário

    let valor = document.getElementById('currency').value;

    // Solicita a confirmação do usuário
    if (confirm(`O valor inserido é ${valor}. Está correto?`)) {
        // Se o usuário confirmar, o formulário é enviado
        e.target.submit();
    } else {
        // Se o usuário cancelar, o envio é interrompido
        alert('Por favor, corrija o valor.');
    }
});
// Obter o modal pix
var modalpix = document.getElementById("qrcodeModal");

// Obter o botão que abre o modal
var btn = document.getElementById("openModalpix");

// Obter o <span> que fecha o modal
var span = document.getElementsByClassName("close")[0];

// Quando o usuário clicar no botão, abre o modal
btn.onclick = function() {
    modalpix.style.display = "block";
}

// Quando o usuário clicar no <span> (x), fecha o modal
span.onclick = function() {
    modalpix.style.display = "none";
}

// Quando o usuário clicar fora do modal, fecha o modal
window.onclick = function(event) {
    if (event.target == modalpix) {
        modalpix.style.display = "none";
    }
}
