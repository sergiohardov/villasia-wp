<section class="site-popular">
    <div class="ct-container">

        <div class="ct-tabs">
            <div class="ct-tabs__nav">
                <button class="ct-tabs__nav-item ct-tabs__nav-item--active"><?php echo wp_get_nav_menu_name('popular-search'); ?></button>
                <button class="ct-tabs__nav-item"><?php echo wp_get_nav_menu_name('holiday-themes'); ?></button>
            </div>

            <div class="ct-tabs__content">
                <div class="ct-tabs__content-item ct-tabs__content-item--active">
                    <h2 class="site-popular__title"><?php echo wp_get_nav_menu_name('popular-search'); ?></h2>
                    <?php if (has_nav_menu('popular-search')) {
                        wp_nav_menu([
                            'theme_location'    => 'popular-search',
                            'container'         => false,
                            'menu_class'        => 'site-popular__list site-popular__list--left',
                        ]);
                    } ?>
                </div>

                <div class="site-popular__line"></div>

                <div class="ct-tabs__content-item">
                    <h2 class="site-popular__title"><?php echo wp_get_nav_menu_name('holiday-themes'); ?></h2>
                    <?php if (has_nav_menu('holiday-themes')) {
                        wp_nav_menu([
                            'theme_location'    => 'holiday-themes',
                            'container'         => false,
                            'menu_class'        => 'site-popular__list site-popular__list--right',
                        ]);
                    } ?>
                </div>
            </div>

        </div>
    </div>
</section>