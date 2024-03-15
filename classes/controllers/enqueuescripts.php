<?php
namespace controllers;

/**
 * Class EnqueueScripts
 * This class is responsible for enqueueing scripts and styles in WordPress
 *
 * @package controllers
 *
 * @since 1.0.0
 */

class EnqueueScripts
{

    private $version;

    public function __construct()
    {

        add_action('wp_enqueue_scripts', [ &$this, 'init' ], 100);
        add_action( 'admin_enqueue_scripts', [ &$this, 'enqueue_scripts_on_specific_admin_page' ] );
    }

    public function init()
    {

        $this->styles();
        $this->javascript();
    }

    /**
     * Css
     * @return void
     */
    private function styles()
    {

        wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/bundle.css', [], null);

        /**
         * Remove Styles
         */
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wc-block-style');

    }

    /**
     * Java Script
     * @return void
     */
    private function javascript()
    {

        //Bundle
        wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/bundle.js', ['jquery'], null, true);

        $script_data_array = [
            'ajaxurl' => admin_url('admin-ajax.php'),
        ];
        wp_localize_script('script', 'ajax_global_handle', $script_data_array);
    }

    public function enqueue_scripts_on_specific_admin_page() {

        if ( isset($_GET['page']) && $_GET['page'] == 'gf_edit_forms' ) {
            wp_enqueue_media();
            wp_enqueue_script( 'custom_script', get_stylesheet_directory_uri() . '/assets/js/cf.js', array( 'jquery' ), '', true );
        }
    }

}
