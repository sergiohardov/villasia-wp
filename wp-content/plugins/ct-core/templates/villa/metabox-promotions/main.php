<?php
global $pagenow;

use CTCore\SYS\Helpers;
?>

<div class="ct-core-bootstrap-wrapp">
    <?php if ($pagenow === 'post-new.php') { ?>
        <div class="alert alert-danger mb-0" role="alert">
            <?php _e('First you must create villa.', CTCORE_LANG_TEXT) ?>
        </div>
    <?php } else { ?>
        <div id="VillaMetaboxPromotions" class="villa-metabox-promotions">
            <?php Helpers::render_template('/villa/metabox-promotions/repeater', $args) ?>
            <?php Helpers::render_template('/villa/metabox-promotions/table', $args) ?>
        </div>
    <?php } ?>
</div>