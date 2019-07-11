<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Post\PostRepository;

final class SitemapController extends AbstractController
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(): Response
    {
        $posts = $this->postRepository->getPosts();

        return $this->render('sitemap/sitemap.xml.twig', [
            'posts' => $posts,
        ]);
    }
}
