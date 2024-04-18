<?php
/* 
    Template Name: Managment
*/
?>

<?php get_header(); ?>

<div class="page-managment">

    <?php get_template_part('template-parts/hero/simple', null, [
        'image' => get_field('hero_simple')['background'],
        'title' => get_field('hero_simple')['title'],
    ]) ?>

    <div class="page-managment__content">
        <div class="ct-container">
            <div class="page-managment__media page-managment__media--top">
                <?php $media_top_data = [
                    'image' => get_field('media_top')['image'],
                    'title' => get_field('media_top')['title'],
                    'desc' => get_field('media_top')['description']
                ] ?>
                <div class="page-managment__media-img">
                    <?php echo wp_get_attachment_image($media_top_data['image'], 'full') ?>
                </div>
                <div class="page-managment__media-content">
                    <h2 class="page-managment__media-title"><?php echo $media_top_data['title'] ?></h2>
                    <div class="page-managment__media-text"><?php echo $media_top_data['desc'] ?></div>
                </div>
            </div>
            <div class="page-managment__services">
                <?php $services_data = [
                    'title' => get_field('services')['title'],
                    'items' => get_field('services')['items']
                ] ?>

                <h2 class="page-managment__services-title"><?php echo $services_data['title'] ?></h2>

                <?php if ($services_data['items']) { ?>
                    <div class="page-managment__services-list">
                        <?php foreach ($services_data['items'] as $item) { ?>
                            <div class="page-managment__services-item">
                                <div class="page-managment__services-item__img">
                                    <?php echo wp_get_attachment_image($item['image'], 'full') ?>
                                </div>
                                <h3 class="page-managment__services-item__title"><?php echo $item['title'] ?></h3>
                                <div class="page-managment__services-item__desc"><?php echo $item['description'] ?></div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
            <div class="page-managment__description">
                <?php $description_data = [
                    'image' => get_field('description')['image'],
                    'text' => get_field('description')['text'],
                ] ?>

                <div class="page-managment__description-img">
                    <?php echo wp_get_attachment_image($description_data['image'], 'full') ?>
                </div>
                <div class="page-managment__description-text">
                    <?php echo $description_data['text'] ?>
                </div>
            </div>
            <div class="page-managment__media page-managment__media--bottom">
                <?php $media_bottom_data = [
                    'image' => get_field('media_bottom')['image'],
                    'title' => get_field('media_bottom')['title'],
                    'desc' => get_field('media_bottom')['description']
                ] ?>
                <div class="page-managment__media-img">
                    <?php echo wp_get_attachment_image($media_bottom_data['image'], 'full') ?>
                </div>
                <div class="page-managment__media-content">
                    <h2 class="page-managment__media-title"><?php echo $media_bottom_data['title'] ?></h2>
                    <div class="page-managment__media-text"><?php echo $media_bottom_data['desc'] ?></div>
                </div>
            </div>
        </div>

        <div class="page-managment__cta page-managment__cta--sticky">
            <?php $cta_data = [
                'title' => get_field('cta')['title'],
                'button' => get_field('cta')['button'],
            ]; ?>

            <div class="page-managment__cta-title"><?php echo $cta_data['title'] ?></div>

            <?php if ($cta_data['button']) { ?>
                <a class="page-managment__cta-btn ct-btn-primary" data-btn-size="l" href="<?php echo $cta_data['button']['url'] ?>" <?php echo $cta_data['button']['target'] ? 'target="' . $cta_data['button']['target'] . '"' : '' ?>>
                    <?php echo $cta_data['button']['title'] ?>
                </a>
            <?php } ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>