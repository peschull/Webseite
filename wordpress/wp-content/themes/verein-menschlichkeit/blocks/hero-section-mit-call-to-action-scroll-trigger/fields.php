<?php
/**
 * ACF Felder für den Hero Section mit Call-to-Action Scroll Trigger Block
 */

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_hero_section_scroll_trigger',
        'title' => 'Hero Section mit CTA Scroll Trigger',
        'fields' => array(
            array(
                'key' => 'field_hero_title',
                'label' => 'Überschrift',
                'name' => 'title',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_hero_subtitle',
                'label' => 'Untertitel',
                'name' => 'subtitle',
                'type' => 'textarea',
                'rows' => 3,
            ),
            array(
                'key' => 'field_hero_background',
                'label' => 'Hintergrundbild',
                'name' => 'background_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'large',
                'library' => 'all',
            ),
            array(
                'key' => 'field_hero_cta_text',
                'label' => 'CTA Button Text',
                'name' => 'cta_text',
                'type' => 'text',
            ),
            array(
                'key' => 'field_hero_cta_link',
                'label' => 'CTA Button Link',
                'name' => 'cta_link',
                'type' => 'url',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/hero-section-mit-call-to-action-scroll-trigger',
                ),
            ),
        ),
    ));
}
