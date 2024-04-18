<section class="home-hero">

    <div class="home-hero__inner">
        <div class="home-hero__background">
            <?php echo wp_get_attachment_image($args['background'], 'full'); ?>
        </div>

        <div class="home-hero__content">
            <div class="ct-container">
                <div class="home-hero__content__inner">
                    <h1 class="home-hero__title"><?php echo $args['title'] ?></h1>
                    <?php get_template_part('template-parts/search/bar') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="home-hero__outer">
        <div class="ct-container">

        </div>
    </div>
</section>