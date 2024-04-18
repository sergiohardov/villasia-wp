<div class="interface-switcher">
    <label class="interface-switcher-label"><?php echo $args['title'] ?></label>
    
    <div class="interface-switcher__toggle">
        <label>
            <input type="radio" name="promotions" value="on" <?php echo $args['value'] === 'on' ? 'checked' : '' ?>>
            <span><?php _e('On', CTTHEME_LANG_TEXT) ?></span>
        </label>
        <label>
            <input type="radio" name="promotions" value="off" <?php echo $args['value'] === 'off' ? 'checked' : '' ?>>
            <span><?php _e('Off', CTTHEME_LANG_TEXT) ?></span>
        </label>
    </div>
</div>