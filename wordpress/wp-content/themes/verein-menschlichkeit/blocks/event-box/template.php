<?php
// Template für den Block "event-box"
// Beispielhafte Ausgabe mit ACF-Feldern
?>
<div class="event-box-block">
    <h2><?php the_field('event_titel'); ?></h2>
    <p><?php the_field('event_beschreibung'); ?></p>
    <div class="event-datum">
        <?php the_field('event_datum'); ?>
    </div>
</div>
