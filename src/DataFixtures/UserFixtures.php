<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;


class UserFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordEncoder, private SluggerInterface $slugger)
    {
    }

    public function load(ObjectManager $manager): void
    {

        $admin = new Users();
        $admin->setEmail('admin@test.fr');
        $admin->setLastname('RAMON');
        $admin->setFirstname('Thomas');
        $admin->setCity('Montpellier');
        $admin->setCountry('France');
        $admin->setPhone('0606060606');
        $admin->setPassword($this->passwordEncoder->hashPassword($admin, 'admin'));
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush();

        $faker = Faker\Factory::create('fr_FR');

        for ($user = 1; $user <= 20; $user++) {
            $this->createUser($faker->email, $faker->lastName, $faker->firstName, $faker->city, $faker->country, '0606060606', 'azerty', $manager);
            $manager->flush();
        }
    }

    public function createUser(string $email, string $lastname, string $firstname, string $city, string $country, string $phone, string $password, ObjectManager $manager)
    {
        $user = new Users();
        $user->setEmail($email);
        $user->setLastname($lastname);
        $user->setFirstname($firstname);
        $user->setCity($city);
        $user->setCountry($country);
        $user->setPhone($phone);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));

        $manager->persist($user);

        return $user;
    }
}
