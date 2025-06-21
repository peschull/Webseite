<?php
// Template für CiviCRM-Formular-Override (Beispiel)
if (!defined('CIVICRM_DSN')) die('CiviCRM only');
?>
<div class="civicrm-container">
  <h2><?php echo esc_html($formTitle ?? __('CiviCRM Formular', 'verein-menschlichkeit')); ?></h2>
  <?php if (!empty($formErrors)) : ?>
    <div class="crm-error" role="alert" aria-live="assertive">
      <?php echo esc_html($formErrors); ?>
    </div>
  <?php endif; ?>
  <?php echo $formHtml ?? ''; ?>
</div>
