<?php
namespace controllers;

/**
 * Class Navigations
 *
 * The Navigations class handles the navigation menus in the application.
 */
class Navigations
{

    private static $instance;

    public function __construct()
    {
        $this->init();
    }

    public function init(): void
    {

        register_nav_menus(
            [
                'primary' => esc_html__('Primary Navigation', 'default'),
            ]
        );
    }

    public function primary(): bool|string|null
    {
        return wp_nav_menu([
            'theme_location'  => 'primary',
            'menu'            => '',
            'container'       => 'nav',
            'container_class' => 'header__row-nav',
            'container_id'    => '',
            'menu_class'      => 'header__row-nav--menu d-flex',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth'           => 0,
            'walker'          => new Walker(),
        ]);
    }

    public function menu($id, $args = []): bool|string|null
    {

        $default = [
            'theme_location'  => $id,
            'menu'            => '',
            'container'       => '',
            'container_class' => '',
            'container_id'    => '',
            'menu_class'      => '',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth'           => 0,
            'walker'          => '',
        ];

        $options = wp_parse_args($args, $default);

        return wp_nav_menu($options);
    }

    public static function getInstance()
    {
        if (!Navigations::$instance instanceof self) {
            Navigations::$instance = new self();
        }
        return Navigations::$instance;
    }
}
