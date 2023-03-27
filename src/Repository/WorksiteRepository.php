<?php

namespace App\Repository;

use App\Entity\Worksite;
use App\DTO\SearchWorksiteCriteria;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Worksite>
 *
 * @method Worksite|null find($id, $lockMode = null, $lockVersion = null)
 * @method Worksite|null findOneBy(array $criteria, array $orderBy = null)
 * @method Worksite[]    findAll()
 * @method Worksite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorksiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Worksite::class);
    }

    public function save(Worksite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Worksite $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    // ---------- findTargetCategory ----------
    // Fonction affichage des chantiers de la catégorie ciblée
    public function findTargetCategory(int $id): array
    {
        $queryBuilder = $this->createQueryBuilder('worksite'); // créer la requête pour worksite

        return $queryBuilder-> leftJoin('worksite.category', 'category') // jointure entre chantiers & catégories
                            -> andWhere('category.id = :id') // condition sur l'id de la catégorie
                            -> setParameter('id', $id) // param contre les injections SQL
                            -> getQuery() // écrire la requête
                            -> getResult(); // récup résultat requête
    }

    public function findByCriteria(SearchWorksiteCriteria $criteria): array
    {
        // Création du query builder
        $qb= $this->createQueryBuilder('worksite');

        // Filtrer les résultats selon le titre si c'est spécifié
        if ($criteria->title) {
            $qb->andWhere('worksite.title LIKE :title')
                ->setParameter('title', "%$criteria->title%");
        }

        // Filtrer les résultats par catégories
        if (!empty($criteria->categories)) {
            $qb->leftJoin('worksite.category', 'category')// le join est fait entre worksite & category
               ->andWhere('category.id IN (:catIds)')
               ->setParameter('catIds', $criteria->categories);
        }

        $qb->orderBy("worksite.$criteria->orderBy", $criteria->direction)
            ->setMaxResults($criteria->limit)
            ->setFirstResult(($criteria->page - 1) * $criteria->limit);


        return $qb ->getQuery() // écrire la requete
                   ->getResult(); // récup les resultats de la requete
    }

//    /**
//     * @return Worksite[] Returns an array of Worksite objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('w.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Worksite
//    {
//        return $this->createQueryBuilder('w')
//            ->andWhere('w.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
