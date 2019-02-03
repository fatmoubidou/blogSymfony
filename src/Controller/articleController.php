<?php
// src/Controller/articleController.php
namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Service\ContentFilter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class articleController extends AbstractController
{
    /**
     * @Route("/newArticle", name="newArticle")
     */
    public function new()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();

        $article = new Article();
        $article->setDateCreation(new \DateTime('@'.strtotime('now')));
        $article->setTitle('mon premier article');
        $article->setContents('il était une fois...');
        $article->setIdAuthor(1);
        $article->setIdCat(2);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($article);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('un nouvel article ajouté avec id '.$article->getId());
    }



  /**
   *@Route("/article/{id}", name="app_article", requirements={"id"="\d+"})
   */
  public function single($id = 1){
    $repository = $this->getDoctrine()->getRepository(Article::class);
    // look for a single Product by its primary key (usually "id")
    $article = $repository->find($id);
    $filtre = new ContentFilter();
    $contents = $filtre->getContentFilter($article->getContents());


    return $this->render("article/article_details.html.twig",["article"=> $article,"contents"=> $contents]);
  }

  /**
   *@Route("/admin", name="app_admin")
   */
  public function admin(){
    return $this->render("article/article_add.html.twig");
  }

  /**
   *@Route("/admin/article", name="app_admin_article")
   */
  public function adminArticle(){
    return $this->render("article/article_add.html.twig");
  }

  /**
   *@Route("/admin/article/add", name="app_admin_article_add")
   */
  public function add(Request $request){

        // creates an article and gives it some dummy data for this example
        $article = new Article();
        $article->setTitle('mon premier article');
        $article->setContents('il était une fois...');
        $article->setDateCreation(new \DateTime('@'.strtotime('now')));
        $article->setIdAuthor(1);
        $article->setIdCat(2);

        $form = $this->createFormBuilder($article)
            ->add('date_creation', DateType::class, ['disabled' => true])
            ->add('title', TextType::class, ['label' => 'Titre'])
            ->add('contents', TextareaType::class, ['label' => 'Contenu'])
            ->add('id_author', TextType::class, ['label' => 'Auteur'])
            ->add('id_cat', TextType::class, ['label' => 'Catégorie'])
            ->add('save', SubmitType::class, ['label' => 'Envoyer un article'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $article = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if A is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('article_success');
        }

        return $this->render('article/article_add.html.twig', [
            'form' => $form->createView(),
        ]);
  }



  /**
   *@Route("/admin/article/succes", name="article_success")
   */
  public function article(ValidatorInterface $validator)
  {
      $article = new Article();

      // ... do something to the $author object

      $errors = $validator->validate($article);

      if (count($errors) > 0) {
          /*
           * Uses a __toString method on the $errors variable which is a
           * ConstraintViolationList object. This gives us a nice string
           * for debugging.
           */
          $errorsString = (string) $errors;

          return new Response($errorsString);
      }

      return new Response('Article valide!');
  }

}

?>
