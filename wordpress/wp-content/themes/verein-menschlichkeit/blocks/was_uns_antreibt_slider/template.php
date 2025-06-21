<?php
// Template für den Was uns antreibt Slider-Block
$slides = get_field('slides');
?>
<div class="block-was-uns-antreibt-slider">
    <?php if( is_array($slides) ) foreach($slides as $slide): ?>
        <div class="slide">
            <blockquote><?php echo esc_html($slide['spruch']); ?></blockquote>
            <cite><?php echo esc_html($slide['autor']); ?></cite>
        </div>
    <?php endforeach; ?>
</div>
