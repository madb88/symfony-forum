<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Entity\Category;
use App\Repository\TopicRepository;
use App\Entity\Topic;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryRepository $categoryRepository)
    {

        $categories =  $categoryRepository->findAll();
        $this->countCategoryTopics($categories);

        return $this->render('home/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    private function countCategoryTopics($categories) : void
    {
        foreach($categories as $category){
            $category->countedTopics = count($category->getTopics());
        }

    }

  
    
}
