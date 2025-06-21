<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Service\InvoiceService;

// Beispiel für die Verwendung des InvoiceService
// Dies stellt sicher, dass die Klasse tatsächlich verwendet wird

$invoiceService = new InvoiceService();

// Beispielrechnungen
$baseAmount = 100.0;
$vat = $invoiceService->calculateVat($baseAmount);
$total = $invoiceService->calculateTotal($baseAmount);

echo "Base Amount: €" . number_format($baseAmount, 2) . "\n";
echo "VAT (19%): €" . number_format($vat, 2) . "\n";
echo "Total: €" . number_format($total, 2) . "\n";
