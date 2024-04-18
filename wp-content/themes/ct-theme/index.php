<?php
get_header();

if (is_home() && !is_front_page()) {
    get_template_part('template-pages/blog');
}

get_footer();
