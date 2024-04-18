<?php $block_data = [
    'image' => isset(get_field('photos_group', $_GET['villa_id'])[0]) ? get_field('photos_group', $_GET['villa_id'])[0] : null,
    'title' => get_the_title($_GET['villa_id']),
    'location' => get_term(get_field('main_group_city', $_GET['villa_id']))->name . ', ' . get_term(get_field('main_group_area', $_GET['villa_id']))->name
]; ?>

<div class="card-inquiry">
    <h3 class="card-inquiry__title"><?php _e('Booking details', CTTHEME_LANG_TEXT) ?></h3>

    <div class="card-inquiry__thumbnail">
        <div class="card-inquiry__thumbnail-image">
            <?php echo wp_get_attachment_image($block_data['image'], 'full') ?>
        </div>
        <div class="card-inquiry__thumbnail-content">
            <p id="infoVillaName" class="card-inquiry__thumbnail-title"><?php echo $block_data['title'] ?></p>
            <p id="infoVillaLocation" class="card-inquiry__thumbnail-location"><?php echo $block_data['location'] ?></p>
        </div>
    </div>

    <div class="card-inquiry__info">
        <div class="card-inquiry__info-item">
            <span class="card-inquiry__info-title"><?php _e('Bedrooms', CTTHEME_LANG_TEXT) ?></span>
            <span id="infoValueBedroom" class="card-inquiry__info-value">-</span>
        </div>
        <div class="card-inquiry__info-item">
            <span class="card-inquiry__info-title"><?php _e('Check in', CTTHEME_LANG_TEXT) ?></span>
            <span id="infoValueCheckIn" class="card-inquiry__info-value">-</span>
        </div>
        <div class="card-inquiry__info-item">
            <span class="card-inquiry__info-title"><?php _e('Check out', CTTHEME_LANG_TEXT) ?></span>
            <span id="infoValueCheckOut" class="card-inquiry__info-value">-</span>
        </div>
    </div>

    <div class="card-inquiry__price">
        <div class="card-inquiry__price-header">
            <div class="card-inquiry__price-text">
                <div class="card-inquiry__price-title"><?php _e('Price', CTTHEME_LANG_TEXT) ?></div>
                <div id="infoValueNights" class="card-inquiry__price-nights">-</div>
            </div>
            <div id="infoValuePrice" class="card-inquiry__price-total">-</div>
        </div>
        <div class="card-inquiry__price-footer" id="infoValueSub">
            <p>-</p>
        </div>
    </div>
</div>