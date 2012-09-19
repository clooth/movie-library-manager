<?php

namespace Acme\MovieBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\MovieBundle\Entity\Tag
 *
 * @ORM\Table(name="tags")
 * @ORM\Entity(repositoryClass="Acme\MovieBundle\Entity\TagRepository")
 */
class Tag
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity="Movie", mappedBy="tags", cascade={"persist"})
     */
    private $movies;

    public function __toString() {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Tag
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get movies
     *
     * @return ArrayCollection
     */
    public function getMovies()
    {
       return $this->movies;
    }

    /**
     * Add movie
     */
    public function addMovie(\Acme\MovieBundle\Entity\Movie $movie)
    {
        $movie->addTag($this);
        $this->movies[] = $movie;
    }
}
