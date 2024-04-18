<?php if ($args['price'] || $args['rate_id'] || $args['conditions']) { ?>
    <div class="villa-rates" id="rates">
        <?php if ($args['price'] && $args['rate_id']) { ?>
            <?php $rate_data = ct_theme_sort_rates(get_field('rates', $args['rate_id'])) ?>

            <div class="villa-rates__header">
                <h2 class="villa-rates__title"><?php _e('Rates', CTTHEME_LANG_TEXT) ?></h2>
                <div class="villa-rates__select">
                    <span class="villa-rates__select-label"><?php _e('Show me the rate for', CTTHEME_LANG_TEXT) ?></span>
                    <select class="villa-rates__select-options">
                        <?php foreach ($args['price'] as $id => $price) { ?>
                            <option value="<?php echo $id ?>"><?php echo $price['bedrooms'] . ' ' . __('Bedrooms', CTTHEME_LANG_TEXT) ?> </option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="villa-rates__tables">
                <?php foreach ($args['price'] as $num => $price) { ?>
                    <table class="villa-rates__table <?php if ($num === 0) echo 'visible' ?>">
                        <thead>
                            <tr>
                                <th><?php _e('Period', CTTHEME_LANG_TEXT) ?></th>
                                <th><?php _e('Date range', CTTHEME_LANG_TEXT) ?></th>
                                <th><?php _e('Minimum night stay', CTTHEME_LANG_TEXT) ?></th>
                                <th><?php _e('Nightly rate', CTTHEME_LANG_TEXT) ?></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($rate_data as $rate) { ?>
                                <tr>
                                    <td><?php echo $rate['season_name'] ?></td>
                                    <td>
                                        <p><?php echo $rate['date_start'] . ' - ' . $rate['date_end'] ?></p>
                                    </td>
                                    <td><strong><?php echo $rate['minimum_stay'] ?></strong></td>
                                    <?php if (isset($price['seasons'][$rate['season_id']])) { ?>
                                        <td><strong><?php echo ct_theme_get_calc_price_tax($price['seasons'][$rate['season_id']], $args['tax']) ?></strong></td>
                                    <?php } else { ?>
                                        <td><strong><?php _e('Price on Request', CTTHEME_LANG_TEXT) ?></strong></td>
                                    <?php } ?>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                <?php } ?>
            </div>
        <?php } ?>

        <?php if ($args['conditions'] && $args['conditions']['rental'] && $args['conditions']['reservation'] && $args['conditions']['cancellation']) { ?>
            <div class="villa-rates__conditions">
                <?php foreach ($args['conditions'] as $key => $value) { ?>
                    <?php if ($key === 'location_label') continue; ?>
                    <div class="villa-rates__conditions-accordion">
                        <div class="villa-rates__conditions-header">
                            <p class="villa-rates__conditions-title">
                                <?php switch ($key) {
                                    case 'rental':
                                        _e('Rental conditions', CTTHEME_LANG_TEXT);
                                        break;
                                    case 'reservation':
                                        _e('Reservation conditions', CTTHEME_LANG_TEXT);
                                        break;
                                    case 'cancellation':
                                        _e('Cancellation policy', CTTHEME_LANG_TEXT);
                                        break;
                                    default:
                                        break;
                                } ?>
                            </p>
                            <div class="villa-rates__conditions-btn"><i class="ct-icon"></i></div>
                        </div>
                        <div class="villa-rates__conditions-content">
                            <p>
                                <?php switch ($key) {
                                    case 'rental':
                                        echo $args['conditions']['rental'];
                                        break;
                                    case 'reservation':
                                        echo $args['conditions']['reservation'];
                                        break;
                                    case 'cancellation':
                                        echo $args['conditions']['cancellation'];
                                        break;
                                    default:
                                        break;
                                } ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>