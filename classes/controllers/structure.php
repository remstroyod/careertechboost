<?php

/**
 * Class Structure
 *
 * This class handles the initialization of the application structure.
 */

namespace controllers;

class Structure
{

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {

        add_action('header_parts', function () {
            get_template_part('template-parts/partials/partial', 'header');
        }, 10);

        add_action('footer_parts', function () {
            get_template_part('template-parts/partials/partial', 'footer');
        }, 10);

    }

}
