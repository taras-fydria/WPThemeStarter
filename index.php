<?php

use App\Functions\ThemeImages;
use SleepyOwl\App\Components\BaseComponent;

get_header(); ?>
    <main class="main">
		<?php ThemeImages::display_responsive_image( 11 ); ?>
		<?php BaseComponent::base_content( get_the_content() ); ?>
    </main>
<?php get_footer();
