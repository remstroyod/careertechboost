<?php

/**
 * Class PostType
 *
 * This class represents the controller for managing post types.
 */

namespace controllers;

class Jobs
{

    public function __construct()
    {
        add_action( 'init', [ &$this, 'register' ], 100 );
        add_action( 'add_meta_boxes', [ &$this, 'metabox'] );
        add_action( 'save_post', [ &$this, 'metabox_save' ], 100 );

    }

    public function register()
    {
        register_post_type( 'jobs', [
            'label'               => 'Jobs',
            'labels'              => array(
                'name'          => 'Jobs',
                'singular_name' => 'Jobт',
                'menu_name'     => 'Jobs',
                'all_items'     => __( 'Jobs', 'default' ),
                'add_new'       => __( 'Add', 'default' ),
                'add_new_item'  => __( 'Add New', 'default' ),
                'edit'          => __( 'Edit', 'default' ),
                'edit_item'     => __( 'Edit', 'default' ),
                'new_item'      => __( 'New', 'default' ),
            ),
            'description'         => '',
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_rest'        => true,
            'rest_base'           => '',
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-tickets',
            'exclude_from_search' => false,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'hierarchical'        => false,
            'rewrite'             => array( 'with_front'=>false, 'pages'=>false, 'feeds'=>false, 'feed'=>false ),
            'has_archive'         => false,
            'query_var'           => true,
            'supports' => [
                'title',
                'editor',
                'custom-fields',
                'page-attributes',
            ],
        ] );
    }

    public function metabox()
    {
        $screens = [ 'jobs' ];
        add_meta_box(
            'custom-url',
            __( 'Custom URL', 'default' ),
            [ &$this, 'custom_url' ],
            $screens,
            'side',
            'low'
        );
    }

    public function custom_url( $post )
    {

        $url = get_post_meta( $post->ID, '_custom_url', 1 );

        echo '<div>';
        echo '<label for="_custom_url">' . __( 'URL', 'default' ) . '</label> ';
        echo '<input style="width:100%" type="text" id="_custom_url" name="_custom_url" value="'. $url .'" />';
        echo '</div>';

    }

    public function metabox_save( $post_id )
    {

        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return;

        if( ! current_user_can( 'edit_post', $post_id ) )
            return;

        if( isset($_POST[ '_custom_url' ]) )
        {
            $value = sanitize_text_field( $_POST['_custom_url'] );
            update_post_meta( $post_id, '_custom_url', $value );
        }
    }

    public function getJobs(): void
    {
        global $wpdb;

        $query = "SELECT $wpdb->posts.post_title, $wpdb->postmeta.meta_value
          FROM $wpdb->posts
          INNER JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id
          WHERE $wpdb->postmeta.meta_key = '_custom_url'
          AND $wpdb->posts.post_status = 'publish'
          AND $wpdb->posts.post_type = 'jobs'
          ORDER BY $wpdb->posts.post_title ASC";

        $results = $wpdb->get_results( $query, ARRAY_A );

        if(!$results) return;

        $final_results = [];
        $current_letter = '';
        foreach($results as $result)
        {
            $first_letter = mb_strtoupper(mb_substr($result['post_title'], 0, 1));
            if ($first_letter !== $current_letter)
            {
                $current_letter = $first_letter;
            }
            $final_results[$first_letter][] = array($result['post_title'] => $result['meta_value']);
        }

        var_dump($final_results);

    }

}
