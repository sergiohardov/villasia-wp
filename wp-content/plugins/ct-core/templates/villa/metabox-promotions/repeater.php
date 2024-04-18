<?php

use CTCore\SYS\Helpers; ?>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label"><?php _e('Owner Promotions', CTCORE_LANG_TEXT) ?></label>
    <div class="col-sm-9">
        <div id="VillaMetaboxPromotionsRepeaterItems">

            <div id="VillaMetaboxPromotionsRepeaterClone" class="visually-hidden">
                <?php Helpers::render_template('/villa/metabox-promotions/repeater-item', [
                    'owner_promotions' => $args['owner_promotions'],
                    'selected_id' => null
                ]); ?>
            </div>

            <?php if ($args['promotions_from_owner']) {
                foreach ($args['promotions_from_owner'] as $promotion_from_owner) {
                    Helpers::render_template('/villa/metabox-promotions/repeater-item', [
                        'owner_promotions' => $args['owner_promotions'],
                        'selected_id' => $promotion_from_owner,
                    ]);
                }
            } ?>
        </div>

        <button id="VillaMetaboxPromotionsRepeaterAdd" class="btn btn-primary" role="button" type="button">
            <p class="fs-7 mb-0"><?php _e('Add Row', CTCORE_LANG_TEXT) ?> <i class="bi bi-plus"></i></p>
        </button>
    </div>
</div>