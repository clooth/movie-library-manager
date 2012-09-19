<?php

namespace Acme\MovieBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

/**
 * GenreRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class GenreRepository extends EntityRepository
{
	public function getPopular($limit = 16)
	{
		return $this->getEntityManager()
			->createQuery('SELECT g, COUNT(m.id) AS movie_count FROM AcmeMovieBundle:Genre g JOIN g.movies m GROUP BY g.id ORDER BY movie_count DESC')
			->setMaxResults($limit)
			->getResult(Query::HYDRATE_ARRAY);
	}
}
