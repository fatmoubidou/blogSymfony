<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;
use App\Entity\Article;
use Faker;

class AppFixtures extends Fixture
{

    private $categories;

    public function load(ObjectManager $manager)
    {
      // create 5 categories! Bam!
      for ($i = 0; $i < 5; $i++) {
          $category = new Category();
          $category->setName('Categorie'.$i);
          $manager->persist($category);
          $this->categories[] = $category; //tab categories
      }

      // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        for ($i=0; $i < 9; $i++) {
          $article = new Article();
          $article->setTitle('Article n°'.$i);
          $article->setContents($faker->text);
          $article->setImage($faker->imageUrl($width = 200, $height = 250));
          $article->setDateCreation($faker->dateTime($max = 'now', $timezone = null));
          $article->setCategory($this->categories[rand(0, count($this->categories)-1)]); //choix aleatoire de la categorie
          $manager->persist($article);
        }

        $manager->flush();
    }
}
