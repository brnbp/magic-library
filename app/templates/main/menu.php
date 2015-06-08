<?php 
    //echobr('');echobr('');echobr('');
    //printr($_SERVER['REQUEST_URI']);
?>
<br>
<div class="fixed">
    <nav class="top-bar" data-topbar role="navigation">
        <ul class="title-area">
            <li class="name">
                <h1>
                    <a href='/magicPhalcon/'>Home</a>
                </h1>
            </li>
        </ul>

        <section class="top-bar-section">
            <ul class="left">
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
                    <form action="/magicPhalcon/cards/" method="post">
                        <div class="row collapse">
                            <div class="large-10 small-12 columns">
                                <input type="text" placeholder="Find a card" name="card_name">
                            </div>
                            <div class="large-5 small-6 columns">
                                <button class="alert button expand" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                </li>

                <li><a href="<?= $this->link('sign/out') ?>">Sair</a></li>
            </ul>


        </section>
    </nav>
</div>
<br><br>