<?php

namespace App\Repository;

use App\Entity\Film;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends EntityRepository
{
    /**
     * Requete de recherche de film
     */
    public function getSearchQuery(string $term): QueryBuilder
    {
        $qb = $this->createQueryBuilder('f');

        if (!empty($term)) {
            $qb->andWhere('f.title like :term')
                ->setParameter('term', '%' . $term . '%');
        }

        return $qb;
    }
}
