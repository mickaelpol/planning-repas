<?php

namespace AppBundle\Repository;

/**
 * MoisRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MoisRepository extends \Doctrine\ORM\EntityRepository
{

    public function getActualMonth()
    {
        $actualMonth = date('m') - 1;
        $actualYear = date('Y');
        $qb = $this->createQueryBuilder('m')
            ->where('m.monthNumber = :month')
            ->andWhere('m.year = :year')
            ->setParameter('month', $actualMonth)
            ->setParameter('year', $actualYear)
            ->getQuery();

        return $qb->getResult();
    }
    public function getIngredientsMonth($paramMonth)
    {
        // je veut Selectionnez tous les ingrédients
        // des recettes
        // Ou la recette appartient au même planning
        // et ou le planning appartient au mois en cours
        $actualMonth = date('m') - 1;
        $actualYear = date('Y');
        $qb = $this->createQueryBuilder('m')
            ->where('m.monthNumber = :month')
            ->andWhere('m.plannings = :paramMonth')
            ->andWhere('m.year = :year')
            ->setParameter('month', $actualMonth)
            ->setParameter('paramMonth', $paramMonth)
            ->setParameter('year', $actualYear)
            ->getQuery();

        return $qb->getResult();
    }

    // Je doit récuperer les ingredients
    // Des recettes
    // qui se trouve

}
