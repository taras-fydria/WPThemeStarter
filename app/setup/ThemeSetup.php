<?php

namespace App\Setup;

use App\Base\Singleton;

class ThemeSetup extends Singleton
{
    protected function __construct()
    {
        parent::__construct();

        $this->support();

        add_action('acf/init', [self::class, 'my_acf_op_init']);

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

    static function my_acf_op_init(): void
    {

        // Check function exists.
        if (function_exists('acf_add_options_page')) {

            // Register options page.
            $option_page = acf_add_options_page([
                'page_title' => __('Theme General Settings'),
                'menu_title' => __('Theme Settings'),
                'menu_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => false
            ]);
        }
    }
}
