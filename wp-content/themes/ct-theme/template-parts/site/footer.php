<footer class="site-footer">
  <div class="ct-container">
    <div class="site-footer__inner">
      <?php $site_footer = get_field('footer', 'options'); ?>

      <div class="site-footer__info">

        <?php if ($site_footer['logo']) { ?>
          <div class="site-footer__info-logo">
            <?php echo wp_get_attachment_image($site_footer['logo'], 'full') ?>
          </div>
        <?php } ?>

        <?php if ($site_footer['text']) { ?>
          <div class="site-footer__info-description">
            <?php echo $site_footer['text']; ?>
          </div>
        <?php } ?>

        <?php if ($site_footer['brand']) { ?>
          <div class="site-footer__info-brand">
            <?php echo wp_get_attachment_image($site_footer['brand'], 'full') ?>
          </div>
        <?php } ?>

        <?php if (has_nav_menu('social')) {
          wp_nav_menu([
            'theme_location'    => 'social',
            'container'         => false,
            'menu_class'        => 'site-footer__info-social',
          ]);
        } ?>

      </div>

      <?php for ($i = 1; $i <= 3; $i++) { ?>
        <?php if (has_nav_menu('footer-' . $i)) { ?>
          <div class="site-footer__menu">
            <h2 class="site-footer__menu-title"><?php echo wp_get_nav_menu_name('footer-' . $i); ?></h2>
            <?php wp_nav_menu([
              'theme_location'    => 'footer-' . $i,
              'container'         => false,
              'menu_class'        => 'site-footer__menu-list',
            ]); ?>
          </div>
        <?php } ?>
      <?php } ?>

      <?php if (has_nav_menu('footer-contact')) { ?>
        <div class="site-footer__menu site-footer__menu--contact">
          <h2 class="site-footer__menu-title"><?php echo wp_get_nav_menu_name('footer-contact'); ?></h2>
          <?php wp_nav_menu([
            'theme_location'    => 'footer-contact',
            'container'         => false,
            'menu_class'        => 'site-footer__menu-list',
          ]); ?>
        </div>
      <?php } ?>

      <div class="site-footer__copyright">
        <div class="site-footer__copyright-text">
          <span class="site-footer__copyright-text--secondary"><?php echo $site_footer['copyright']['left']; ?></span> <span class="site-footer__copyright-text--primary"><?php echo $site_footer['copyright']['right']; ?></span>
        </div>

        <?php wp_nav_menu([
          'theme_location'    => 'footer-policy',
          'container'         => false,
          'menu_class'        => 'site-footer__copyright-menu',
        ]); ?>
      </div>
    </div>
  </div>
</footer>