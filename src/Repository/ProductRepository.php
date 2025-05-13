<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, ProductRepository $productRepository)
    {
        parent::__construct($registry, Product::class);
    }
 //Exo 20 sécurité contre injections SQL
    public function findByTitleContain(string $search): array {
        $queryBuilder = $this->createQueryBuilder('product');
        $query = $queryBuilder
                ->select('product')
            // le fait d'utiliser les parametres (donc mettre la variable
            // contenant la recherche utilisateur en deux temps)
            // permet de sécuriser la requête SQL (éviter les injections SQL)
            // c'est à dire, vérifier que la recherche utilisateur ne contient
            // de requête SQL (attaque)
                
                ->where('product.title LIKE :search')
                ->setParameter('search', '%'.$search.'%')
                ->getQuery();

        return $query->getResult();
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
