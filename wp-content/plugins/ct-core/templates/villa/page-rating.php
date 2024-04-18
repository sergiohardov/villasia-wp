<div class="wrap">
    <div class="villa-page-rating" data-api-key="<?php echo CTCORE_REST_API_TOKEN ?>" data-rest-url="<?php echo get_rest_url(null, 'ctcore/ratings/v1/') ?>">
        <div class="villa-page-rating__title">
            <h1>Villa Ratings & Reviews</h1>
        </div>

        <div class="villa-page-rating__update">
            <div class="villa-page-rating__update-status">
                <textarea rows="20" readonly></textarea>
            </div>
            <div class="villa-page-rating__update-btn">
                <button class="button button-primary button-large">Update</button>
                <span class="spinner"></span>
            </div>
        </div>

        <div class="villa-page-rating__list">
            <div class="villa-page-rating__list-bg">
                <i>Reload page to update list</i>
            </div>
            <h2 class="villa-page-rating__list-title">Villas without rating or reviews</h2>
            <?php if ($args['query']->have_posts()) { ?>
                <ol class="villa-page-rating__list-items">
                    <?php while ($args['query']->have_posts()) { ?>
                        <?php $args['query']->the_post(); ?>
                        <li><a href="<?php echo get_edit_post_link(get_the_ID()) ?>"><?php the_title() ?></a></li>
                    <?php } ?>
                    <?php wp_reset_postdata(); ?>
                </ol>
            <?php } else { ?>
                <p>All villas have ratings & reviews.</p>
            <?php } ?>
        </div>
    </div>
</div>