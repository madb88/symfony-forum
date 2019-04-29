<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Repository\CategoryRepository;



class CategoryControllerTest extends WebTestCase
{
    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = static::$kernel->getContainer()
        ->get('doctrine')
        ->getManager();
    }

    public function testCategoryPage()
    {
        $this->logIn();

        $category = new Category();
        $category->setName('xxxx');
        $category->setDescription('xxxx');

        $this->em->persist($category);
        $this->em->flush();
        
        $crawler = $this->client->request('GET', '/category/category_section/'.$category->getId());

        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('admin', null, $firewallName, ['ROLE_USER']);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
    
