<?php
// src/Controller/indexController.php
namespace App\Controller; //tous les controllers se trouvent dans ce dossier

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use App\Entity\Category;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response; //objet Response

class indexController  extends AbstractController
{
  /**
   *@Route("/index", name="accueil")
   */
  public function accueil(){
    $repositoryArticle = $this->getDoctrine()->getRepository(Article::class);
    $articles = $repositoryArticle->findBy(array(), array('dateCreation' => 'DESC'),3);

    $repositoryCategory = $this->getDoctrine()->getRepository(Category::class);
    $categories = $repositoryCategory->findAll();

    return $this->render("base.html.twig",["articles"=> $articles, "categories"=> $categories]);
  }
}

?>
