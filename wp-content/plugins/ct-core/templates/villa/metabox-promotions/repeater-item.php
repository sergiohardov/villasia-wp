<div class="d-flex align-items-center mb-3 gap-3">
    <select class="form-select" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_PROMOTIONS_OWNER . '][]' ?>">
        <option value="" selected><?php _e('- Select -', CTCORE_LANG_TEXT) ?></option>

        <?php if ($args['owner_promotions']) { ?>
            <?php foreach ($args['owner_promotions'] as $owner_promotion) { ?>
                <option value="<?php echo $owner_promotion['id'] ?>" <?php if (intval($owner_promotion['id']) === intval($args['selected_id'])) echo 'selected' ?>><?php echo $owner_promotion['name'] ?></option>
            <?php } ?>
        <?php } ?>
    </select>

    <button class="btn btn-danger" role="button" type="button">
        <i class="bi bi-trash"></i>
    </button>
</div>