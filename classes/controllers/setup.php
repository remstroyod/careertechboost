<?php

/**
 * Class Setup
 *
 * The Setup class is responsible for initializing and running various controllers.
 *
 * @package controllers
 */

namespace controllers;

use controllers\modules\UkrToLat;

class Setup
{

    private static $instance;

    public $navigation;

    public function __construct()
    {

        add_action('after_setup_theme', [ &$this, 'init' ]);
        add_action('init', [ &$this, 'run' ]);

        $this->navigation = new Navigations();
    }

    public function init()
    {

        load_theme_textdomain('default', get_template_directory() . '/languages');

        add_theme_support('automatic-feed-links');

        add_theme_support('title-tag');

        add_theme_support('post-thumbnails');

        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );

        /**
         * Remove Emoji
         */
        remove_action('wp_head', 'print_emoji_detection_script', 7);
        remove_action('wp_print_styles', 'print_emoji_styles');
        remove_action('admin_print_scripts', 'print_emoji_detection_script');
        remove_action('admin_print_styles', 'print_emoji_styles');
    }

    /**
     * Run Controllers
     * @return void
     */
    public function run()
    {

        new Navigations();
        new Structure();
        if (class_exists('acf')) {
            new Acf();
        }
        new EnqueueScripts();
        new UkrToLat();
        if (class_exists('GFForms')) {
            new Cf();
        }
        new Jobs();

    }

    public static function getInstance()
    {
        if (!Setup::$instance instanceof self) {
            Setup::$instance = new self();
        }
        return Setup::$instance;
    }
}
