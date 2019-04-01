<?php

namespace App\Tests\Controller;

use Symfony\Component\Panther\PantherTestCase;

class BlogListControllerTest extends PantherTestCase
{
    public function testBlogList()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/blog');

        $this->assertEquals(200, $client->getInternalResponse()->getStatusCode());
        $this->assertContains('tentacode', $crawler->filter('h1')->html());
        $this->assertContains('blog', $crawler->filter('h1')->html());
    }
}
