<?php

get_header();

// TODO: Add villa theme in constant & add post type in plugin
if (get_post_type() === CTCORE_POST_TYPE_VILLA || is_tax(CTCORE_TAXONOMY_COUNTRY) || is_tax(CTCORE_TAXONOMY_AREA) || is_tax(CTCORE_TAXONOMY_CITY) || is_tax('villa_theme')) {
    get_template_part('template-pages/general');
}

get_footer();
