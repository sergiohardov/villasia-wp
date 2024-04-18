<?php
/* 
    Template Name: Submit
*/
?>

<?php get_header(); ?>

<div class="page-submit" data-redirect-url="<?php echo get_field('page_submit')['redirect'] ?>">
    <?php get_template_part('template-parts/hero/simple', null, [
        'image' => get_field('page_submit')['image'],
        'title' => get_the_title(),
    ]) ?>

    <div class="ct-container">
        <p class="page-submit__title"><?php the_title() ?></p>
        <div class="page-submit__content">
            <div class="page-submit__img">
                <?php echo wp_get_attachment_image(get_field('page_submit')['image'], 'full') ?>
            </div>
            <div class="page-submit__form">
                <?php echo do_shortcode(get_field('page_submit')['form_shortcode']) ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>