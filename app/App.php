<?php

namespace SleepyOwl\App;

use App\Base\Singleton;
use App\Functions\ThemeImages;
use App\Setup\CustomFormats;
use App\Setup\ThemeScriptStyles;
use App\Setup\ThemeSetup;

class App extends Singleton
{
    protected function __construct()
    {
        parent::__construct();
        /**
         * Add theme scripts and styles
         */
        ThemeScriptStyles::get_instance();

        /**
         * Customize TinyMCE formats
         */
        CustomFormats::get_instance();

        /**
         * Theme Image Support
         */
        ThemeImages::get_instance();

        /**
         * Add Theme setup
         */
        ThemeSetup::get_instance();
    }
}
