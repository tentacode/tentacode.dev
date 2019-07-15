<?php declare(strict_types=1);

namespace App\Post;

final class Post
{
    protected $content;
    protected $slug;
    protected $date;

    public function __construct(Content $content, string $slug, \DateTime $date)
    {
        $this->content = $content;
        $this->slug = $slug;
        $this->date = $date;
    }

    public function getContent(): Content
    {
        return $this->content;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): string
    {
        if ($this->content->hasMetadata('post_description')) {
            return $this->content->getMetadata('post_description');
        }

        return $this->content->getExcerpt(300);
    }
}
