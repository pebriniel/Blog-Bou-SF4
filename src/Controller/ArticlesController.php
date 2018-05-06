<?php
// src/Controller/ArticlesController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Articles;
use App\Entity\Category;


class ArticlesController extends Controller
{
    /**
      * @Route("/article/{id}",
      *         name="blog_article",
      *         requirements={"id"="\d+"})
      */
    public function article($id = 1)
    {
        $number = mt_rand(0, 100);
        $Articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);

        if (!$Articles) {
            throw $this->createNotFoundException(
                'No Articles found for id '.$id
            );
        }

        return $this->render('blogs/article.html.twig', array(
            'number' => $number,
            'article' => $Articles
        ));
    }

    /**
      * @Route("/create",
      *         name="blog_article_create")
      */
    public function create(Request $request){
        $Articles = new Articles();

        $Articles->setTitle('Titre de l\'article');
        $Articles->setDateInsert(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($Articles)
            ->add('title', TextType::class)
            ->add('contents', TextareaType::class)
            ->add('dateinsert', DateType::class)
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true, //checbkox
            ))
            ->add('save', SubmitType::class, array('label' => 'Créer article'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $Articles = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Articles);
            $entityManager->flush();

            return $this->redirectToRoute('blog_article_create_success');
        }

        return $this->render('blogs/create.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
      * @Route("/sucess",
      *         name="blog_article_create_success")
      */
    public function succcess(){

        return $this->render('blogs/success.html.twig',array(
        ));
    }

}
