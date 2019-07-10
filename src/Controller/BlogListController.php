<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Post\PostRepository;
use Symfony\Component\HttpFoundation\Request;

final class BlogListController extends AbstractController
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(string $_format): Response
    {
        if ($_format === 'xml') {
            $_format = 'rss';
        }

        $posts = $this->postRepository->getPosts();

        return $this->render(sprintf(
            'blog/list.%s.twig',
            $_format
        ), [
            'posts' => $posts,
        ]);
    }
}
