<?php get_header(); ?>

<div class="page-404">

    <div class="page-404__content">
        <div class="ct-container">
            <div class="page-404__inner">
                <h1 class="page-404__title"><?php echo get_field('not_found', 'options')['title'] ?></h1>

                <?php get_template_part('template-parts/search/bar') ?>
            </div>

        </div>
    </div>

    <?php get_template_part('template-parts/slider-locations', null, [
        'title' => get_field('not_found', 'options')['slider_locations']['title'],
        'content' => get_field('not_found', 'options')['slider_locations']['content'],
        'locations' => get_field('not_found', 'options')['slider_locations']['locations'],
    ]) ?>
</div>

<?php get_footer(); ?>