<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Projecte;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * This custom Doctrine repository contains some methods which are useful when
 * querying for blog post information.

 */
class ProjecteRepository extends EntityRepository
{
    /**
     * @param int $page
     *
     * @return Pagerfanta
     */
    public function findLatest($page = 1)
    {
        $query = $this->getEntityManager()
            ->createQuery('
                SELECT p
                FROM AppBundle:Projecte p
                ORDER BY p.id DESC
            ')
        ;
        return $this->createPaginator($query, $page);
    }

    private function createPaginator(Query $query, $page)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage(Projecte::NUM_ITEMS);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
}
