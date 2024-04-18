<?php
/* 
    Template Name: Inquiry
*/
?>

<?php get_header(); ?>

<div class="page-inquiry" data-redirect-url="<?php echo get_field('inquiry')['redirect'] ?>">
    <input id="villaID" type="hidden" value="<?php echo $_GET['villa_id'] ?>">

    <?php get_template_part('template-parts/hero/simple', null, [
        'image' => get_field('inquiry')['image'],
        'title' => get_the_title(),
    ]) ?>

    <div class="ct-container">
        <p class="page-inquiry__title"><?php the_title() ?></p>

        <div class="page-inquiry__content">
            <div class="page-inquiry__card">
                <?php get_template_part('template-parts/card/inquiry'); ?>
            </div>
            <div id="inquiryForm" class="page-inquiry__form">
                <?php echo do_shortcode(get_field('inquiry')['form_shortcode']) ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>