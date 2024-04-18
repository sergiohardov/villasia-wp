<div class="hero-simple">
    <div class="hero-simple__bg">
        <?php if (isset($args['image']) && $args['image']) {
            echo wp_get_attachment_image($args['image'], 'full');
        } ?>
    </div>

    <div class="hero-simple__content">
        <div class="ct-container">
            <h1 class="hero-simple__title"><?php echo $args['title'] ?></h1>
        </div>
    </div>
</div>