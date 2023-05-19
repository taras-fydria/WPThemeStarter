<?php


use App\functions\ThemeImages;
use SleepyOwl\App\components\BaseComponent;

get_header(); ?>
    <main class="main">
        <?php ThemeImages::display_responsive_image(11); ?>
        <?php BaseComponent::base_content(get_the_content()); ?>
    </main>
<?php get_footer();
