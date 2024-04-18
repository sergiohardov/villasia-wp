<div class="interface-check ct-interface-item" data-adaptive="<?php echo isset($args['adaptive']) ? $args['adaptive'] : 0 ?>">
    <input id="interfaceCheckInputCheckIn" type="hidden" name="check_in" value="<?php echo isset($_GET['check_in']) ? $_GET['check_in'] : '' ?>">
    <input id="interfaceCheckInputCheckOut" type="hidden" name="check_out" value="<?php echo isset($_GET['check_out']) ? $_GET['check_out'] : '' ?>">
    <input id="interfaceCheckInputPicker" type="hidden" value="">
    <textarea id="interfaceCheckTextareaBooked" style="display: none;"><?php echo isset($args['booked_dates']) ? json_encode($args['booked_dates']) : '[]' ?></textarea>

    <div class="ct-interface-item__inner interface-check--left">
        <div class="ct-interface-item__icon">
            <i class="ct-icon ct-icon--outline-date"></i>
        </div>
        <div class="ct-interface-item__content">
            <span id="interfaceCheckTitleCheckIn" class="ct-interface-item__label"><?php _e('Check-in', CTTHEME_LANG_TEXT) ?></span>
            <span id="interfaceCheckLabelCheckIn" class="ct-interface-item__input interface-check__start"><?php _e('Add date', CTTHEME_LANG_TEXT) ?></span>
        </div>
    </div>

    <div class="ct-interface-item__inner interface-check--right">
        <div class="ct-interface-item__content">
            <span class="ct-interface-item__label"><?php _e('Check-out', CTTHEME_LANG_TEXT) ?></span>
            <span id="interfaceCheckLabelCheckOut" class="ct-interface-item__input interface-check__end"><?php _e('Add date', CTTHEME_LANG_TEXT) ?></span>
        </div>
    </div>
</div>