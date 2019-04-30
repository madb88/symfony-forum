<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Repository\TopicRepository;
use App\Entity\Topic;
use App\Repository\PostRepository;
use App\Entity\Post;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $categoryRepository, PostRepository $postRepository)
    {

        $categories =  $categoryRepository->findAll();
        $this->countCategoryTopics($categories);

        $newestPosts = $postRepository->findBy([],['id' => 'DESC'], 4);
       

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
            'newestPosts' => $newestPosts
        ]);
    }

    private function countCategoryTopics($categories) : void
    {
        foreach($categories as $category){
            $category->countedTopics = count($category->getTopics());
        }

    }

  
    
}
