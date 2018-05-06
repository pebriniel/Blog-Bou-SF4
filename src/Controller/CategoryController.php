<?php
// src/Controller/CategoryController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use App\Entity\Category;


class CategoryController extends Controller
{

    /**
      * @Route("/create/category/",
      *         name="blog_category_create")
      */
    public function createCategory(Request $request){
        $category = new Category();

        $category->setName('Label');

        $form = $this->createFormBuilder($category)
            ->add('name', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Créer une catégorie'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $category = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('blog_article_create_success');
        }

        return $this->render('blogs/create.html.twig',array(
            'form' => $form->createView()
        ));
    }

    /**
      * @Route("/sucess/category",
      *         name="blog_category_create_success")
      */
    public function succcessCategory(){

        return $this->render('blogs/success.html.twig',array(
        ));
    }

}
