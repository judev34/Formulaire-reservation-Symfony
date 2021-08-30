<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\PieceJointe;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        $articles = $this->entityManager->getRepository(Article::class)->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles
        ]);
    }

     /**
     * @Route("/articles/{slug}", name="article_details")
     */
    public function ArticleDetails($slug)
    {
        $article = $this->entityManager->getRepository(Article::class)->findOneBy([
            'slug' => $slug
        ]);

        if ($article == null) {
            return $this->redirectToRoute('blog');
        }

        $piecesjointes = $this->entityManager->getRepository(PieceJointe::class)->findBy([
            'post' => $article->getId()
        ]);

        return $this->render('blog/article.html.twig', [
            'article' => $article,
            'piecesjointes' => $piecesjointes,
        ]);
    }
}
