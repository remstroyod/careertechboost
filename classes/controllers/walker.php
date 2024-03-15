<?php
namespace controllers;

use Walker_Nav_Menu;

/**
 * Class Walker
 *
 * This class extends the Walker_Nav_Menu class and provides a method for rendering menu items.
 */
class Walker extends Walker_Nav_Menu
{


    public function start_el(&$output, $item, $depth = 0, $args = NULL, $id = 0): void
    {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $outputItem = '';
        parent::start_el($outputItem, $item, $depth, $args, $id);

        $megamenu = get_field('megamenu', $item->ID);

        if(!empty($megamenu) && !empty($megamenu['links']))
        {
            $outputItem .= sprintf('<ul class="megamenu megamenu-col-%s">', esc_attr($megamenu['columns']));
            foreach ($megamenu['links'] as $key => $link)
            {
                $icon = '';
                if (!empty($link['icon'])) {
                    $iconUrl = wp_get_attachment_url($link['icon']);
                    if ($iconUrl) {
                        $icon = sprintf(
                            '<img src="%s" alt="%s" title="%s" />',
                            esc_url($iconUrl),
                            esc_attr($link['link']['title']),
                            esc_attr($link['link']['title'])
                        );
                    }
                }

                if (!empty($link['link']['url']) && !empty($link['link']['title'])) {
                    $outputItem .= sprintf(
                        '<li class="menu-item megamenu-item" id="menu-item-%s-%s"><a href="%s">%s %s</a></li>',
                        esc_attr($item->ID),
                        esc_attr($key),
                        esc_url($link['link']['url']),
                        $icon,
                        esc_html($link['link']['title'])
                    );
                }
            }
            $outputItem .= '</ul>';

        }

        $output .= $outputItem;
    }

}
