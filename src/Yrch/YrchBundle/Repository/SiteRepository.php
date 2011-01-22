<?php

namespace Yrch\YrchBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Yrch\YrchBundle\Entity\Site;
use Yrch\YrchBundle\Entity\Category;
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
            FROM YrchBundle:Site s
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
            FROM YrchBundle:Site s
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
            FROM YrchBundle:Review r
            WHERE r.site=?1
            AND EXISTS (
                SELECT COUNT(e.id)
                FROM YrchBundle:Review e
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
     * Update the average score for all sites.
     *
     * This is only a maintenance function as average scores are updated
     * automatically by the ScoreListener using the getUpdatedAverageScore()
     * method.
     *
     * Attention: This function must not be used too often as it uses more
     * resources.
     */
    public function updateAllAverageNotes()
    {
        $sql = "UPDATE site s
            SET s.average_score = (
                SELECT AVG(r.score)
                FROM review r
                WHERE r.site_id=s.id
                AND EXISTS (
                    SELECT COUNT(e.id)
                    FROM review e
                    WHERE e.site_id=s.id
                    AND e.owner_id=r.owner_id
                    AND e.status='ok'
                    HAVING MAX(e.updated_at)=r.updated_at
                )
            )";
        $this->_em->getConnection()->executeUpdate($sql);
    }
}
