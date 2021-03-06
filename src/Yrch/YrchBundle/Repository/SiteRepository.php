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
     * @param \Yrch\YrchBundle\Entity\Category $category
     * @return array
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
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameters(array ('status' => 'ok', 'category' => $category));

        return $query->getResult();
    }

    /**
     * Find all selectioned sites
     *
     * @return array
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
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameters(array ('status' => 'ok', 'selection' => true));

        return $query->getResult();
    }

    /**
     * Get the updated average score of the given site
     *
     * @param \Yrch\YrchBundle\Entity\Site $site
     * @return float
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
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameters(array (1 => $site, 2 => $site));
        $averageScore = $query->getResult(Query::HYDRATE_SINGLE_SCALAR);

        return $averageScore;
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
        $this->getEntityManager()->getConnection()->executeUpdate($sql);
    }
}
