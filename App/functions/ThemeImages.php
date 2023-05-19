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
}
