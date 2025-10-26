<?php

namespace App\Controller;

use App\DTOs\ProductDTO;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/Product' , name:'Product_')]
final class ProductController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly SerializerInterface $serializer,
        private readonly ProductRepository $productRepository
    ){}

    #[Route('' , name:'Create' , methods:['POST'])]
    public function CreateProduct(
        #[MapRequestPayload] ProductDTO $productDTO,
    ):Response
    {
        $product = $this->productRepository->Create($productDTO);
       
        $this->em->flush();   


        return new Response("Product Created Successfully");

    }

    #[Route('' , name:'List' , methods:['GET'])]
    public function ProductList():Response{
           
        $productList = $this->productRepository->findAll();

        if(!$productList){
            return new Response('Product list is empty');
        }else{
            $data = $this->serializer->serialize($productList , 'json');

            return JsonResponse::fromJsonString($data);
        }
    }

    #[Route('/{id}' , name:'Delete' , methods:['DELETE'])]
    public function DeleteProduct(int $id):Response{
        $product = $this->productRepository->find($id);
        $this->em->remove($product);
        $this->em->flush();
        return new Response("Product Deleted Successfully");
        }



        // #[Route('/{id}' , name:'Update' , methods:['PUT' , 'PATCH'])]
        // public function UpdateProduct($id,
        //     #[MapRequestPayload] ProductDTO $productDTO,
        // ):Response{
           
        //     return new Response("Product Updated Successfully");
        // }


}