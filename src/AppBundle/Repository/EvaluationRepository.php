<?php

namespace AppBundle\Repository;

/**
 * EvaluationRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EvaluationRepository extends \Doctrine\ORM\EntityRepository
{

  public function findProductEval(): array{
    $qb = $this->createQueryBuilder('e')
    ->join('e.produit', 'p')
    ->select( 'p.codeBarre, avg(e.note) AS note' )
    ->groupBy('e.produit')
    // ->groupBy('p.codeBarre')
    ->orderBy('note', 'desc')
    ->setMaxResults(8)
    ->getQuery();

    return $qb->execute();

  }

  public function getNote($produit_get){
    $qb = $this->createQueryBuilder('e')
    ->select( 'avg(e.note) as note' )
    ->where('e.produit = ?1')
    ->setParameter(1,$produit_get)
    ->groupBy('e.produit');

    $name = [];

    $note = $qb->getQuery()->getResult();
    return $note;
  }


    public function findEvaluation($produit, $user){
      // return $this->getEntityManager()
      // ->createQuery(
      //     'SELECT evaluation, p
      //     FROM AppBundle:Evaluation evaluation
      //     JOIN evaluation.produit p
      //     WHERE evaluation.produit = :produit AND evaluation.user = :user'
      //   )
      //   ->setParameter('produit', $produit)
      //   ->setParameter('user', $user)
      //   ->getResult();

      $qb = $this->createQueryBuilder('e')
      ->join('e.produit','p')
      ->where('e.produit = :produit AND e.user = :user')
      ->setParameter('produit', $produit)
      ->setParameter('user', $user)
      ->groupBy('e.produit');

      $eval = $qb->getQuery()->getResult();

      return $eval;
    }
}
