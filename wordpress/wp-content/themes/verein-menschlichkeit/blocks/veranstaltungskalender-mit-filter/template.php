<?php
/**
 * Template für den Veranstaltungskalender mit Filter Block
 *
 * @package Verein_Menschlichkeit
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

// Block-Variablen
$kalender_titel = get_field('kalender_titel');
$filter_kategorien = get_field('filter_kategorien');
$anzahl_events = get_field('anzahl_events');
$ansicht = get_field('ansicht'); // list, grid, kalender

// Klassen für den Block
$block_classes = 'veranstaltungskalender-mit-filter';
if (!empty($block['className'])) {
    $block_classes .= ' ' . $block['className'];
}
?>

<div class="<?php echo esc_attr($block_classes); ?>">
    <?php if ($kalender_titel) : ?>
        <h2 class="kalender-titel"><?php echo esc_html($kalender_titel); ?></h2>
    <?php endif; ?>

    <div class="filter-bereich">
        <?php if ($filter_kategorien) : ?>
            <div class="kategorien-filter">
                <?php foreach ($filter_kategorien as $kategorie) : ?>
                    <button class="filter-button" data-kategorie="<?php echo esc_attr($kategorie['value']); ?>">
                        <?php echo esc_html($kategorie['label']); ?>
                    </button>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="ansicht-umschalter">
            <button class="ansicht-button <?php echo $ansicht === 'list' ? 'aktiv' : ''; ?>" data-ansicht="list">
                <span class="dashicons dashicons-list-view"></span>
            </button>
            <button class="ansicht-button <?php echo $ansicht === 'grid' ? 'aktiv' : ''; ?>" data-ansicht="grid">
                <span class="dashicons dashicons-grid-view"></span>
            </button>
            <button class="ansicht-button <?php echo $ansicht === 'kalender' ? 'aktiv' : ''; ?>" data-ansicht="kalender">
                <span class="dashicons dashicons-calendar-alt"></span>
            </button>
        </div>
    </div>

    <div class="events-container" data-ansicht="<?php echo esc_attr($ansicht); ?>">
        <!-- Events werden hier dynamisch per JavaScript geladen -->
        <div class="loading-spinner">
            <span class="dashicons dashicons-update"></span>
        </div>
    </div>

    <?php if ($anzahl_events > 0) : ?>
        <div class="load-more">
            <button class="load-more-button">
                <?php _e('Weitere Veranstaltungen laden', 'menschlichkeit'); ?>
            </button>
        </div>
    <?php endif; ?>
</div>
