<?php

namespace CTCore\MVC\View;

use CTCore\SYS\Helpers;

class Import
{
    public function render_page()
    {
        Helpers::render_template('/import/page');
    }
}
