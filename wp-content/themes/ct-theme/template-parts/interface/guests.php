<div class="interface-guests ct-interface-item">
    <div class="ct-interface-item__inner">
        <div class="ct-interface-item__icon">
            <i class="ct-icon ct-icon--fill-person"></i>
        </div>
        <div class="ct-interface-item__content">
            <span class="ct-interface-item__label"><?php _e('Guests', CTTHEME_LANG_TEXT) ?></span>
            <span class="ct-interface-item__input" data-default-text="<?php _e('Number of Guests', CTTHEME_LANG_TEXT) ?>">
                <?php _e('Number of Guests', CTTHEME_LANG_TEXT) ?>
            </span>
        </div>
    </div>

    <div class="interface-guests__controlls">
        <div class="interface-guests__controlls-item">
            <div class="interface-guests__controlls-label">
                <i class="ct-icon ct-icon--fill-person"></i>
                <span><?php _e('Adults', CTTHEME_LANG_TEXT) ?></span>
            </div>

            <?php get_template_part('template-parts/interface/counter', null, [
                'id' => 'interfaceCounterAdults',
                'name' => 'adults'
            ]) ?>
        </div>
        <div class="interface-guests__controlls-item">
            <div class="interface-guests__controlls-label">
                <i class="ct-icon ct-icon--fill-person"></i>
                <span><?php _e('Children', CTTHEME_LANG_TEXT) ?></span>
            </div>

            <?php get_template_part('template-parts/interface/counter', null, [
                'id' => 'interfaceCounterChildren',
                'name' => 'children'
            ]) ?>
        </div>
    </div>
</div>