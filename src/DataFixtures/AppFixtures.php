<?php

namespace App\DataFixtures;

use App\Entity\Restaurant;
use App\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $customer = new Customer();
        $customer->setFirstName('admin');
        $customer->setLastName('admin');
        $customer->setEmail('admin@admin.com');
        $customer->setRoles(['ROLE_ADMIN']);

        $password = $this->hasher->hashPassword($customer, 'adminadmin');
        $customer->setPassword($password);

        $manager->persist($customer);

        $restaurant = new Restaurant();
        $restaurant->setName('Quai Antique');
        $restaurant->setSeatingCapacity(100);

        $manager->persist($restaurant);
        $manager->flush();
    }
}
