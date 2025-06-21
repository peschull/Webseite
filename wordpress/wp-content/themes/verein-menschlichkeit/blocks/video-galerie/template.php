<?php
// Template für den Video-Galerie-Block
$videos = get_field('videos');
?>
<div class="block-video-galerie">
    <?php if( is_array($videos) ) foreach($videos as $video): ?>
        <div class="video-item">
            <video controls src="<?php echo esc_url($video['url']); ?>"></video>
        </div>
    <?php endforeach; ?>
</div>
