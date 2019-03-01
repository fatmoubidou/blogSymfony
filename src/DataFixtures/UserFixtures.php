<?php

namespace App\DataFixtures;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Faker;

class UserFixtures extends Fixture
{
  private $encoder;

  public function __construct(UserPasswordEncoderInterface $encoder)
  {
      $this->encoder = $encoder;
  }

  public function load(ObjectManager $manager)
  {
      //User Admin
      $user = new User();
      $user->setName('Fatma');
      $user->setEmail('fatma212@hotmail.fr');
      $password = $this->encoder->encodePassword($user, 'test'); //cryptage du password
      $user->setPassword($password);
      $user->setRoles(['ROLE_ADMIN']);
      $manager->persist($user);

      // On configure dans quelles langues nous voulons nos données
      $faker = Faker\Factory::create('fr_FR');

      //Creation 10 basic users
      for ($i=0; $i < 10; $i++) {
        $user = new User();
        $user->setName($faker->name);
        $user->setEmail($faker->email);
        $password = $this->encoder->encodePassword($user, 'test'.$i); //cryptage du password
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);
      }

      $manager->flush();
  }
}
