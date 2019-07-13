<?php declare(strict_types=1);

namespace App\Post;

use ParsedownExtra;

final class Content
{
    private $markdown;
    private $metadatas = [];

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

    public function getBody(): string
    {
        $markdown = $this->getMarkdownBody();
        
        $markdown = $this->stripMetadatas($markdown);

        $parser = new ParsedownExtra();

        $html = $parser->text($markdown);
        $html = $this->autoAnchor($html);

        return $html;
    }

    private function stripMetadatas(string $markdown): string
    {
        if (!preg_match("/^-{3}\n(.*)\n-{3}\n(.*)$/s", $markdown, $matches)) {
            return $markdown;
        }

        list($all, $metadatas, $body) = $matches;
        $metadatas = explode("\n", $metadatas);
        foreach ($metadatas as $metadata) {
            $this->addMetadata($metadata);
        }

        return $body;
    }

    private function addMetadata(string $metadata): void
    {
        if (!preg_match('/^([^:]+):(.+)$/', $metadata, $matches)) {
            throw new \InvalidArgumentException(sprintf(
                'Metadata "%s" is invalid. Should be "key: value".',
                $metadata
            ));
        }

        list($all, $key, $value) = $matches;

        $this->metadatas[$key] = trim($value);
    }

    public function getMetadata(string $key): string
    {
        if (!$this->hasMetadata($key)) {
            throw new \RuntimeException(sprintf(
                'Metadata "%s" does no exist.',
                $key
            ));
        }

        return $this->metadatas[$key];
    }

    public function hasMetadata(string $key): bool
    {
        return isset($this->metadatas[$key]);
    }

    private function autoAnchor(string $html): string
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

        if ($html === null) {
            throw new \RuntimeException(sprintf(
                'Could not replace titles. Preg last error : %s.',
                preg_last_error()
            ));
        }

        return $html;
    }

    private function getMarkdownBody(): string
    {
        $markdown = str_replace(
            sprintf('# %s', $this->getTitle()),
            '',
            $this->markdown
        );

        return trim($markdown);
    }
}
