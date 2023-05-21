<?php
/**
 * Footer
 */
?>
<!-- BEGIN of footer -->
<footer class="footer">
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="cell large-3">
                <div class="footer__logo">
                    <?php if ($footer_logo = get_field('footer_logo', 'options')):
                        echo wp_get_attachment_image($footer_logo['id'], 'medium');
                    else:
                        \App\functions\ThemeImages::show_custom_logo();
                    endif; ?>
                </div>
            </div>
            <div class="cell large-6">
                <?php
                if (has_nav_menu('footer-menu')) {
                    wp_nav_menu(array('theme_location' => 'footer-menu', 'menu_class' => 'menu footer-menu', 'depth' => 1));
                }
                ?>
            </div>
            <div class="cell large-3 footer__sp">
                <?php get_template_part('parts', 'socials') ?>
            </div>
        </div>
    </div>

    <?php if ($copyright = get_field('copyright', 'options')): ?>
        <div class="footer__copy">
            <div class="grid-container">
                <div class="grid-x grid-margin-x">
                    <div class="cell ">
                        <?php echo $copyright; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</footer>
<!-- END of footer -->

<?php wp_footer(); ?>
</body>
</html>