<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Post\PostRepository;

final class BlogDetailController extends AbstractController
{
    private $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function __invoke(string $slug): Response
    {
        try {
            $post = $this->postRepository->findPostBySlug($slug);
        } catch (\Exception $e) {
            throw $this->createNotFoundException(sprintf(
                'The post with slug "%s" does not exist',
                $slug
            ));
        }

        return $this->render('blog/detail.html.twig', [
            'post' => $post,
        ]);
    }
}
