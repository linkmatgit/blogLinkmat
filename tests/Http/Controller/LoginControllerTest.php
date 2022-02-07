<?php

namespace App\Tests\Http\Controller;

use App\Domain\Auth\Entity\User;
use App\Domain\Auth\Repository\UserRepository;
use App\Tests\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class LoginControllerTest extends WebTestCase
{
    public function testGetLoginPages(): void
    {

        $this->client->request('GET', '/login');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->expectTitle("Log in!");
    }

    public function testLogin(): void
    {

        $user = (new User())->setUsername('linkmat')
            ->setEmail('linkmat@linkmat.com');


        $this->client->loginUser($user);
        $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();
    }
}
