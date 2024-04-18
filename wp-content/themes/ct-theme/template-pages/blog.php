<?php
global $wp_query;

$page_data = [
    'category' => is_category() ? get_category(get_query_var('cat'))->slug : '',
    'max_page' => $wp_query->max_num_pages,
    'categories' => [
        [
            'name' => __('Latest', CTTHEME_LANG_TEXT),
            'slug' => 'latest',
            'current' => is_home(),
            'url' => get_permalink(get_option('page_for_posts')),
        ],
    ]
];

$post_categories = get_terms([
    'taxonomy' => 'category',
    'type' => 'post',
]);

foreach ($post_categories as $category) {
    $page_data['categories'][] = [
        'name' => $category->name,
        'slug' => $category->slug,
        'url' => get_term_link($category),
        'current' => is_category($category->term_id),
    ];
}

?>

<div class="page-blog" data-category="<?php echo $page_data['category'] ?>" data-max-page="<?php echo $page_data['max_page'] ?>">

    <?php get_template_part('template-parts/hero/simple', null, [
        'image' => get_post_thumbnail_id(get_option('page_for_posts')),
        'title' => get_the_title(get_option('page_for_posts')),
    ]) ?>

    <div class="ct-container">

        <div class="page-blog__nav">
            <div class="page-blog__nav__container">
                <div class="page-blog__nav__swiper swiper">
                    <div class="page-blog__nav__wrapper swiper-wrapper">
                        <?php foreach ($page_data['categories'] as $i => $category) { ?>
                            <div class="page-blog__nav__slide swiper-slide">
                                <a class="page-blog__nav__link <?php if ($category['current']) echo 'current' ?>" data-category-loop-id="<?php echo $i; ?>" href="<?php echo $category['url'] ?>">
                                    <?php echo $category['name'] ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (have_posts()) { ?>
            <div class="page-blog__posts">
                <?php while (have_posts()) {
                    the_post();
                    get_template_part('template-parts/card/post');
                } ?>
            </div>
            <?php if ($page_data['max_page'] > 1) { ?>
                <div class="page-blog__more">
                    <button class="page-blog__more-btn ct-btn-primary ct-icon" data-btn-size="l" data-icon-pos="right"><?php _e('Load More', CTTHEME_LANG_TEXT) ?></button>
                </div>
            <?php } ?>
        <?php } else { ?>
            <h2><?php _e('No posts...', CTTHEME_LANG_TEXT) ?></h2>
        <?php } ?>

    </div>
</div>