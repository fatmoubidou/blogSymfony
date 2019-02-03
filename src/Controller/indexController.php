<?php
// src/Controller/indexController.php
namespace App\Controller; //tous les controllers se trouvent dans ce dossier

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Article;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response; //objet Response

class indexController  extends AbstractController
{
  /**
   *@Route("/index", name="accueil")
   */

  public function accueil(){
    $repository = $this->getDoctrine()->getRepository(Article::class);
    // look for *all* Product objects
    //$articles = $repository->findAll();
    $articles = $repository->findBy(array(), array('id' => 'DESC'),3);

    return $this->render("base.html.twig",["articles"=> $articles]);
  }
}

?>
