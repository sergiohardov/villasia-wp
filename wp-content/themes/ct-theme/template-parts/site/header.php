<?php global $ct_currency; ?>

<div class="site-header">
    <div class="ct-container">
        <div class="site-header__inner">
            <div class="site-header__info">
                <a class="site-header__info-logo" href="<?php echo home_url() ?>">
                    <?php echo wp_get_attachment_image(get_theme_mod('custom_logo'), 'full'); ?>
                </a>

                <div class="site-header__info-tagline">
                    <span><?php echo get_bloginfo('description', 'display') ?></span>
                </div>
            </div>

            <div class="site-header__controls">
                <button class="site-header__controls-search">
                    <i class="ct-icon ct-icon--outline-search"></i>
                </button>

                <?php if ($args['data']['wishlist_button']) { ?>
                    <a class="site-header__controls-wishlist" href="<?php echo $args['data']['wishlist_button'] ?>">
                        <i class="ct-icon ct-icon--fill-favorite"></i>
                    </a>
                <?php } ?>

                <?php if ($args['currency']) { ?>
                    <div class="site-header__controls-currency ct-dropdown">
                        <button class="ct-dropdown__toggle"><?php echo $ct_currency['title'] ?></button>
                        <ul class="ct-dropdown__menu">
                            <?php foreach ($args['currency'] as $item) { ?>
                                <li data-id="<?php echo $item['id'] ?>"><?php echo $item['title'] . ' ' . $item['mark'] ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>

                <?php if ($args['data']['primary_button']) { ?>
                    <a class="ct-btn site-header__controls-contact" href="<?php echo $args['data']['primary_button']['url'] ?>" target="<?php echo $args['data']['primary_button']['target'] ?>"><?php echo $args['data']['primary_button']['title']; ?></a>
                <?php } ?>
            </div>

            <!-- TODO: Menu -->
            <button class="site-header__burger">
                <i class="ct-icon ct-icon--outline-menu"></i>
                <i class="ct-icon ct-icon--outline-close"></i>
            </button>
        </div>

        <div class="site-header__search">

            <div class="site-header__search-input">
                <i class="ct-icon ct-icon--outline-search"></i>
                <input type="text" placeholder="<?php _e('Search', CTTHEME_LANG_TEXT) ?>">
            </div>

            <ul class="site-header__search-results"></ul>

        </div>
    </div>
</div>