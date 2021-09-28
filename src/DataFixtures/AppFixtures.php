<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Invoice;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($u = 0; $u < 12; ++$u) {
            $user = new User();

            $chrono = 1;

            $hashed = $this->encoder->hashPassword($user, 'password');

            $user->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setEmail($faker->email())
                ->setPassword($hashed);

            $manager->persist($user);

            for ($c = 0; $c < 30; ++$c) {
                $customer = new Customer();
                $customer->setFirstname($faker->firstName())
                    ->setLastname($faker->lastName())
                    ->setEmail($faker->email())
                    ->setCompany($faker->company());

                $manager->persist($customer);

                for ($i = 0; $i < mt_rand(3, 12); ++$i) {
                    $invoice = new Invoice();
                    $invoice->setAmount($faker->randomFloat(2, 30, 658))
                        ->setSentAt($faker->dateTimeBetween('-6 months'))
                        ->setStatus($faker->randomElement(['SENT', 'PAID', 'CANCELLED']))
                        ->setChrono($chrono)
                        ->setCustomer($customer);

                    ++$chrono;

                    $manager->persist($invoice);
                }
            }
        }

        $manager->flush();
    }
}
