<?php

namespace App\Tests;

use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testIsTrue(): void
    {
        $customer = new Customer();

        $customer->setFirstname('firstname')
            ->setLastName('lastname')
            ->setEmail('customer@test.com')
            ->setCompany('company');

        $this->assertTrue('firstname' === $customer->getFirstname());
        $this->assertTrue('lastname' === $customer->getLastname());
        $this->assertTrue('customer@test.com' === $customer->getEmail());
        $this->assertTrue('company' === $customer->getCompany());
    }

    public function testIsFalse(): void
    {
        $customer = new Customer();

        $customer->setFirstname('firstname')
            ->setLastName('lastname')
            ->setEmail('customer@test.com')
            ->setCompany('company');

        $this->assertFalse('false' === $customer->getFirstname());
        $this->assertFalse('false' === $customer->getLastname());
        $this->assertFalse('false@test.com' === $customer->getEmail());
        $this->assertFalse('false' === $customer->getCompany());
    }

    public function testIsEmpty(): void
    {
        $customer = new Customer();

        $this->assertEmpty($customer->getFirstname());
        $this->assertEmpty($customer->getLastname());
        $this->assertEmpty($customer->getEmail());
        $this->assertEmpty($customer->getCompany());
    }
}
