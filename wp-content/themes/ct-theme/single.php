<?php

get_header();

switch (get_post_type()) {
    case CTCORE_POST_TYPE_VILLA:
        ct_core_update_villa_ics_dates(get_the_ID(), get_field('main_group_ical_link'));
        get_template_part('template-pages/villa');
        break;
    case 'post':
        get_template_part('template-pages/post');
        break;
    default:
        break;
}

get_footer();
