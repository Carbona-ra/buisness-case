<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private const USERS = [
        "tom@gmail.com" => "tommy1234",
        "bob@gmail.com" => "bobby1234",
        "will@gmail.com" => "willy1234",
        "bill@gmail.com" => "billy1234",
        "bryan@gmail.com" => "bryan1234",
    ];

    private array $dbUsers = [];
    private array $dbCategories = [];

    public function __construct(
        private SerializerInterface $serializer,
        private UserPasswordHasherInterface $hasher
    ) {
    }
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $this->loadUsers($manager, $faker);

        $manager->flush();
    }

    private function loadUsers(ObjectManager $manager, Generator $faker): void
    {
        $admin = new User();
        $admin
            ->setFirsname($faker->firstName())
            ->setLastname($faker->lastName())
            ->setEmail("admin@hb-corp.com")
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword($admin, "admin1234"));
        $manager->persist($admin);

        foreach (self::USERS as $email => $password) {
            $user = new User();
            $user
                ->setFirsname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setEmail($email)
                ->setPassword($this->hasher->hashPassword($user, $password));
            $manager->persist($user);
            $this->dbUsers[] = $user;
        }
    }
}
