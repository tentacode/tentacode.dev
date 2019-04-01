<?php

namespace App\Tests\Util;

use Symfony\Component\Panther\PantherTestCase;

class BlogDetailControllerTest extends PantherTestCase
{
    public function testBlogDetail()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/metabase-with-kittens');

        $this->assertEquals(200, $client->getInternalResponse()->getStatusCode());
        $this->assertContains('Metabase with kitten', $crawler->filter('h1')->html());
    }
}
