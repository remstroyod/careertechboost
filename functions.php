<?php
/**
 * default functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package default
 */

if (! defined('_S_VERSION')) {
    define('_S_VERSION', '1.0.0');
}

spl_autoload_register(function ($classname) {

    // Regular
    $class      = str_replace('\\', DIRECTORY_SEPARATOR, strtolower($classname));
    $classpath  = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $class . '.php';

    // WordPress
    $parts      = explode('\\', $classname);
    $class      = 'class-' . strtolower(array_pop($parts));
    $folders    = strtolower(implode(DIRECTORY_SEPARATOR, $parts));
    $wppath     = dirname(__FILE__) .  DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . $folders . DIRECTORY_SEPARATOR . $class . '.php';

    if (file_exists($classpath)) {
        include_once $classpath;
    } elseif (file_exists($wppath)) {
        include_once $wppath;
    }
});
/**
 * Setup Theme
 */
$theme = new \controllers\Setup();
