<?php

namespace App\Tests\Http\Controller;

use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RegisterControllerTest extends WebTestCase
{
    public function testGetRegisterPage(): void
    {

        $this->client->request('GET', '/register');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->expectTitle("Register");
        $this->expectH1('Register');
    }
    public function testFormWithGoodInfo(): void
    {
        $crawler = $this->client->request('GET', '/register');
        $form = $crawler->selectButton('Register')->form([
            'register_form[username]' => 'test',
            'register_form[email][first]' => 'test@test.com',
            'register_form[email][second]' => 'test@test.com',
            'register_form[plainPassword][first]' => '1',
            'register_form[plainPassword][second]' => '1'
        ]);
        $this->client->submit($form);
        $this->assertResponseRedirects();
    }
}
