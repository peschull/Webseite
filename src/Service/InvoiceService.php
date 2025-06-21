<?php

namespace App\Service;

class InvoiceService
{
    public function calculateVat(float $amount, float $vatRate = 0.19): float
    {
        return $amount * $vatRate;
    }

    public function calculateTotal(float $amount, float $vatRate = 0.19): float
    {
        return $amount + $this->calculateVat($amount, $vatRate);
    }
}
