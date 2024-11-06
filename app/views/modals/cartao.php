<div id="cartao" class="cartao">
    <div class="cartao-content">
        <span class="close">&times;</span>
        <h2>Título do Modal</h2>
        <p>Conteúdo do modal vai aqui.</p>
    </div>
</div>

<style>
    /* Estilos para o modal */
    .cartao {
        display: none;
        position: fixed;
        z-index: 1;
        padding-top: 100px;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .cartao-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<script>
    // Script para abrir e fechar o modal
    const cartao = document.getElementById("cartao");
    const closeBtn = document.querySelector(".close");

    function openModal() {
        cartao.style.display = "block";
    }

    closeBtn.onclick = function() {
        cartao.style.display = "none";

    };
</script>