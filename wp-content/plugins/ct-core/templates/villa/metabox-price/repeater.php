<?php if ($args['rate_id'] && $args['seasons']) { ?>
    <div id="villaMetaboxPriceRepeater">
        <table class="table table-borderless">
            <thead>
                <tr class="text-center">
                    <th scope="col"><?php _e('Bedrooms', CTCORE_LANG_TEXT) ?></th>
                    <?php foreach ($args['seasons'] as $season) { ?>
                        <th scope="col"><?php echo $season['season_name']; ?></th>
                    <?php } ?>
                    <th scope="col"></th>
                </tr>
            </thead>

            <tbody id="villaMetaboxPriceList">
                <tr id="villaMetaboxPriceRowClone" class="visually-hidden">
                    <td>
                        <div class="input-group">
                            <span class="input-group-text"><?php _e('Bed', CTCORE_LANG_TEXT) ?></span>
                            <input type="number" class="form-control villa-metabox-price__input-bedrooms" data-name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_PRICE . ']' ?>" data-key="[bedrooms]" name="" value="">
                        </div>
                    </td>
                    <?php foreach ($args['seasons'] as $season) { ?>
                        <td>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control villa-metabox-price__input-price" data-name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_PRICE . ']' ?>" data-key="[seasons][]" name="" value="">
                            </div>
                        </td>
                    <?php } ?>
                    <td>
                        <div class="text-danger fs-5 villa-metabox-price__remove" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove">
                            <i class="bi bi-trash"></i>
                        </div>
                    </td>
                </tr>

                <?php if ($args['price_list']) { ?>
                    <?php foreach ($args['price_list'] as $price_id => $item) { ?>
                        <tr class="villa-metabox-price__row">
                            <td>
                                <div class="input-group">
                                    <span class="input-group-text"><?php _e('Bed', CTCORE_LANG_TEXT) ?></span>
                                    <input type="number" class="form-control villa-metabox-price__input-bedrooms" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_PRICE . ']' . '[' . $price_id . ']' . '[bedrooms]' ?>" value="<?php echo $item['bedrooms'] ?>">
                                </div>
                            </td>
                            <?php foreach ($args['seasons'] as $season_id => $season) { ?>
                                <td class="td-season">
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control villa-metabox-price__input-price" name="<?php echo CTCORE_FIELD_CUSTOM_KEY . '[' . CTCORE_FIELD_VILLA_PRICE . ']' . '[' . $price_id . ']' . '[seasons][]' ?>" value="<?php echo isset($item['seasons'][$season_id]) ? $item['seasons'][$season_id] : '' ?>">
                                    </div>
                                </td>
                            <?php } ?>
                            <td>
                                <div class="text-danger fs-5 villa-metabox-price__remove" type="button" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove">
                                    <i class="bi bi-trash"></i>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
        <button class="btn btn-primary villa-metabox-price__btn" role="button" type="button">
            <p class="fs-7 mb-0"><?php _e('Add Row', CTCORE_LANG_TEXT) ?> <i class="bi bi-plus"></i></p>
        </button>
    </div>
<?php } else { ?>
    <div class="alert alert-warning mb-0 p-2 flex-fill" role="alert">
        <p class="mb-0"><?php _e('For add prices, choose rate.', CTCORE_LANG_TEXT) ?></p>
    </div>
<?php } ?>