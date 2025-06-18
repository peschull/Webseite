<?php
/**
 * ACF Felder für das Mitglied werden 3-Karten-Modul
 */

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group(array(
        'key' => 'group_membership_cards',
        'title' => 'Mitglied werden 3-Karten-Modul',
        'fields' => array(
            array(
                'key' => 'field_heading',
                'label' => 'Überschrift',
                'name' => 'heading',
                'type' => 'text',
            ),
            array(
                'key' => 'field_subheading',
                'label' => 'Unterüberschrift',
                'name' => 'subheading',
                'type' => 'wysiwyg',
                'toolbar' => 'basic',
                'media_upload' => 0,
            ),
            array(
                'key' => 'field_membership_cards',
                'label' => 'Mitgliedschafts-Karten',
                'name' => 'membership_cards',
                'type' => 'repeater',
                'max' => 3,
                'layout' => 'block',
                'button_label' => 'Karte hinzufügen',
                'sub_fields' => array(
                    array(
                        'key' => 'field_membership_type',
                        'label' => 'Mitgliedschaftstyp',
                        'name' => 'membership_type',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_is_highlighted',
                        'label' => 'Hervorgehoben',
                        'name' => 'is_highlighted',
                        'type' => 'true_false',
                        'ui' => 1,
                    ),
                    array(
                        'key' => 'field_price',
                        'label' => 'Preis',
                        'name' => 'price',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'field_price_period',
                        'label' => 'Preiszeitraum',
                        'name' => 'price_period',
                        'type' => 'text',
                        'default_value' => '/Jahr',
                    ),
                    array(
                        'key' => 'field_features',
                        'label' => 'Features',
                        'name' => 'features',
                        'type' => 'repeater',
                        'layout' => 'table',
                        'button_label' => 'Feature hinzufügen',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_feature',
                                'label' => 'Feature',
                                'name' => 'feature',
                                'type' => 'text',
                                'required' => 1,
                            ),
                        ),
                    ),
                    array(
                        'key' => 'field_cta_text',
                        'label' => 'CTA Text',
                        'name' => 'cta_text',
                        'type' => 'text',
                        'default_value' => 'Jetzt Mitglied werden',
                    ),
                    array(
                        'key' => 'field_cta_link',
                        'label' => 'CTA Link',
                        'name' => 'cta_link',
                        'type' => 'url',
                        'required' => 1,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/mitglied-werden-3-karten-modul',
                ),
            ),
        ),
    ));
}
