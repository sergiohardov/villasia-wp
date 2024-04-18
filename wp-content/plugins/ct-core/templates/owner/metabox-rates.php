<?php
global $pagenow;

use CTCore\MVC\Model\Rate as RateModel;
?>

<div class="ct-core-bootstrap-wrapp">
    <?php if ($pagenow === 'post-new.php') { ?>
        <div class="alert alert-danger mb-0" role="alert">
            <?php _e('First you must create owner.', CTCORE_LANG_TEXT) ?>
        </div>
    <?php } else { ?>
        <?php if ($args['data']['rates']->have_posts()) { ?>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th scope="col" style="width: 2%;">#</th>
                        <th scope="col">Title</th>
                        <th scope="col" class="text-end" style="width: 20%;"><?php _e('Valid until', CTCORE_LANG_TEXT) ?></th>
                        <th scope="col" class="text-end" style="width: 20%;"><?php _e('Last Update', CTCORE_LANG_TEXT) ?></th>
                        <th scope="col" class="text-center" style="width: 12%;"><?php _e('Actions', CTCORE_LANG_TEXT) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($args['data']['rates']->have_posts()) { ?>
                        <?php $args['data']['rates']->the_post(); ?>
                        <tr>
                            <th scope="row"><?php echo $args['data']['rates']->current_post + 1 ?></th>
                            <td><?php the_title(); ?></td>
                            <td class="text-end"><?php echo RateModel::get_valid_until_date(get_the_ID()); ?></td>
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
        <?php } ?>

        <div class="d-flex align-items-center gap-3 justify-content-end">
            <?php if (!$args['data']['rates']->have_posts()) { ?>
                <div class="alert alert-warning mb-0 p-2 flex-fill" role="alert">
                    <p class="mb-0"><?php _e('Add some rates.', CTCORE_LANG_TEXT) ?></p>
                </div>
            <?php } ?>

            <div class="d-flex gap-3 justify-content-end align-items-center">
                <a class="btn btn-primary" role="button" href="<?php echo get_site_url(null, '/wp-admin/post-new.php?post_type=' . CTCORE_POST_TYPE_RATE . '&' . CTCORE_FIELD_RATE_RELATED_ID . '=' . $args['data']['post_id']) ?>">
                    <p class="fs-7 mb-0"><?php _e('Add New', CTCORE_LANG_TEXT) ?> <i class="bi bi-plus"></i></p>
                </a>
            </div>
        </div>
    <?php } ?>
</div>