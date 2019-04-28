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
     * @Route("/", name="")
     */
    public function index(CategoryRepository $categoryRepository)
    {
        return $this->render('home/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category_section/{id}", name="category_section", methods={"GET"})
     */
    public function showCategorySection(Category $category){
        
        $topics = $category->getTopics();
        
        return $this->render('home/category_section.html.twig', [
            'category' => $category,
            'topics' => $topics
        ]);
    }


    /**
     * @Route("/topic_section/{id}", name="topic_section", methods={"GET"})
     */
    public function showTopicSection(Topic $topic){
                
        $posts = $topic->getPosts();

        return $this->render('home/topic_section.html.twig', [
            'topic' => $topic,
            'posts' => $posts
        ]);
    }
}
