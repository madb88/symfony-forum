<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Post;


class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function index()
    {
        return $this->render('search/index.html.twig', [
            'controller_name' => 'SearchController',
        ]);
    }

    public function search()
    {
        $form = $this->createFormBuilder(null)
            ->add('post_search', TextType::class)
            ->add('search', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary'
            ]
        ])
        ->getForm();

        return $this->render('search/searchBar.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/search_action", name="search_action", methods={"GET","POST"})
    */
    public function searchAction(Request $request)
    {
    
        $value = $request->get('form')['post_search']; 
        
        $posts = $this->getDoctrine()
        ->getRepository(Post::class)
        ->findByQuery($value);

        return $this->render('search/index.html.twig', [
            'posts'=>$posts
        ]);
    }
}
