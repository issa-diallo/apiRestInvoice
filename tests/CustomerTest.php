<?php

namespace App\Tests;

use App\Entity\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testIsTrue(): void
    {
        $customer = new Customer();

        $customer->setFirstname("firstname")
            ->setLastName("lastname")
            ->setEmail("customer@test.com")
            ->setCompany("company");

        $this->assertTrue($customer->getFirstname() === "firstname");
        $this->assertTrue($customer->getLastname() === "lastname");
        $this->assertTrue($customer->getEmail() === "customer@test.com");
        $this->assertTrue($customer->getCompany() === "company");
    }

    public function testIsFalse(): void
    {
        $customer = new Customer();

        $customer->setFirstname("firstname")
            ->setLastName("lastname")
            ->setEmail("customer@test.com")
            ->setCompany("company");

        $this->assertFalse($customer->getFirstname() === "false");
        $this->assertFalse($customer->getLastname() === "false");
        $this->assertFalse($customer->getEmail() === "false@test.com");
        $this->assertFalse($customer->getCompany() === "false");
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
