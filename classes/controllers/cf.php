<?php

/**
 * Class Cf
 *
 * Represents a custom complex field for Gravity Forms.
 */

namespace controllers;

use GF_Field;
use GF_Fields;
use GFAPI;
use GFForms;

GFForms::include_addon_framework();

class Cf extends GF_Field
{
    private static $instance;
    public $type = 'custom_complex';

    public function get_form_editor_field_title()
    {
        return esc_attr__('Product Field', 'cf');
    }

    public function get_form_editor_field_settings()
    {
        return [
            'custom_upload_setting',
            'excerpt',
            'css_class_setting',
            'description_setting',
            'label_setting',
            'admin_label_setting',
            'size_setting',
            'default_value_setting',
            'visibility_setting',
            'conditional_logic_field_setting'
        ];
    }

    public function get_field_input($form, $value = '', $entry = null)
    {
        $form_id = $form['id'];
        $field_id = $this->id;

        $html = "<div id='input_{$form_id}_{$field_id}' class='ginput_complex ginput_container 
                no_prefix has_first_name no_middle_name no_last_name no_suffix 
                gf_name_has_1 ginput_container_name'>";

        $excerpt_value = $this->getPreview($form_id);

        if (!empty($excerpt_value)) {
            $image_url = wp_get_attachment_url($excerpt_value);
            if ($image_url) {
                $html .= "<img src='{$image_url}' alt='Preview image' class='img-responsive'>";
            }
        }

        $html .= "<span id='input_{$form_id}_{$field_id}_1_container'></span>";
        $html .= "</div>";

        return $html;
    }

    public function custom_upload_setting($position, $form_id)
    {
        if ($position === 0) {
            $excerpt_value = $this->getPreview($form_id);
            $preview = !empty($excerpt_value) ?
                '<img style="width:75px" src="'.wp_get_attachment_url($excerpt_value).'" />' : '';

            echo '<li class="custom_upload_setting field_setting">
                  <label for="custom_upload" class="section_label">' .
                __("Image", "cf") .
                gform_tooltip("form_custom_upload") .
                '</label>
                  <div id="previewImage">'.$preview.'</div>
                  <div id="custom_upload">
                      <button class="gf_custom_upload_button button media-button 
                      button-primary button-large media-button-select" id="button_upload_'
                . $form_id . '">'.__('Upload', 'cf').'</button>
                      <button class="gf_custom_delete_button button media-button 
                      button-warning button-large media-button-select" id="button_delete_'
                . $form_id . '">'.__('Delete', 'cf').'</button>
                  </div></li>';
        }
    }

    public function sanitize_settings()
    {
        $this->excerpt = sanitize_text_field($this->excerpt);

        parent::sanitize_settings();
    }

    public function excerpt_field($position, $form_id)
    {
        if ($position === 0) {
            $excerpt_value = $this->getPreview($form_id);
            echo '<li class="excerpt field_setting">
                  <input type="hidden" id="excerpt_input" 
                  onchange="SetFieldProperty(\'excerpt\', this.value);"
                  value="' . $excerpt_value . '">
                  </li>';
        }
    }

    private function getPreview($form_id): ?string
    {
        $form = GFAPI::get_form($form_id);
        $excerpt_value = '';
        if (isset($form['fields'])) {
            foreach ($form['fields'] as $field) {
                if ($field->type === 'custom_complex' && isset($field->excerpt)) {
                    $excerpt_value = esc_attr($field->excerpt);
                }
            }
        }

        return $excerpt_value;
    }

    public static function getInstance()
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

GF_Fields::register(new Cf());

add_action('gform_field_standard_settings', [Cf::getInstance(), 'custom_upload_setting'], 10, 2);
add_action('gform_field_standard_settings', [Cf::getInstance(), 'excerpt_field'], 10, 2);
