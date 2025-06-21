<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Service\InvoiceService;

final class InvoiceServiceTest extends TestCase
{
    public function testVatIsCalculatedCorrectly(): void
    {
        $svc = new InvoiceService();
        $this->assertSame(19.0, $svc->calculateVat(100.0, 0.19));
    }

    public function testTotalIsCalculatedCorrectly(): void
    {
        $svc = new InvoiceService();
        $this->assertSame(119.0, $svc->calculateTotal(100.0, 0.19));
    }
}
