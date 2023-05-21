<?php

namespace App\Setup;

use App\Base\Singleton;

class ThemeSetup extends Singleton
{
    protected function __construct()
    {
        parent::__construct();

        $this->support();
    }

    protected function support()
    {
        /**
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /**
         * Add widget support shortcodes
         */
        add_filter('widget_text', 'do_shortcode');

        /**
         * Support for Featured Images
         */
        add_theme_support('post-thumbnails');

        /**
         * Custom Background
         */
        add_theme_support('custom-background', array('default-color' => 'fff'));

        /**
         * Custom Logo
         */
        add_theme_support('custom-logo', array(
            'height' => '150',
            'flex-height' => true,
            'flex-width' => true,
        ));
    }
}
