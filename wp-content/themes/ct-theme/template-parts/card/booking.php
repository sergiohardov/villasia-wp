<?php $block_data = [
    'image' => isset(get_field('photos_group')[0]) ? get_field('photos_group')[0] : null,
    'title' =>  get_the_title(),
    'location' => get_term(get_field('main_group_city'))->name . ', ' . get_term(get_field('main_group_area'))->name,
    'content' => get_field('villa_card_content', 'options')
] ?>

<div class="card-booking">
    <h2 id="cardBookingTitle" class="card-booking__title" data-alt-title="<?php _e('Booking details', CTTHEME_LANG_TEXT) ?>">
        <?php _e('Select Dates and Bedrooms', CTTHEME_LANG_TEXT); ?>
    </h2>

    <div id="cardBookingThumbnail" class="card-booking__thumbnail">
        <div class="card-booking__thumbnail-img">
            <?php echo wp_get_attachment_image($block_data['image'], 'full'); ?>
        </div>

        <div class="card-booking__thumbnail-content">
            <h3 class="card-booking__thumbnail-title"><?php echo $block_data['title'] ?></h3>
            <p class="card-booking__thumbnail-location"><?php echo $block_data['location'] ?></p>
        </div>
    </div>

    <div class="card-booking__check">
        <?php get_template_part('template-parts/interface/check', null, [
            'booked_dates' => ct_core_get_villa_ics_booked_dates(get_the_ID())
        ]) ?>
        <?php get_template_part('template-parts/interface/bedroom') ?>
    </div>

    <div id="cardBookingPriceContainer" class="card-booking__price">
        <div class="card-booking__price-header">
            <div class="card-booking__price-text">
                <p class="card-booking__price-title"><?php _e('Price', CTTHEME_LANG_TEXT) ?></p>
                <p id="cardBookingPriceNights" class="card-booking__price-nights">-</p>
            </div>
            <span id="cardBookingPriceTotal" class="card-booking__price-total">-</span>
        </div>
        <div class="card-booking__price-footer" id="cardBookingPriceSub">
            <p>-</p>
        </div>

        <a id="cardBookingBtnInquire" class="card-booking__price-btn ct-btn-primary" data-btn-size="s" href="<?php echo get_site_url() . '/inquiry-form/?' ?>"><?php _e('Inquire Now', CTTHEME_LANG_TEXT) ?></a>
    </div>

    <button id="cardBookingBtnCheck" class="card-booking__btn ct-btn-primary" data-btn-size="s"><?php _e('Check Availability', CTTHEME_LANG_TEXT) ?></button>

    <?php if (isset($block_data['content']) && $block_data['content']) { ?>
        <div id="cardBookingContent" class="card-booking__content">
            <?php echo $block_data['content']; ?>
        </div>
    <?php } ?>
</div>