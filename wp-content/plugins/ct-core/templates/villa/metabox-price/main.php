<?php

use CTCore\SYS\Helpers;

global $pagenow; ?>

<div class="ct-core-bootstrap-wrapp">

    <?php if ($pagenow === 'post-new.php') { ?>

        <div class="alert alert-danger mb-0" role="alert">
            <?php _e('First you must create villa.', CTCORE_LANG_TEXT) ?>
        </div>

    <?php } else { ?>

        <div id="villaMetaboxPrice" class="villa-metabox-price">

            <div id="villaMetaboxPriceSpinner" class="villa-metabox-price__spinner">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>

            <fieldset id="villaMetaboxPriceRateSync" class="row mb-3">
                <legend class="col-form-label col-sm-3 pt-0"><?php _e('Sync rate with Owner?', CTCORE_LANG_TEXT) ?></legend>
                <div class="col-sm-9">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="villaMetaboxPriceRateSyncNo" type="radio" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_RATE_SYNC . ']' ?>" value="no" <?php echo $args['sync'] === 'no' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="villaMetaboxPriceRateSyncNo"><?php _e('No', CTCORE_LANG_TEXT) ?></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" id="villaMetaboxPriceRateSyncYes" type="radio" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_RATE_SYNC . ']' ?>" value="yes" <?php echo $args['sync'] === 'yes' ? 'checked' : '' ?>>
                        <label class="form-check-label" for="villaMetaboxPriceRateSyncYes"><?php _e('Yes', CTCORE_LANG_TEXT) ?></label>
                    </div>
                </div>
            </fieldset>

            <div class="row mb-3">
                <legend class="col-form-label col-sm-3 pt-0"><?php _e('Rate Card', CTCORE_LANG_TEXT) ?></legend>
                <div class="col-sm-9 d-flex align-items-center gap-3">

                    <select id="villaMetaboxPriceRateSelect" class="form-select" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_RATE_ID . ']' ?>">
                        <option value="" selected><?php _e('- Select -', CTCORE_LANG_TEXT) ?></option>
                        <?php if ($args['rates']) { ?>
                            <?php foreach ($args['rates'] as $key => $rate) { ?>
                                <option value="<?php echo $key ?>" <?php if (intval($key) === intval($args['rate_id'])) echo 'selected' ?>><?php echo $rate ?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>

                    <a id="villaMetaboxPriceVillaRateAdd" class="btn btn-sm btn-primary text-nowrap <?php if ($args['sync'] === 'yes') echo 'visually-hidden' ?>" role="button" href="<?php echo get_site_url(null, '/wp-admin/post-new.php?post_type=' . CTCORE_POST_TYPE_RATE . '&' . CTCORE_FIELD_RATE_RELATED_ID . '=' . $args['villa_id']) ?>">
                        <span class="fs-7 mb-0"><?php _e('Add New', CTCORE_LANG_TEXT) ?> <i class="bi bi-plus"></i></span>
                    </a>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label"><?php _e('Price List', CTCORE_LANG_TEXT) ?></label>
                <div id="villaMetaboxPriceBlock" class="col-sm-9"><?php Helpers::render_template('/villa/metabox-price/repeater', $args) ?></div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label"><?php _e('Main tax or Service Charge', CTCORE_LANG_TEXT) ?></label>
                <div class="col-sm-9">
                    <div class="input-group mb-3">
                        <input type="number" step="0.1" min="0" class="form-control" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_TAX_SERVICE . ']' ?>" value="<?php echo $args['tax_service'] ?: '' ?>">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <label class="col-sm-3 col-form-label"><?php _e('Tax Rate', CTCORE_LANG_TEXT) ?></label>
                <div class="col-sm-9">
                    <div class="input-group mb-3">
                        <input type="number" step="0.1" min="0" class="form-control" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_TAX_RATE . ']' ?>" value="<?php echo $args['tax_rate'] ?: '' ?>">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>

        </div>
    <?php } ?>
</div>