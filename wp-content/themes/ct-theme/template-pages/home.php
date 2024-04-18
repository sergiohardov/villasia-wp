<?php
/* 
    Template Name: Home
*/
?>

<?php get_header(); ?>

<div class="page-home">
    <?php get_template_part('template-parts/home/hero', null, [
        'background' => get_field('home_hero')['background'],
        'title' => get_field('home_hero')['title']
    ]) ?>

    <?php get_template_part('template-parts/slider-locations', null, [
        'title' => get_field('slider_locations')['title'],
        'locations' => get_field('slider_locations')['locations'],
    ]) ?>

    <?php get_template_part('template-parts/home/promotions', null, [
        'title' => get_field('home_promotions')['title'],
        'villas' => ct_core_get_villa_has_promotion(get_field('home_promotions')['count'])
    ]) ?>

    <?php get_template_part('template-parts/home/blog', null, [
        'title' => get_field('home_blog')['title']
    ]) ?>

    <?php get_template_part('template-parts/home/instagram', null, [
        'title' => get_field('home_instagram')['title'],
        'media' => ct_theme_get_instagram_feed(),
    ]) ?>
</div>


<?php get_footer(); ?>