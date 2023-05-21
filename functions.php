<?php

namespace SleepyOwl;


use SleepyOwl\App\App;

/**
 * Classes autoloader. For current work folder structure should be same as namespaces. for example
 *
 * @param $class_name
 *
 * @return void
 */
function my_custom_autoloader($class_name): void
{
    $class_name = trim($class_name, '');
    $class_name = str_replace(__NAMESPACE__, '', $class_name);
    $class_name = ltrim($class_name, '\\');
    $last_delimiter_position = strrpos($class_name, '\\');
    if ($last_delimiter_position) {
        $file_name = substr($class_name, $last_delimiter_position + 1);
    } else {
        $file_name = $class_name;
    }
    $file_name = sprintf('%s.php', $file_name);
    $path = substr($class_name, $last_delimiter_position);
    $path = explode('\\', $class_name);
    foreach ($path as $key => $path_item) {
        if ($key + 1 < count($path)) {
            $path[$key] = $path_item;
        } else {
            $path[$key] = null;
        }
    }
    $path = array_filter($path, function ($item) {
        return $item !== null;
    });
    $path = implode(DIRECTORY_SEPARATOR, $path);

    $full_path = get_stylesheet_directory() . DIRECTORY_SEPARATOR . strtolower($path) . DIRECTORY_SEPARATOR . $file_name;
    if (file_exists($full_path)) {
        require_once $full_path;
    }
}

// add a new autoloader by passing a callable into spl_autoload_register()
spl_autoload_register('SleepyOwl\my_custom_autoloader');


App::get_instance();