<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Repository\CategoryRepository;
use App\Entity\Topic;
use App\Entity\User;
use Faker\Factory;
use Faker\Generator;




class TopicControllerTest extends WebTestCase
{
    private $client = null;
    
    /** @var Generator */
    protected $faker;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = static::$kernel->getContainer()
        ->get('doctrine')
        ->getManager();
        $this->faker = Factory::create();

    }

    public function testTopicPage()
    {
        $this->logIn();

        $user = new User();
        $user->setUsername($this->faker->unique()->name);
        $user->setPassword(password_hash($this->faker->unique()->password, PASSWORD_BCRYPT));
        $user->setEmail($this->faker->unique()->email);

        $this->em->persist($user);
        $this->em->flush();

        $topic = new Topic();
        $topic->setTitle('xxxx');
        $topic->setMessage('xxxx');
        $topic->setUser($user);
        $topic->setIsImportant(true);

        $this->em->persist($topic);
        $this->em->flush();
        
        $crawler = $this->client->request('GET', '/topic/topic_section/'.$topic->getId());

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
    
