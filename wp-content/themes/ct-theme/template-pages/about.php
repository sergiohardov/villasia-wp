<?php
/* 
    Template Name: About
*/
?>

<?php get_header(); ?>

<div class="page-about">

    <?php get_template_part('template-parts/hero/simple', null, [
        'image' => get_field('hero_simple')['background'],
        'title' => get_field('hero_simple')['title'],
    ]) ?>

    <div class="page-about__content">
        <div class="ct-container">
            <div class="page-about__description">
                <?php echo get_field('description') ?>
            </div>

            <?php if (get_field('media_text')) { ?>
                <div class="page-about__media">
                    <div class="page-about__media-list">
                        <?php foreach (get_field('media_text') as $item) { ?>
                            <div class="page-about__media-item">
                                <div class="page-about__media-item__image">
                                    <?php echo wp_get_attachment_image($item['image'], 'full') ?>
                                </div>
                                <div class="page-about__media-item__content">
                                    <h2 class="page-about__media-item__title"><?php echo $item['title'] ?></h2>
                                    <div class="page-about__media-item__description"><?php echo $item['description'] ?></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

</div>

<?php get_footer(); ?>