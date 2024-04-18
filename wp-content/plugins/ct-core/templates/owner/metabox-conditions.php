<div class="ct-core-bootstrap-wrapp">

    <div id="ownerConditionsMetabox">
        <textarea id="ownerConditionsData" class="hidden" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_OWNER_CONDITIONS . ']' ?>"><?php echo $args['data'] ? json_encode($args['data']) : '{}'; ?></textarea>

        <div id="ownerConditionsFields" class="<?php echo $args['data'] ? '' : 'hidden' ?>">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><?php _e('Locations', CTCORE_LANG_TEXT) ?></label>
                <div class="col-sm-10">
                    <select id="ownerConditionsSelect" class="form-select" aria-label="Default select example"></select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><?php _e('Rental Conditions', CTCORE_LANG_TEXT) ?></label>
                <div class="col-sm-10">
                    <textarea id="ownerConditionsRental" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><?php _e('Reservation Conditions', CTCORE_LANG_TEXT) ?></label>
                <div class="col-sm-10">
                    <textarea id="ownerConditionsReservation" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><?php _e('Cancellation Policy', CTCORE_LANG_TEXT) ?></label>
                <div class="col-sm-10">
                    <textarea id="ownerConditionsCancellation" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div id="ownerConditionsInfo" class="alert alert-warning mb-0 <?php echo !$args['data'] ?: 'hidden' ?>" role="alert">
            <?php _e('No select locations.', CTCORE_LANG_TEXT) ?>
        </div>

    </div>
</div>