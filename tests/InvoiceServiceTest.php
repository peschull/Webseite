<?php
declare(strict_types=1);
use PHPUnit\Framework\TestCase;
final class InvoiceServiceTest extends TestCase {
    public function testVatIsCalculatedCorrectly(): void {
        $svc = new App\Service\InvoiceService();
        $this->assertSame(120, $svc->addVat(100, 20));
    }
}

