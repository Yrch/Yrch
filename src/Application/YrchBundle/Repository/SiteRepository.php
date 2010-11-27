<?php

namespace Application\YrchBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Application\YrchBundle\Entity\Site;
use Application\YrchBundle\Entity\Category;
use Doctrine\ORM\Query;

/**
 * SiteRepository
 */
class SiteRepository extends EntityRepository
{
    public function findByCategory(Category $category)
    {
        $dql = "SELECT s
            FROM Application\YrchBundle\Entity\Site s
            WHERE s.status = :status
            AND :category MEMBER OF s.categories
            ORDER BY s.selection DESC, s.leech ASC, s.averageScore DESC, s.name ASC
            ";
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array ('status'=>'ok', 'category'=>$category));
        return $query->getResult();
    }

    /**
     * Update the average score of the given site
     *
     * @param Site $site
     */
    public function updateAverageNote(Site $site)
    {
        $dql = "SELECT AVG(r.score)
            FROM Application\YrchBundle\Entity\Review r
            WHERE r.site=?1
            AND EXISTS (
                SELECT COUNT(e.id)
                FROM Application\YrchBundle\Entity\Review e
                WHERE e.site=?2
                AND e.owner=r.owner
                AND e.status='ok'
                HAVING MAX(e.updatedAt)=r.updatedAt
            )";
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array (1 => $site, 2 => $site));
        $average_score = $query->getResult(Query::HYDRATE_SINGLE_SCALAR);
        $site->setAverageScore($average_score);
        $this->_em->persist($site);
        $this->_em->flush();
    }

    /**
     * Update the average score for all sites.
     *
     * Attention: this function must not be used too often as it uses more
     * resources. Prefer using updateAverageNote when you just need to update
     * some sites.
     */
    public function updateAllAverageNotes()
    {
        $dql = "UPDATE Application\YrchBundle\Entity\Site s
            SET s.averageScore= (
                SELECT AVG(r.score)
                FROM Application\YrchBundle\Entity\Review r
                WHERE r.site=s.site
                AND EXISTS (
                    SELECT COUNT(e.id)
                    FROM Application\YrchBundle\Entity\Review e
                    WHERE e.site=s.site
                    AND e.owner=r.owner
                    AND e.status='ok'
                    HAVING MAX(e.updatedAt)=r.updatedAt
                )
            )";
        $query = $this->_em->createQuery($dql);
        $query->execute();
    }
}
