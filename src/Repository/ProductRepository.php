<?php

namespace App\Repository;

use App\DTOs\ProductDTO;
use App\Entity\Product;
use App\Entity\ProductCategoryMembership;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry,
    private readonly CategoryRepository $CategoryRepository
    )
    {
        parent::__construct($registry, Product::class);
    }

    public function Create(ProductDTO $productDTO): Product
    {       
        $productcat = $this->CategoryRepository->find($productDTO->category);       
        if(!$productcat) {
            throw new \InvalidArgumentException('category not found');
        }

        $products = new Product();
        $products->setName($productDTO->name);
        $products->setDescription($productDTO->description);
        $products->setPrice($productDTO->price);
        $products->setIsAvailable($productDTO->isAvailable);
        $this->getEntityManager()->persist(object: $products);


        $productcategory = new ProductCategoryMembership();
        $productcategory->setProduct($products);
        $productcategory->setCategory($productcat);
        $this->getEntityManager()->persist(object: $productcategory);


        return $products;
    }
    




//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
