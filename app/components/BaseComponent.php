<?php

namespace SleepyOwl\App\components;

class BaseComponent
{
    const FILE_FOLDER = 'components';


    static public function render_component(string $file_name = '', array $part_params = [], string $file_folder = self::FILE_FOLDER): void
    {
        $file = $file_folder . '/' . $file_name . '.php';
        if ($part_params) {
            extract($part_params);
        }
        if (locate_template($file)) {
            locate_template($file);
        }

        return;
    }

    static public function return_component(string $file_name = '', array $part_params = [], string $file_folder = self::FILE_FOLDER): string
    {
        ob_start();
        self::render_component($file_name = '', [], self::FILE_FOLDER);

        return ob_get_clean();
    }

    static public function show_output(): void
    {

    }

    /**
     * return component string
     *
     * @return string
     */
    public static function get_output(): string
    {
        ob_start();
        self::show_output();

        return ob_get_clean();
    }

    public static function base_content(string $content): void
    {
        self::render_component('base-content', ['content' => $content]);
    }
}
