<?php
/* 
    Template Name: Contact
*/
?>

<?php get_header(); ?>

<div class="page-contact" data-redirect-url="<?php echo get_field('contact')['redirect'] ?>">

    <div class="ct-container">
        <p class="page-contact__title"><?php the_title() ?></p>

        <div class="page-contact__content">
            <div class="page-contact__card">
                <div class="page-contact__card-image">
                    <?php echo wp_get_attachment_image(get_field('contact')['image'], 'full') ?>
                </div>
                <div class="page-contact__card-content">
                    <h2 class="page-contact__card-title"><?php the_title() ?></h2>

                    <?php wp_nav_menu([
                        'theme_location'    => 'footer-contact',
                        'container'         => false,
                        'menu_class'        => 'page-contact__card-base',
                    ]); ?>

                    <?php wp_nav_menu([
                        'theme_location'    => 'social',
                        'container'         => false,
                        'menu_class'        => 'page-contact__card-social',
                    ]); ?>

                </div>
            </div>
            <div class="page-contact__form">
                <?php echo do_shortcode(get_field('contact')['form_shortcode']) ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>