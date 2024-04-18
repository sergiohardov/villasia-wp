<?php
$bedroom = isset($_GET['bedroom']) ? $_GET['bedroom'] : '0';
$label = $bedroom ? $_GET['bedroom'] . ' ' . __('Bedrooms', CTTHEME_LANG_TEXT) : __('Number of bedrooms', CTTHEME_LANG_TEXT);
?>

<div class="interface-bedroom ct-interface-item">
    <div class="ct-interface-item__inner">
        <div class="ct-interface-item__icon">
            <i class="ct-icon ct-icon--fill-bed"></i>
        </div>
        <div class="ct-interface-item__content">
            <span class="ct-interface-item__label"><?php _e('Bedrooms', CTTHEME_LANG_TEXT) ?></span>
            <span class="ct-interface-item__input" data-default-text="<?php _e('Number of bedrooms', CTTHEME_LANG_TEXT) ?>">
                <?php echo $label; ?>
            </span>
        </div>
    </div>

    <div class="interface-bedroom__controlls">
        <span class="interface-bedroom__controlls-label"><?php _e('Bedrooms', CTTHEME_LANG_TEXT) ?></span>

        <?php get_template_part('template-parts/interface/counter', null, [
            'id' => 'interfaceCounterBedroom',
            'name' => 'bedroom',
            'value' => $bedroom
        ]) ?>
    </div>
</div>