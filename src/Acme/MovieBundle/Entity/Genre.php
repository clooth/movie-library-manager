<?php

namespace Acme\MovieBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Acme\MovieBundle\Entity\Genre
 *
 * @ORM\Table(name="genres")
 * @ORM\Entity(repositoryClass="Acme\MovieBundle\Entity\GenreRepository")
 */
class Genre
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
     * @ORM\ManyToMany(targetEntity="Movie", mappedBy="genres", cascade={"persist"})
     */
    private $movies;

    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

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
     * @return Genre
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
        if (!$this->movies->contains($movie)) {
            $this->movies->add($movie);
        }
    }
}
