<header>
    <div align="right"> (<a href='<?php echo site_url('main/logout')?>'" style="padding: 6px 8px 6px 24px;text-shadow: 0 2px 0 #000000;color: #003576;box-shadow: 0 2px 0 #4594d5;border: solid 1px #023156;border-radius: 5px;color: #fff;background: url(../../img/header-sair-icon.jpg) no-repeat 8px 9px #003576;">Sair</a>)</div>
    <nav>
        <ul class="nav">
            <!--<li><a href="index.html" class="icon home"><span>Home</span></a></li>-->
            <li class="dropdown">
                <a href="#">Cadastros</a>
                <ul>
                    <li><a href='<?php echo site_url('main/users')?>'>Obreiros</a></li>
                    <li><a href='<?php echo site_url('main/wives')?>'>Cunhadas</a></li>
                    <li><a href='<?php echo site_url('main/nephews')?>'>Sobrinhos</a></li>
                    <li><a href='<?php echo site_url('main/apprentice_history')?>'>1&ordf; Vigil&acirc;ncia</a></li>
                    <li><a href='<?php echo site_url('main/fellowcraft_history')?>'>2&ordf; Vigil&acirc;ncia</a></li>
                    <li><a href='<?php echo site_url('main/master_history')?>'>Mestres</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Loja</a>
                <ul>
                    <li><a href='<?php echo site_url('main/lodge')?>'>Editar Dados</a></li>
                    <li><a href='<?php echo site_url('main/sessions')?>'>Sessões</a></li>
                    <li><a href='<?php echo site_url('main/documents')?>'>Documentos</a></li>
                    <li><a href='<?php echo site_url('main/calendar')?>'>Agenda</a></li>
                </ul>
            </li>
            <li class="dropdown">
                <a href="#">Financeiro</a>
                <ul class="large">
                    <li><a href='<?php echo site_url('main/financial_entries')?>'>Lançamentos da Loja</a></li>
                    <li><a href='<?php echo site_url('diarybook/')?>'>Caixa Loja</a></li>
                    <li><a href='<?php echo site_url('main/beneficential_entries')?>'>Lançamentos da Hospitalaria</a></li>
                    <li><a href='<?php echo site_url('beneficentialdiarybook/')?>'>Caixa Hospitalaria</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</header>