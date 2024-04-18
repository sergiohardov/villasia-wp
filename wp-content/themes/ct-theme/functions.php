<?php

// TODO: Switch WP Debug to -> false
// TODO: Remove Theme Check Plugin

$theme_includes = [
    "helpers",           // Helper functions 
    "setup",             // Base theme setup
    "menus",             // Register menus
    "sidebars",          // Register sidebars
    "styles",            // Enqueue styles
    "scripts",           // Enqueue scripts
    "acf",               // Advanced Custom Fields.
    "functions",         // Theme Functions.
    "ajax",              // Ajax Functions.
];

foreach ($theme_includes as $include) {
    require get_template_directory() . "/inc/theme/$include.php";
}
