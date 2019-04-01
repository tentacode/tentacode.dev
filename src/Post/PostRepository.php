<?php declare(strict_types=1);

namespace App\Post;

use Symfony\Component\Finder\Finder;

final class PostRepository
{
    private $postDirectory;

    public function __construct(string $postDirectory)
    {
        $this->postDirectory = $postDirectory;
    }

    public function getPosts(): array
    {
        $posts = [];

        foreach ($this->getPostFiles() as $filename) {
            $posts[] = $this->createPostFromFile((string)$filename);
        }

        return $this->sortPosts($posts);
    }

    public function findPostBySlug(string $slug): Post
    {
        $postFile = $this->getPostFileBySlug($slug);

        return $this->createPostFromFile($postFile);
    }

    protected function createPostFromFile(string $filename): Post
    {
        $fileContent = file_get_contents($filename);
        if ($fileContent === false) {
            throw new \InvalidArgumentException(sprintf(
                'Could not find content in file "%s".',
                $filename
            ));
        }

        $content = new Content($fileContent);

        if (!preg_match('/^([0-9]{8})_(.*)\.md$/', basename($filename), $matches)) {
            throw new \RuntimeException(sprintf(
                'One post have an invalid filename "%s"',
                $filename
            ));
        }

        $date = new \DateTime($matches[1]);
        $slug = $matches[2];

        return new Post($content, $slug, $date);
    }

    protected function getPostFiles(): Finder
    {
        $finder = new Finder();

        return $finder
            ->files()
            ->in($this->postDirectory)
        ;
    }

    protected function getPostFileBySlug($slug): string
    {
        $finder = new Finder();

        $files = $finder
            ->files()
            ->name(sprintf('*%s.md', $slug))
            ->in($this->postDirectory)
        ;

        foreach ($files as $file) {
            return (string)$file;
        }

        throw new \RuntimeException('File not found.');
    }

    protected function sortPosts(array $posts): array
    {
        uasort($posts, function ($postA, $postB) {
            $dateA = $postA->getDate();
            $dateB = $postB->getDate();

            return $dateB <=> $dateA;
        });

        return $posts;
    }
}
