<div class="ct-core-bootstrap-wrapp">
    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php _e('Best Choice', CTCORE_LANG_TEXT) ?></label>
        <div class="col-sm-7 col-form-label d-flex align-items-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_BEST_CHOICE . ']' ?>" <?php if ($args['best_choice']) echo 'checked' ?>>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php _e('Rating', CTCORE_LANG_TEXT) ?></label>
        <div class="col-sm-7 col-form-label">
            <?php if ($args['rating']) {
                echo $args['rating'];
            } else {
                _e('No rating', CTCORE_LANG_TEXT);
            } ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-5 col-form-label"><?php _e('Reviews', CTCORE_LANG_TEXT) ?></label>
        <div class="col-sm-7 col-form-label">
            <?php if ($args['reviews']) {
                echo count($args['reviews']) . ' ' .  __('items', CTCORE_LANG_TEXT);
            } else {
                _e('No reviews', CTCORE_LANG_TEXT);
            } ?>
        </div>
    </div>
</div>