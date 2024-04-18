<div class="ct-core-bootstrap-wrapp">
    <div class="row mb-3">
        <label class="col-sm-5 col-form-label"><?php _e('Price (min)', CTCORE_LANG_TEXT) ?></label>
        <div class="col-sm-7 col-form-label">
            <?php if ($args['min_price']) {
                echo '$' . $args['min_price'];
            } else {
                _e('Price unset', CTCORE_LANG_TEXT);
            } ?>
        </div>
    </div>
    <div class="row">
        <label class="col-sm-5 col-form-label"><?php _e('Price (max)', CTCORE_LANG_TEXT) ?></label>
        <div class="col-sm-7 col-form-label">
            <?php if ($args['max_price']) {
                echo '$' . $args['max_price'];
            } else {
                _e('Price unset', CTCORE_LANG_TEXT);
            } ?>
        </div>
    </div>
</div>