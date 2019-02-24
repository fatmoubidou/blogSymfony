<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      // create 5 categories! Bam!
      for ($i = 0; $i < 5; $i++) {
          $category = new Category();
          $category->setName('Categorie'.$i);
          $manager->persist($category);
          $this->categories[] = $category; //tab categories
      }

        $manager->flush();
    }
}
