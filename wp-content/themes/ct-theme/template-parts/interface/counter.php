<div class="interface-counter">
    <button class="interface-counter__minus" type="button">
        <i class="ct-icon ct-icon--outline-minus"></i>
    </button>

    <input class="interface-counter__input" type="number" value="<?php echo isset($args['value']) ? $args['value'] : '0' ?>"
        <?php
            echo isset($args['id']) ? 'id="' . $args['id'] . '"' : '';
            echo isset($args['name']) ? 'name="' . $args['name'] . '"' : '';
        ?>
    >
    
    <button class="interface-counter__plus" type="button">
        <i class="ct-icon ct-icon--outline-plus"></i>
    </button>
</div>