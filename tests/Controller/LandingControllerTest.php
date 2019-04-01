<?php

namespace App\Tests\Controller;

use Symfony\Component\Panther\PantherTestCase;

class LandingControllerTest extends PantherTestCase
{
    public function testLanding()
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getInternalResponse()->getStatusCode());
        $this->assertContains('@tentacode', $crawler->filter('title')->html());
    }
}
