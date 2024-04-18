<div class="page-post">

    <?php get_template_part('template-parts/site/breadcrumbs') ?>

    <div class="ct-container">
        <div class="page-post__inner">

            <h1 class="page-post__title"><?php the_title() ?></h1>

            <p class="page-post__info">
                <span class="page-post__info-author">
                    <?php echo __('By', CTTHEME_LANG_TEXT) . ' ' . get_the_author_meta('display_name', get_post_field('post_author', get_the_ID())); ?>
                </span>
                <span class="page-post__info-date">
                    <?php echo '- ' . get_the_time('j F Y') ?>
                </span>
            </p>

            <div class="page-post__thumbnail">
                <?php the_post_thumbnail() ?>
            </div>

            <div class="page-post__content">
                <?php the_content() ?>
            </div>

            <?php if (get_the_category()) { ?>
                <div class="page-post__categories">
                    <?php foreach (get_the_category() as $category) { ?>
                        <a class="page-post__categories-item" href="<?php echo get_category_link($category) ?>"><?php echo $category->name ?></a>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>