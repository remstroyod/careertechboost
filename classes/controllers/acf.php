<?php
/**
 * Class Acf
 * ACF Controllers
 */

namespace controllers;

class Acf
{

    function __construct()
    {

        add_filter('acf/settings/save_json', [ &$this, 'acf_json_save_callback']);
        add_filter('acf/settings/load_json', [ &$this, 'acf_json_load_callback']);

        $this->options_page();
    }

    private function init()
    {
    }

    public function acf_json_save_callback($path)
    {

        $path = get_stylesheet_directory() . '/acf-json';
        return $path;
    }

    public function acf_json_load_callback($paths)
    {

        unset($paths[0]);
        $paths[] = get_stylesheet_directory() . '/acf-json';
        return $paths;
    }

    private function options_page()
    {

    }
}
