<?php
// src/Controller/ArticlesController.php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security AS Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Articles;

/**
 * @Route("/article")
 */

class ArticlesController extends Controller
{
    /**
      * @Route("/{id}/{slug}",
      *         defaults={"slug": "html"},
      *         name="blog_article",
      *         requirements={"id"="\d+"})
      */
    public function article($id = 1, $slug)
    {
        $repository = $this->getDoctrine()
            ->getRepository(Articles::class);

        $Articles = $repository->find($id);

        if (!$Articles) {
            throw $this->createNotFoundException(
                'No Articles found for id '.$id
            );
        }

        $response = $this->render('Blogs/article.html.twig', array(
            'article' => $Articles
        ));

        if($slug == 'json'){
            $response = $this->returnJson($Articles);
        }
        return $response;
    }

    private function returnJson(Articles $Articles){
        $article['title'] = $Articles->getTitle();
        $article['contents'] = $Articles->getContents();

        return $this->json($article);
    }

}
