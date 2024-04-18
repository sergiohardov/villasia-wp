<div class="ct-core-bootstrap-wrapp">
    <div id="villaMetaboxConditions">
        <input id="villaConditionsData" type="hidden" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_CONDITIONS_DATA . ']' ?>" value='<?php echo json_encode($args['data']); ?>'>

        <fieldset id="villaConditionsSync" class="row mb-3">
            <legend class="col-form-label col-sm-2 pt-0"><?php _e('Sync with Owner?', CTCORE_LANG_TEXT) ?></legend>
            <div class="col-sm-10">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="villaConditionsSyncNo" type="radio" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_CONDITIONS_SYNC . ']' ?>" value="no" <?php echo $args['sync'] === 'no' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="villaConditionsSyncNo">
                        <?php _e('No', CTCORE_LANG_TEXT) ?>
                    </label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" id="villaConditionsSyncYes" type="radio" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_CONDITIONS_SYNC . ']' ?>" value="yes" <?php echo $args['sync'] === 'yes' ? 'checked' : '' ?>>
                    <label class="form-check-label" for="villaConditionsSyncYes">
                        <?php _e('Yes', CTCORE_LANG_TEXT) ?>
                    </label>
                </div>
            </div>
        </fieldset>

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
        <div class="row">
            <label class="col-sm-2 col-form-label"><?php _e('Cancellation Policy', CTCORE_LANG_TEXT) ?></label>
            <div class="col-sm-10">
                <textarea id="ownerConditionsCancellation" class="form-control" rows="3"></textarea>
            </div>
        </div>
    </div>
</div>