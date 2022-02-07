<?php

namespace App\Tests\Http\Controller;

use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class HomePageControllerTest extends WebTestCase
{
    public function testHomePage()
    {
        $this->client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->expectTitle("Page d'acceuil");
        $this->expectH1('Bienvenue');
    }
}
