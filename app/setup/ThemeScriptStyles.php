<?php

namespace App\Setup;


use App\Base\Singleton;

class ThemeScriptStyles extends Singleton
{
    protected function __construct()
    {
        parent::__construct();
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('admin_enqueue_scripts', [$this, 'admin_enqueue_scripts']);
    }

    public function enqueue_scripts(): void
    {
        wp_enqueue_style('main-styles', get_stylesheet_directory_uri() . '/dist/main.css', null, '1.0.0');
        wp_enqueue_script('main-scripts', get_stylesheet_directory_uri() . '/dist/main.js', null, '1.0.0', true);
    }

    public function admin_enqueue_scripts(): void
    {

    }
}
