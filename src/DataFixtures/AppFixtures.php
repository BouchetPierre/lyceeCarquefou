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
            ->setEmail('bouchet.hp@gmail.com')
            ->setYearsBac($yearsBac)
            ->setTypeBac('S')
            ->setStudOrTeach('Teacher')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->addUserRole($adminRole);
        $manager->persist($adminUser);

// Users
        $users = [];
        $genres = ['male', 'female'];

        for($i=1; $i<=30; $i++) {
            $user = new User();
            $choixType= ['S', 'L','ES'];
            $typeBac = $choixType[rand(0,2)];
            $date = $faker->date($format = 'd-m-Y', $max = 'now');
            $yearsBac = new \DateTime($date);
            $choixTypeTwo= ['Student', 'Teacher'];
            $type = $choixTypeTwo[rand(0,1)];
            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setName($faker->firstName)
                ->setLastname($faker->lastName)
                ->setTypeBac($typeBac)
                ->setInscriVal(0)
                ->setStudOrTeach($type)
                ->setYearsBac($yearsBac)
                ->setEmail($faker->email)
                ->setHash($hash)

                ;

            $manager->persist($user);
            $users [] = $user;
        }

        $manager->flush();
    }
}
