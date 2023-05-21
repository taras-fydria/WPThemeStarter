<?php

namespace App\Setup;


use Walker_Nav_Menu;

class ThemeWalkerNav extends Walker_Nav_Menu
{
    protected ?bool $is_mega_menu = true;

    /**
     * @return bool
     */
    public function get_is_mega_menu(): ?bool
    {
        return $this->is_mega_menu;
    }

    /**
     * @param bool $is_mega_menu
     */
    public function set_is_mega_menu(?bool $is_mega_menu): void
    {
        $this->is_mega_menu = $is_mega_menu;
    }

    public function __construct()
    {
        add_filter('wp_nav_menu_args', [$this, 'wp_nav_menu_args'], 10, 1);
        add_filter('walker_nav_menu_start_el', [$this, 'walker_nav_menu_start_el'], 10, 4);
    }

    /**
     * Filters the arguments used to display a navigation menu.
     *
     * @param array $args Array of wp_nav_menu() arguments.
     * @see wp_nav_menu()
     *
     * @since 3.0.0
     *
     */
    public function wp_nav_menu_args(array $args): array
    {
        $args['menu_class'] .= ' walker-nav';
        return $args;
    }

    /**
     * Adds custom class to dropdown menu for foundation dropdown script
     */
    function start_lvl(&$output, $depth = 0, $args = [])
    {
        $indent = str_repeat("\t", $depth);
        if ($this->get_is_mega_menu()) {
            $output .= "\n$indent<ul class=\"walker-nav__submenu walker-nav__mega\"><button>Close</button>\n";

        } else {
            $output .= "\n$indent<ul class=\"walker-nav__submenu\">\n";
        }
    }

    /**
     * Adds custom class to parent item with dropdown menu
     *
     * @var $element WP_Post
     * @var $children_elements WP_Post[]
     */
    function display_element($element, &$children_elements, $max_depth, $depth, $args, &$output)
    {
        $element->classes[] = 'walker-nav__item';

        $id_field = $this->db_fields['id'];
        if (!empty($children_elements[$element->$id_field])) {
            $element->classes[] = 'walker-nav__item--has-dropdown';
        }

        $this->set_is_mega_menu(get_field('display_mega_menu', $element->ID));

        if ($this->get_is_mega_menu() && $depth === 0) {
            $element->classes[] = 'walker-nav__item--has-mega';
        }

        if ($depth !== 0) {
            $element->classes[] = 'walker-nav__item--sub';
        }

        parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
    }


    /**
     * @param string $item_output The menu item's starting HTML output.
     * @param WP_Post $menu_item Menu item data object.
     * @param int $depth Depth of menu item. Used for padding.
     * @param stdClass $args An object of wp_nav_menu() arguments.
     * @return void
     */

    public function walker_nav_menu_start_el(string $item_output, WP_Post $menu_item, int $depth, stdClass $args): string
    {
        /** @var WP_Term $menu */
        if (get_field('is_label', $menu_item->ID)) {
            return "<span class='walker-nav__label'>{$menu_item->title}</span>";
        }

        $menu = $args->menu;
        $link_target = $menu_item->target && $menu_item->target !== '' ? $menu_item->target : '_self';
        $link_classes = $depth === 0 ? 'walker-nav__link' : 'walker-nav__link walker-nav__link--sub';

        if ($menu_item->current || $menu_item->current_item_ancestor || $menu_item->current_item_parent) {
            $link_classes .= ' walker-nav__link--current';
        }

        $item_output = "<a href='{$menu_item->url}' target='{$link_target}' class='{$link_classes}'>{$menu_item->title}</a>";


        if ($depth === 0 || $menu->slug !== 'header-main-menu') {
            return $item_output;
        }

        if (!get_field('display_mega_menu', intval($menu_item->menu_item_parent))) {
            return $item_output;
        }

        $submenu_output = $this->get_submenu_output($menu_item);

        return "{$item_output}{$submenu_output}";
    }

    /**
     * Render custom mega Submenu
     *
     * @param WP_Post $menu_item
     * @return string
     */
    protected function get_submenu_output(WP_Post $menu_item): string
    {
        return 'submenu';
    }
}
