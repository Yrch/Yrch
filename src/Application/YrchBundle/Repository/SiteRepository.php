<?php

namespace Application\YrchBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Application\YrchBundle\Entity\Site;
use Application\YrchBundle\Entity\Category;
use Doctrine\ORM\Query;

/**
 * SiteRepository
 *
 * @author Christophe Coevoet
 * @copyright (c) 2010, Tolkiendil, Association loi 1901
 * @license GPLv2 (http://www.opensource.org/licenses/gpl-2.0.php)
 */
class SiteRepository extends EntityRepository
{
    /**
     * Find the site in the given category with selectioned one first and leechers
     * last and ordered by average score
     *
     * @param Category $category
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function findByCategory(Category $category)
    {
        $dql = "SELECT s, c
            FROM Application\YrchBundle\Entity\Site s
            JOIN s.categories c
            WHERE s.status = :status
            AND :category MEMBER OF s.categories
            ORDER BY s.selection DESC, s.leech ASC, s.averageScore DESC, s.name ASC
            ";
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array ('status' => 'ok', 'category' => $category));
        return $query->getResult();
    }

    /**
     * Find all selectioned sites
     *
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function findSelectioned()
    {
        $dql = "SELECT s, c
            FROM Application\YrchBundle\Entity\Site s
            JOIN s.categories c
            WHERE s.status = :status
            AND s.selection = :selection
            ORDER BY s.selection DESC, s.leech ASC, s.averageScore DESC, s.name ASC
            ";
        $query = $this->_em->createQuery($dql);
        $query->setParameters(array ('status' => 'ok', 'selection' => true));
        return $query->getResult();
    }

    /**
     * Get the updated average score of the given site
     *
     * @param Site $site
     * @return double
     */
    public function getUpdatedAverageScore(Site $site)
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
        return $average_score;
    }

    /**
     * @todo This dql query does not work. Must find a new one or use SQL.
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
