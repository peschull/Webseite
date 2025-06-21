<?php
/**
 * Template für den PDF-Viewer Block
 *
 * @package Verein-Menschlichkeit
 */

$class_name = '';
if (!empty($block['className'])) {
    $class_name = $block['className'];
}

$pdf_file = get_field('pdf_file');
$viewer_height = get_field('viewer_height') ?: 600;
$show_download = get_field('show_download');
$show_toolbar = get_field('show_toolbar');
?>

<div class="pdf-viewer-block <?php echo esc_attr($class_name); ?>">
    <?php if ($pdf_file): ?>
        <div class="pdf-container" style="height: <?php echo esc_attr($viewer_height); ?>px;">
            <iframe src="<?php echo esc_url($pdf_file['url']); ?>#toolbar=<?php echo $show_toolbar ? '1' : '0'; ?>"
                    class="pdf-frame"
                    title="<?php echo esc_attr($pdf_file['title']); ?>"
                    width="100%"
                    height="100%">
            </iframe>
        </div>
        
        <?php if ($show_download): ?>
            <div class="pdf-actions">
                <a href="<?php echo esc_url($pdf_file['url']); ?>" 
                   class="download-button" 
                   download="<?php echo esc_attr($pdf_file['filename']); ?>">
                    <span class="download-icon">⬇️</span>
                    <?php _e('PDF herunterladen', 'verein-menschlichkeit'); ?>
                    <span class="file-info">
                        (<?php echo esc_html(size_format($pdf_file['filesize'])); ?>)
                    </span>
                </a>
            </div>
        <?php endif; ?>
        
    <?php else: ?>
        <p class="no-pdf">
            <?php _e('Bitte wählen Sie eine PDF-Datei aus.', 'verein-menschlichkeit'); ?>
        </p>
    <?php endif; ?>
</div>
