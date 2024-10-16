<section class="caixa">
    <div class="thead"><i class="ico home"></i> Painel Administrativo: </div>
    <div class="base-home">
        <h2 class="titulo">
            <?php
            $this->verMsg();
            $this->verErro();
            ?>
            <?php echo empty($compromisso) ? ""   : "<P style='color:#4C3C94' class='piscar'>Verifique os compromissos.</P>" ?>
        </h2>
        <!-- Contenedor -->
        <ul id="accordion" class="accordion">
            <li>
                <div class="link"><i class="fa fa-database"></i>Cadastros<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="<?php echo URL_BASE . "Produtos/index" ?>">Produtos</a></li>
                    <li><a href="<?php echo URL_BASE . "Cardapio/index" ?>">Cardápio</a></li>
                    <li><a href="<?php echo URL_BASE . "Cliente/index" ?>">Alunos</a></li>
                    <li><a href="<?php echo URL_BASE . "User/index" ?>">Usuário</a></li>
                </ul>
            </li>
            <li>
                <div class="link"><i class="fa fa-database"></i>Caixa<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="<?php echo URL_BASE . "Caixaabre/index" ?>">Abrir</a></li>
                    <li><a href="<?php echo URL_BASE . "Caixafecha/index" ?>">Fechar</a></li>
                    <li><a href="<?php echo URL_BASE . "Encomendas/index" ?>">Encomendas</a></li>
                </ul>
            </li>
            <li>
                <div class="link"><i class="fa fa-database"></i>Créditos Alunos<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="<?php echo URL_BASE . "corretora/index" ?>">Contas</a></li>
                </ul>
            </li>
            <li>
                <div class="link"><i class="fa fa-database"></i>Home<i class="fa fa-chevron-down"></i></div>
                <ul class="submenu">
                    <li><a href="<?php echo URL_BASE ?>">Home Page</a></li>
                </ul>
            </li>
        </ul>

    </div>
</section>
<script>
    $(function() {
        var Accordion = function(el, multiple) {
            this.el = el || {};
            this.multiple = multiple || false;

            // Variables privadas
            var links = this.el.find('.link');
            // Evento
            links.on('click', {
                el: this.el,
                multiple: this.multiple
            }, this.dropdown)
        }

        Accordion.prototype.dropdown = function(e) {
            var $el = e.data.el;
            $this = $(this),
                $next = $this.next();

            $next.slideToggle();
            $this.parent().toggleClass('open');

            if (!e.data.multiple) {
                $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
            };
        }

        var accordion = new Accordion($('#accordion'), false);
    });
</script>