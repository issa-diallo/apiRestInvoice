<?php

namespace App\Tests;

use App\Entity\Customer;
use App\Entity\Invoice;
use DateTime;
use PHPUnit\Framework\TestCase;

class InvoiceTest extends TestCase
{
    public function testIsTrue(): void
    {
        $invoice = new Invoice();
        $customer = new Customer();
        $datetime = new DateTime();

        $invoice->setAmount(100.00)
            ->setSentAt($datetime)
            ->setStatus('PAID')
            ->setCustomer($customer)
            ->setChrono(32);

        $this->assertTrue(100.00 === $invoice->getAmount());
        $this->assertTrue($datetime === $invoice->getSentAt());
        $this->assertTrue('PAID' === $invoice->getStatus());
        $this->assertTrue($customer === $invoice->getCustomer());
        $this->assertTrue(32 === $invoice->getChrono());
    }

    public function testIsFalse(): void
    {
        $invoice = new Invoice();
        $customer = new Customer();
        $datetime = new DateTime();

        $invoice->setAmount(100.00)
            ->setSentAt($datetime)
            ->setStatus('PAID')
            ->setCustomer($customer)
            ->setChrono(32);

        $this->assertFalse(110.00 === $invoice->getAmount());
        $this->assertFalse(new Datetime() === $invoice->getSentAt());
        $this->assertFalse('CANCELLED' === $invoice->getStatus());
        $this->assertFalse(new Customer() === $invoice->getCustomer());
        $this->assertFalse(30 === $invoice->getChrono());
    }

    public function testIsEmpty(): void
    {
        $invoice = new Invoice();

        $this->assertEmpty($invoice->getAmount());
        $this->assertEmpty($invoice->getSentAt());
        $this->assertEmpty($invoice->getStatus());
        $this->assertEmpty($invoice->getCustomer());
        $this->assertEmpty($invoice->getChrono());
    }
}
