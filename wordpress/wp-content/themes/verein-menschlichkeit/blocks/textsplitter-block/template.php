<?php
// Template für den Block "textsplitter-block"
// Beispielhafte Ausgabe mit ACF-Feldern, i18n & Security
?>
<div class="textsplitter-block">
    <h2><?php echo esc_html( get_field('splitter_titel') ? __( get_field('splitter_titel'), 'verein-menschlichkeit' ) : __('Titel', 'verein-menschlichkeit') ); ?></h2>
    <div class="splitter-abschnitte">
        <?php if( have_rows('splitter_abschnitte') ) : ?>
            <?php while( have_rows('splitter_abschnitte') ) : the_row(); ?>
                <div class="splitter-abschnitt">
                    <?php $text = get_sub_field('text'); ?>
                    <p><?php echo wp_kses_post( $text ? __( $text, 'verein-menschlichkeit' ) : __('Abschnitt', 'verein-menschlichkeit') ); ?></p>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div class="splitter-abschnitt">
                <p><?php echo esc_html__('Kein Textabschnitt vorhanden.', 'verein-menschlichkeit'); ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>
