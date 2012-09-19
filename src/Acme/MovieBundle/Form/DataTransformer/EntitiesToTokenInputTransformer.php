<?php

namespace Acme\MovieBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Common\Collections\ArrayCollection;

use Acme\MovieBundle\Entity\Director;
use Acme\MovieBundle\Entity\Genre;
use Acme\MovieBundle\Entity\Movie;
use Acme\MovieBundle\Entity\Tag;

class EntitiesToTokenInputTransformer implements DataTransformerInterface
{
	/**
	 * @var ObjectManager
	 */
	private $repository;

	/**
	 * @var ObjectManager
	 */
	private $em;


	/**
	 * @param ObjectManager $om
	 */
	public function __construct($repository, $em)
	{
		$this->repository = $repository;
		$this->em = $em;
	}

	/**
	 * Transforms objects to ids
	 *
	 * @param $entities
	 * @return string
	 */
	public function transform($entities)
	{
		if (null === $entities) {
			return "";
		}

		$tokensArray = array();
		foreach ($entities as $entity) {
			$tokensArray[] = array(
				'id' => $entity->getId(),
				'name' => $entity->getName()
			);
		}
		$tokens = json_encode($tokensArray);

		return $tokens;
	}

	/**
	 * Transforms entity id's back to objects
	 *
	 * @param $ids List of entity ids
	 */
	public function reverseTransform($ids)
	{
		$entities = new ArrayCollection();

		if ('' === $ids || null === $ids)
		{
			return $ids;
		}

		if (!is_string($ids)) {
			throw new UnexpectedTypeException($ids, 'string');
		}

		$idsArray = explode(",", $ids);
		$idsArray = array_filter($idsArray, 'is_numeric');
		foreach ($idsArray as $id) {
			$entity = $this->repository
				->findOneBy(array('id' => $id));
			$entities->add($entity);
		}

		return $entities;
	}
}