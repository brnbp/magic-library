<div class="fixed">
    <nav class="top-bar docs-bar hide-for-small" data-topbar="" role="navigation">
        <ul class="title-area">
            <li class="name">
                <h1>
                    <a href='<?= $this->link('./')?>'>Home</a>
                </h1>
            </li>
        </ul>

        <section class="top-bar-section small-3">
            <ul class="left large-5 small-3 columns">
                <?php foreach ($template_menu as $name => $link):
                    $template_menu_class = '';
                    $template_option = str_replace('/', '', str_replace(ROOT_DIR, '', $_SERVER['REQUEST_URI']));
                    if ($link == $template_option) $template_menu_class = 'active';
                    ?>
                    <li class="<?= $template_menu_class ?>"> <a href="<?= $this->link($link); ?>"><?= $name ?></a></li>
                <?php endforeach; ?>
            </ul>
            <?php if ($_SERVER['REQUEST_URI'] == '/magicPhalcon/user/wishlist') : ?>
            <ul>
                <li style="margin-left: 15%">
                    <button class="tiny info" >Exportar wishlist para .pdf</button>
                </li>
            </ul>
        <?php endif; ?>

            <ul class="right">
                <li class="has-form">
                    <form action="<?= $this->link('cards/')?>" method="post">
                        <div class="row collapse">
                            <div class="large-10 small-8 columns">
                                <input type="text" placeholder="Find a card" name="card_name">
                            </div>
                            <div class="large-5 small-3 columns">
                                <button class="alert button expand" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </li>
             <li><a href="<?= $this->link('sign')?>">Entrar</a></li>
                <li><a href="<?= $this->link('sign/out') ?>">Sair</a></li>
            </ul>


        </section>
    </nav>

    <nav class="tab-bar show-for-small"> 
        <div class="off-canvas-wrap docs-wrap" data-offcanvas="">
          <div class="inner-wrap">
            <nav class="tab-bar">
              <section class="left-small">
                <a aria-expanded="false" class="left-off-canvas-toggle menu-icon"><span></span></a>
              </section>

              <section class="right tab-bar-section">
                <form action="<?= $this->link('cards/')?>" method="post">
                    <div class="row collapse">
                        <div class="large-10 small-8 columns">
                            <input type="text" placeholder="Find a card" name="card_name">
                        </div>
                        <div class="large-5 small-3 columns">
                            <button class="alert button expand" type="submit">Search</button>
                        </div>
                    </div>
                </form>
              </section>
            </nav>

            <aside class="left-off-canvas-menu">
              <ul class="off-canvas-list">
                <li><label>Foundation</label></li>
                <li><a href="#">The Psychohistorians</a></li>
                <li><a href="#">The Encyclopedists</a></li>
                <li><a href="#">The Mayors</a></li>
                <li><a href="#">The Traders</a></li>
                <li><a href="#">The Merchant Princes</a></li>
                <li><label>Foundation and Empire</label></li>
                <li><a href="#">The General</a></li>
                <li><a href="#">The Mule</a></li>
                <li><label>Second Foundation</label></li>
                <li><a href="#">Search by the Mule</a></li>
                <li><a href="#">Search by the Foundation</a></li>
              </ul>
            </aside>

            <aside class="right-off-canvas-menu">
              <ul class="off-canvas-list">
                <li><label>Users</label></li>
                <li><a href="#">Hari Seldon</a></li>
                <li><a href="#">R. Giskard Reventlov</a></li>
                <li><a href="#">R. Daneel Olivaw</a></li>
                <li><a href="#">The Mule</a></li>
                <li><a href="#">Dors Venabili</a></li>
                <li><a href="#">Yugo Amaryl</a></li>
                <li><a href="#">The Mule</a></li>
                <li><a href="#">Emperor Cleon I</a></li>
                <li><a href="#">Gaal Dornick</a></li>
                <li><a href="#">Bel Riose</a></li>
                <li><a href="#">Salvor Hardin</a></li>
                <li><a href="#">Bel Riose</a></li>
              </ul>
            </aside>
          </div>
        </div>
    </nav>
</div>

<?php

?>
<br><br><br><br>