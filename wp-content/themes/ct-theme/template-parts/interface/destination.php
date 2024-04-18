<?php
$destination =  '';
$formated = '';

if (is_search() && isset($_GET['destination']) && !empty($_GET['destination'])) {
    $destination = $_GET['destination'];
} else if (is_tax(CTCORE_TAXONOMY_COUNTRY) || is_tax(CTCORE_TAXONOMY_AREA) || is_tax(CTCORE_TAXONOMY_CITY)) {
    $destination = get_queried_object()->term_id;
}


if ($destination) {
    $formated = is_numeric($destination) ? ct_theme_get_format_location($destination) : ct_theme_get_format_location(ct_theme_get_term_id_by_name($destination));
}
?>

<div class="interface-destination ct-interface-item">
    <input type="hidden" name="destination" value="<?php echo $destination ?>">

    <div class="ct-interface-item__inner">
        <div class="ct-interface-item__icon">
            <i class="ct-icon ct-icon--outline-search"></i>
        </div>
        <div class="ct-interface-item__content">
            <span class="ct-interface-item__label"><?php _e('Select Destination', CTTHEME_LANG_TEXT) ?></span>
            <input class="ct-interface-item__input" type="text" placeholder="<?php _e('Where to go?', CTTHEME_LANG_TEXT) ?>" value="<?php echo $formated ?>">
        </div>
    </div>

    <span class="interface-destination__clear"><i class="ct-icon ct-icon--outline-close"></i></span>
    <ul class="interface-destination__results"></ul>
</div>