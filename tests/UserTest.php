<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testIsTrue(): void
    {
        $user = new User();

        $user->setEmail('user@test.com')
            ->setPassword('password');

        $this->assertTrue('user@test.com' === $user->getEmail());
        $this->assertTrue('password' === $user->getPassword());
    }

    public function testIsFalse(): void
    {
        $user = new User();

        $user->setEmail('user@test.com')
            ->setPassword('password');

        $this->assertFalse('test@test.com' === $user->getEmail());
        $this->assertFalse('pass' === $user->getPassword());
    }

    public function testIsEmpty(): void
    {
        $user = new User();

        $this->assertEmpty($user->getEmail());
        $this->assertEmpty($user->getPassword());
    }
}
