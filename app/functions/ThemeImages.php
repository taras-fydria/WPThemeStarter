<?php

namespace App\functions;

use App\base\Singleton;

class ThemeImages extends Singleton
{
    /**
     * 150px X 150px
     */
    const THUMBNAIL = 'thumbnail';

    /*
     * 300px X 300px
     */
    const M_300_300 = 'medium';

    /**
     * 768px X 0
     */
    const ML_768_0 = 'medium_large';

    /**
     * 1024px X 1024px
     */
    const L_1024_1024 = 'large';

    /*
     * 1024px X 0
     */
    const LH_1024_0 = 'large_height';

    /**
     * 1536px X 1536px
     */
    const XL_1536_1536 = '1536x1536';

    /**
     * 2048px X 2048px
     */
    const XXL_2048_2048 = '2048x2048';

    /**
     * 1920px X 0
     */
    const HD_1920_0 = 'full_hd';

    protected function __construct()
    {
        parent::__construct();
        $this->add_custom_image_sizes();
        add_filter('upload_mimes', [$this, 'support_for_upload_svg_files']);
        add_filter('wp_check_filetype_and_ext', [$this, 'svgs_upload_check'], 10, 4);
        add_filter( 'big_image_size_threshold', '__return_false' );
    }

    public function support_for_upload_svg_files(array $mimes = []): array
    {
        // allow SVG file upload
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';

        return $mimes;
    }

    /**
     * Check Mime Types
     */
    public function svgs_upload_check(array $checked, string $file, string $filename, array $mimes)
    {

        if (!$checked['type']) {

            $check_filetype = wp_check_filetype($filename, $mimes);
            $ext = $check_filetype['ext'];
            $type = $check_filetype['type'];
            $proper_filename = $filename;

            if ($type && 0 === strpos($type, 'image/') && $ext !== 'svg') {
                $ext = $type = false;
            }

            $checked = compact('ext', 'type', 'proper_filename');
        }

        return $checked;

    }


    protected function add_custom_image_sizes()
    {
        add_image_size(self::HD_1920_0, 1920, 0, array('center', 'center'));
        add_image_size(self::LH_1024_0, 1024, 0, false);
    }

    /**
     *
     * Get post featured image src
     *
     * @param int $post_id
     * @param string $img_size
     *
     * @return mixed
     */
    static function get_featured_img_url(int $post_id, string $img_size = self::ML_768_0)
    {
        $img = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $img_size);

        return $img[0];
    }

    public static function get_responsive_image(int $attachment_id, string $image_size = self::ML_768_0, array $attributes = []): ?string
    {
        $img_src = wp_get_attachment_image_url($attachment_id);
        if (!$img_src) {
            return null;
        }
        $img_srcset = wp_get_attachment_image_srcset($attachment_id, self::ML_768_0);
        $alt = trim(strip_tags(get_post_meta($attachment_id, '_wp_attachment_image_alt', true)));

        $html_attr = [];

        if ($img_srcset) {
            $html_attr[] = "srcset='${img_srcset}'";
        }

        if (count($attributes) > 0) {
            foreach ($attributes as $key => $value) {
                $html_attr[] = "{$key}='{$value}'";
            }
        }

        $html_attr = implode(' ', $html_attr);


        return "<img src='{$img_src}' alt='{$alt}' {$html_attr}/>";
    }

    public static function display_responsive_image(int $attachment_id, string $image_size = self::ML_768_0, array $attributes = []): void
    {
        echo self::get_responsive_image($attachment_id, $image_size, $attributes);
    }

    static function show_custom_logo(string $size = 'medium')
    {
        if ($custom_logo_id = get_theme_mod('custom_logo')) {
            $logo_image = wp_get_attachment_image($custom_logo_id, $size, false, array(
                'class' => 'custom-logo',
                'itemprop' => 'siteLogo',
                'alt' => get_bloginfo('name'),
            ));
        } else {
            $logo_url = get_stylesheet_directory_uri() . '/assets/images/custom-logo.png';
            $w = 200;
            $h = 160;
            $logo_image = '<img src="' . $logo_url . '" width="' . $w . '" height="' . $h . '" class="custom-logo" itemprop="siteLogo" alt="' . get_bloginfo('name') . '">';
        }

        $html = sprintf('<a href="%1$s" class="custom-logo-link" rel="home" title="%2$s" itemscope>%3$s</a>', esc_url(home_url('/')), get_bloginfo('name'), $logo_image);
        echo apply_filters('get_custom_logo', $html);
    }
}
