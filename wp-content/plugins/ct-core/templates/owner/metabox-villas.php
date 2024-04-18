<?php
global $pagenow;

use CTCore\MVC\Model\Villa as VillaModel;
?>

<div class="ct-core-bootstrap-wrapp">
    <?php if ($pagenow === 'post-new.php') { ?>
        <div class="alert alert-danger mb-0" role="alert">
            <?php _e('First you must create owner.', CTCORE_LANG_TEXT) ?>
        </div>
    <?php } else { ?>
        <?php if ($args['data']['villas']->have_posts()) { ?>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 2%;">#</th>
                        <th scope="col"><?php _e('Title', CTCORE_LANG_TEXT) ?></th>
                        <th scope="col" class="text-end"><?php _e('Location', CTCORE_LANG_TEXT) ?></th>
                        <th scope="col" class="text-end"><?php _e('Rate Card', CTCORE_LANG_TEXT) ?></th>
                        <th scope="col" class="text-end"><?php _e('Terms & Conditions', CTCORE_LANG_TEXT) ?></th>
                        <th scope="col" class="text-end"><?php _e('Last Update', CTCORE_LANG_TEXT) ?></th>
                        <th scope="col" class="text-center" style="width: 12%;"><?php _e('Actions', CTCORE_LANG_TEXT) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($args['data']['villas']->have_posts()) { ?>
                        <?php $args['data']['villas']->the_post(); ?>
                        <?php $villa_location = VillaModel::get_area_id(get_the_ID()) ?>
                        <?php $rate_card_sync = VillaModel::get_rates_sync(get_the_ID()); ?>
                        <?php $conditions_sync = VillaModel::get_conditions_sync(get_the_ID()); ?>
                        <tr>
                            <th scope="row"><?php echo $args['data']['villas']->current_post + 1 ?></th>
                            <td><a href="<?php echo get_the_permalink() ?>"><?php the_title(); ?></a> </td>
                            <td class="text-end"><?php echo $villa_location ? get_term($villa_location)->name : '-'; ?></td>
                            <td class="text-end"><?php echo $rate_card_sync === 'yes' ? __('Sync', CTCORE_LANG_TEXT) : __('Custom', CTCORE_LANG_TEXT); ?></td>
                            <td class="text-end"><?php echo $conditions_sync === 'yes' ? __('Sync', CTCORE_LANG_TEXT) : __('Custom', CTCORE_LANG_TEXT); ?></td>
                            <td class="text-end"><?php echo get_the_modified_date("j-M-Y"); ?></td>
                            <td class="text-center">
                                <a href="<?php echo get_edit_post_link() ?>" class="text-primary fs-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit"><i class="bi bi-pencil"></i></a>
                                <a href="<?php echo get_delete_post_link() ?>" class="text-danger fs-5" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Remove"><i class="bi bi-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php wp_reset_postdata(); ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="alert alert-warning" role="alert">
                <?php _e('No manage villas.', CTCORE_LANG_TEXT) ?>
            </div>
        <?php } ?>
    <?php } ?>
</div>