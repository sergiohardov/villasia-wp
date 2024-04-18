<div class="interface-range">
    <div class="interface-range__header">
        <label class="interface-range-label"><?php _e('Price / night', CTTHEME_LANG_TEXT) ?></label>
        <label class="interface-range-label">$<span id="interfaceRangeLabelFrom"><?php echo number_format($args['from'], 0, ',', ',') ?></span> - $<span id="interfaceRangeLabelTo"><?php echo number_format($args['to'], 0, ',', ',') ?></span></label>
    </div>

    <div class="interface-range__inputs">
        <input id="interfaceRangeInputFrom" type="range" name="price_from" min="<?php echo $args['min'] ?>" max="<?php echo $args['max'] ?>" value="<?php echo $args['from'] ?>" />
        <input id="interfaceRangeInputTo" type="range" name="price_to" min="<?php echo $args['min'] ?>" max="<?php echo $args['max'] ?>" value="<?php echo $args['to'] ?>" />
    </div>
</div>