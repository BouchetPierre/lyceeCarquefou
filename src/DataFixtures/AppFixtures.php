<?php

namespace App\DataFixtures;

use App\Entity\Annonce;

use App\Entity\PictureUser;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use DateTime;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker =Factory::create('FR-fr');

        $adminRole = new Role();

        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $date = $faker->date($format = 'd-m-Y', $max = 'now');
        $yearsBac = new \DateTime($date);
        $adminUser = new User();
        $adminUser->setName('Admin')
            ->setLastname('Lycée')
            ->setInscriVal(1)
            ->setEmail('ancienshdo@gmail.com')
            ->setYearsBac($yearsBac)
            ->setTypeBac('S')
            ->setStudOrTeach('Teacher')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->addUserRole($adminRole);
        $manager->persist($adminUser);

        $manager->flush();
    }
}
