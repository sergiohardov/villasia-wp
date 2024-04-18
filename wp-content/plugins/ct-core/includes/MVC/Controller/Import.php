<?php

namespace CTCore\MVC\Controller;

use CTCore\MVC\View\Import as ImportView;

class Import
{
    private $view;

    function __construct()
    {
        $this->view = new ImportView();

        add_action('admin_menu', [$this, 'add_menu_page']);
    }

    public function add_menu_page()
    {
        add_menu_page('Villasia Import CSV', 'Import CSV', 'manage_options', 'ctcore-import-page', [$this->view, 'render_page'], 'dashicons-database-import', 106);
    }
}
