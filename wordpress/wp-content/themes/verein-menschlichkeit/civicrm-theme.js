// JS-Verbesserungen für CiviCRM im Theme Verein Menschlichkeit
// Automatische Fokussierung auf das erste Fehlerfeld

document.addEventListener('DOMContentLoaded', function() {
  var firstError = document.querySelector('.civicrm-container .crm-error, .civicrm-container .error');
  if (firstError) {
    var input = firstError.closest('label, .crm-section, .form-item')?.querySelector('input, select, textarea');
    if (input) input.focus();
  }
  // Barrierefreiheit: Fehlermeldungen für Screenreader
  document.querySelectorAll('.civicrm-container .crm-error').forEach(function(el) {
    el.setAttribute('role', 'alert');
    el.setAttribute('aria-live', 'assertive');
  });
});
