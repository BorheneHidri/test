<?php

namespace App\Controller;

use App\DTOs\CategoryDTO;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;



    #[Route(path: '/category', name: 'Category_')]

final class CategoryController extends AbstractController
{

    public function __construct(
        private readonly EntityManagerInterface $em
    ){}

    
    #[Route(path:'', name:'Create' , methods: ['POST'])]
    public function Create(
        #[MapRequestPayload] CategoryDTO $dto,
    ):Response{

        $category = new Category();
        $category->setName($dto->name);
        $category->setDescription($dto->description);

        $this->em->persist(object: $category);
        $this->em->flush();
        

        return new Response("Category Created Successfully");
    }
  
}
