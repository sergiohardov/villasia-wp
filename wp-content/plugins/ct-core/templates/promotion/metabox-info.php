<?php if ($args['data']) { ?>
    <p>
        <b><?php _e('Related', CTCORE_LANG_TEXT) ?></b>: <span><?php echo $args['data']['type'] ?></span>
    </p>
    <p>
        <b><?php _e('Name', CTCORE_LANG_TEXT) ?></b>: <span><?php echo $args['data']['title'] ?></span>
    </p>
    <p>
        <b><?php _e('ID', CTCORE_LANG_TEXT) ?></b>: <span><?php echo $args['data']['id'] ?></span>
    </p>
    <p>
        <b><?php _e('Link', CTCORE_LANG_TEXT) ?></b>: <a href="<?php echo $args['data']['link'] ?>"><?php _e('Edit', CTCORE_LANG_TEXT) ?></a>
    </p>
<?php } else { ?>
    <p>
        <b><?php _e('ID', CTCORE_LANG_TEXT) ?></b>: <input type="number" style="width: 10ch;" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_PROMOTION_RELATED_ID . ']' ?>">
    </p>
<?php } ?>