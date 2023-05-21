<?php

namespace SleepyOwl\App\functions;

class Helpers
{

    /**
     * Get acf field link markup
     *
     * @param array $acf_link
     * @param array $attributes
     *
     * @return string|null
     */
    static function get_acf_link_markup(array $acf_link, array $attributes = []): ?string
    {
        if (!$acf_link || !isset($acf_link['url'])) {
            return null;
        }
        $html_attributes = [];
        if (count($attributes) > 0) {
            foreach ($attributes as $key => $value) {
                $html_attributes[] = "{$key}='{$value}'";
            }
        }

        if (isset($acf_link['target'])) {
            $html_attributes[] = "target='${acf_link['target']}'";
        }

        $html_attributes = implode(' ', $html_attributes);

        return "<a href='{$acf_link['url']}' {$html_attributes}>{$acf_link['label']}</a>";
    }

    /**
     *
     * Output acf link field markup
     *
     * @param array $acf_link
     * @param array $attributes
     *
     * @return void
     */
    static function output_acf_link(array $acf_link, array $attributes = []): void
    {
        echo self::get_acf_link_markup($acf_link, $attributes);
    }

    /**
     * Format phone number for output as link
     *
     * @param $string
     *
     * @return array|string|string[]|null
     */
    static function sanitize_number($string)
    {
        return preg_replace('/[^+\d]+/', '', $string);
    }

    // Create pagination
    static function foundation_pagination($query = '', bool $echo = true)
    {
        if (empty($query)) {
            global $wp_query;
            $query = $wp_query;
        }

        $big = 999999999;

        $links = paginate_links(array(
            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'format' => '?paged=%#%',
            'prev_next' => true,
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
            'current' => max(1, $query->query_vars['paged']),
            'total' => $query->max_num_pages,
            'type' => 'list',
        ));

        $pagination = str_replace('page-numbers', 'pagination', $links);

        if ($echo) {
            echo $pagination;
        } else {
            return $pagination;
        }
    }
}
