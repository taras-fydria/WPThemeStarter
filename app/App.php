<?php

namespace App;

use App\Base\Singleton;
use App\Setup\CustomFormats;
use App\Setup\ThemeScriptStyles;

class App extends Singleton {
	protected function __construct() {
		parent::__construct();
		/**
		 * Add theme scripts and styles
		 */
		ThemeScriptStyles::get_instance();

		/**
		 * Customize TinyMCE formats
		 */
		CustomFormats::get_instance();
	}
}
