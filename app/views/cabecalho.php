
<header class="topo">

    <div class="conteudo">

        <a href="" class="mobmenu"></a>

        <nav hidden class="menutopo">

            <div class="sidenav">

                <ul>
                    <?php if ($_SESSION[SESSION_LOGIN]->id_user == 1) : ?>
                        <li><a href="<?php echo URL_BASE . "user/edit/" . $_SESSION[SESSION_LOGIN]->id_user ?>"><i class="ico usuario"></i>Usuário</a></li>
                    <?php endif; ?>
                    <?php if ($_SESSION["verifCx"] > 0) : ?>
                        <li><a href="<?php echo URL_BASE . "compromisso/pedidosDia" ?>"><i class="ico sair"></i>Pedidos</a></li>
                    <?php endif; ?>
                    <?php if ($_SESSION["verifCx"] > 0) : ?>
                        <li><a href="<?php echo URL_BASE . "home" ?>"><i class="ico sair"></i>Caixa</a></li>
                    <?php endif; ?>
                    <?php if ($_SESSION[SESSION_LOGIN]->id_user == 1) : ?>
                        <li><a href="<?php echo URL_BASE . "painel/index"  ?>"><i class="ico sair"></i>Painel</a></li>
                    <?php endif; ?>
                    <li><a href="<?php echo URL_BASE . "login/logoff" ?>"><i class="ico sair"></i>Sair</a></li>

                </ul>

            </div>

        </nav>


        <nav class="menu">
            <ul>
                <?php if ($_SESSION[SESSION_LOGIN]->id_user == 1) : ?>
                    <li><a href="<?php echo URL_BASE . "user/edit/" . $_SESSION[SESSION_LOGIN]->id_user ?>"><i class="ico usuario"></i>Usuário</a></li>
                <?php endif; ?>
                <?php if ($_SESSION["verifCx"] > 0) : ?>
                    <li><a href="<?php echo URL_BASE . "compromisso/pedidosDia" ?>"><i class="ico sair"></i>Pedidos</a></li>
                <?php endif; ?>
                <?php if ($_SESSION["verifCx"] > 0) : ?>
                    <li><a href="<?php echo URL_BASE . "home" ?>"><i class="ico sair"></i>Caixa</a></li>
                <?php endif; ?>
                <?php if ($_SESSION[SESSION_LOGIN]->id_user == 1) : ?>
                    <li><a href="<?php echo URL_BASE . "painel/index"  ?>"><i class="ico sair"></i>Painel</a></li>
                <?php endif; ?>
                <li><a href="<?php echo URL_BASE . "login/logoff" ?>"><i class="ico sair"></i>Sair</a></li>
            </ul>
        </nav>
    </div>
</header>