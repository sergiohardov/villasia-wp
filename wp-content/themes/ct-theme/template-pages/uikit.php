<?php
/* 
    Template Name: UiKit
*/
?>

<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div style="display: flex; flex-direction: column; gap: 40px">
        <p></p>
        <!-- Interface -->
        <div class="ct-container">
            <div style="display: flex; flex-direction: column; gap: 20px;">

                <div class="ct-interface-item">
                    <div class="ct-interface-item__inner">
                        <div class="ct-interface-item__icon">
                            <i class="ct-icon ct-icon--outline-search"></i>
                        </div>
                        <div class="ct-interface-item__content">
                            <span class="ct-interface-item__label"><?php _e('Destination', CTTHEME_LANG_TEXT) ?></span>
                            <input class="ct-interface-item__input" type="text" placeholder="Where to go?" value="<?php echo isset($_GET['s']['location']) ? ct_theme_get_format_location($_GET['s']['location']) : '' ?>">
                        </div>
                    </div>
                </div>

                <?php get_template_part('template-parts/interface/counter') ?>
                <?php get_template_part('template-parts/interface/destination') ?>
                <?php get_template_part('template-parts/interface/check') ?>
                <?php get_template_part('template-parts/interface/bedroom') ?>
                <?php get_template_part('template-parts/interface/guests') ?>
            </div>
        </div>

        <!-- Headings -->
        <div class="ct-container">
            <h1>Heading 1</h1>
            <h2>Heading 2</h2>
            <h3>Heading 3</h3>
            <h4>Heading 4</h4>
            <h5>Heading 5</h5>
            <h6>Heading 6</h6>
        </div>

        <!-- Paragraphs -->
        <div class="ct-container">
            <p>
                Paragraph: Lorem ipsum dolor sit amet consectetur adipisicing elit. Cumque rerum, hic odit veritatis
                possimus dolore. Sint suscipit laudantium quidem perferendis ab maxime sequi dolores inventore rem
                commodi minus aspernatur facilis excepturi aperiam enim cumque quibusdam ex, dolorem, voluptatem eius.
                Nemo.
            </p>
        </div>

        <!-- Containers -->
        <div class="ct-container">
            <h2 class="ct-text-center" style="background: wheat; padding: 60px 0">Container</h2>
        </div>

        <!-- Buttons -->
        <div class="ct-container">
            <div style="display: flex; flex-direction: column; gap: 20px">
                <div>
                    <a class="ct-btn" href="#">Link</a>
                    <button>Button</button>
                    <input type="submit" value="Input" />
                </div>

                <div>
                    <button class="ct-btn-primary" data-btn-size="s">Primary S</button>
                    <button class="ct-btn-primary ct-icon" data-btn-size="s" data-icon-pos="right">Primary S-Icon</button>
                    <button class="ct-btn-secondary" data-btn-size="s">Secondary S</button>
                    <button class="ct-btn-secondary ct-icon" data-btn-size="s" data-icon-pos="right">Secondary S-Icon</button>
                </div>

                <div>
                    <button class="ct-btn-primary" data-btn-size="l">Primary L</button>
                    <button class="ct-btn-primary ct-icon" data-btn-size="l" data-icon-pos="right">Primary L-Icon</button>
                    <button class="ct-btn-secondary" data-btn-size="l">Secondary L</button>
                    <button class="ct-btn-secondary ct-icon" data-btn-size="l" data-icon-pos="right">Secondary L-Icon</button>
                </div>

                <div>
                    <button class="ct-btn-plan ct-icon" data-icon-pos="left">Floor Plan</button>
                </div>

                <div>
                    <button class="ct-btn-prev"><i class="ct-icon ct-icon--outline-next"></i></button>
                    <button class="ct-btn-next"><i class="ct-icon ct-icon--outline-next"></i></button>
                </div>
            </div>
        </div>

        <!-- Radio -->
        <div class="ct-container">
            <label class="ct-radio">
                <input type="radio" name="r" value="1" checked />
                <span>Radio</span>
            </label>

            <label class="ct-radio">
                <input type="radio" name="r" value="2" />
                <span>Radio</span>
            </label>
        </div>

        <!-- Checkbox -->
        <div class="ct-container">
            <label class="ct-checkbox">
                <input type="checkbox" checked />
                <span>Checkbox</span>
            </label>
        </div>

        <!-- Select -->
        <div class="ct-container">
            <select class="ct-select" name="select">
                <option value="">Select</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </div>

        <!-- Dropdown -->
        <div class="ct-container">
            <div class="ct-dropdown">
                <button class="ct-btn ct-dropdown__toggle">Dropdown</button>
                <ul class="ct-dropdown__menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                </ul>
            </div>
        </div>

        <!-- Tabs -->
        <div class="ct-container">
            <div class="ct-tabs">
                <div class="ct-tabs__nav">
                    <button class="ct-tabs__nav-item ct-tabs__nav-item--active">First</button>
                    <button class="ct-tabs__nav-item">Second</button>
                    <button class="ct-tabs__nav-item">Third</button>
                </div>
                <div class="ct-tabs__content">
                    <div class="ct-tabs__content-item ct-tabs__content-item--active">123</div>
                    <div class="ct-tabs__content-item">321</div>
                    <div class="ct-tabs__content-item">444</div>
                </div>
            </div>
        </div>
    </div>

    <?php wp_footer(); ?>

</body>

</html>