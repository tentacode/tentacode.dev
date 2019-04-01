<?php declare(strict_types=1);

namespace App\Post;

use ParsedownExtra;

final class Content
{
    protected $markdown;

    public function __construct(string $markdown)
    {
        $this->markdown = $markdown;
    }

    public function getTitle(): string
    {
        if (preg_match('/^# (.*)$/m', $this->markdown, $matches)) {
            return $matches[1];
        }

        return '';
    }

    public function getText(): string
    {
        $html = $this->getBody();

        return strip_tags($html);
    }

    public function getExcerpt(int $characterCount): string
    {
        $text = trim($this->getText());
        if (strlen($text) <= $characterCount) {
            return $text;
        }

        $text = substr($text, 0, $characterCount);

        $cutCount = strrpos($text, ' ');
        if ($cutCount === false) {
            $cutCount = strlen($text);
        }

        $text = substr($text, 0, $cutCount);
        $text = $text."…";

        return $text;
    }

    public function getBody()
    {
        $markdown = $this->getMarkdownBody();
        $parser = new ParsedownExtra();
        
        $html = $parser->text($markdown);
        $html = $this->autoAnchor($html);

        return $html;
    }

    protected function autoAnchor($html)
    {
        // on each title, auto set anchor
        $html = preg_replace_callback('/<h([1-6])>(.*)<\/h([1-6])>/u', function ($matches) {
            $id = preg_replace('/[\W|_]/', '', $matches[2]) ?? '';
            if (is_array($id)) {
                throw new \RuntimeException('preg_replace can only replace one id at a time.');
            }
            
            $id = strtolower($id);
            
            return sprintf('<h%s id="%s">%s</h%s>', $matches[1], $id, $matches[2], $matches[3]);
        }, $html);

        return $html;
    }

    protected function getMarkdownBody()
    {
        $markdown = str_replace(
            sprintf('# %s', $this->getTitle()),
            '',
            $this->markdown
        );

        return trim($markdown);
    }
}
