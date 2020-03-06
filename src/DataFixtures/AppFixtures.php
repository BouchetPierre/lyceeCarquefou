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

        $adminUser = new User();
        $adminUser->setName('Bouchet')
            ->setLastname('Pierre')
            ->setAddress('99 Rue Edmond Halley')
            ->setEmail('pf.bouchet@orange.fr')
            ->setHash($this->encoder->encodePassword($adminUser, 'password'))
            ->addUserRole($adminRole);
        $manager->persist($adminUser);

// Users
        $users = [];
        $genres = ['male', 'female'];

        for($i=1; $i<=5; $i++) {
            $user = new User();

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setName($faker->lastName)
                ->setLastname($faker->firstName)
                ->setAddress($faker->address)
                ->setEmail($faker->email)
                ->setHash($hash)

                ;

            $manager->persist($user);
            $users [] = $user;
        }

// Annonces
        for($i=1; $i <=20; $i++) {
            $annonce = new Annonce;
            $choixType= ['annonce', 'bricolage', 'jardinage','sortie','fete'];
            $type = $choixType[rand(0,4)];
            $title = $faker->sentence();
            $introduction = $faker->paragraph(2);
            $content = '<p>'.join("</p><p>",$faker->paragraphs(5)).'</p>';

            $user =$users[mt_rand(0, count($users)-1)];

            $annonce->setTitle($title)
                    ->setType($type)
                    ->setIntroduction($introduction)
                    ->setContent($content)
                    ->setAuthor($user)
            ;




            $manager->persist($annonce);
        }

        $manager->flush();
    }
}
