<?php

namespace Acme\MovieBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\MovieBundle\Entity\Movie
 *
 * @ORM\Table(name="movies")
 * @ORM\Entity(repositoryClass="Acme\MovieBundle\Entity\MovieRepository")
 */
class Movie
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
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var \DateTime $released
     *
     * @ORM\Column(name="released", type="date")
     * @Assert\NotBlank()
     * @Assert\Type("\DateTime")
     */
    private $released;

    /**
     * @ORM\ManyToMany(targetEntity="Genre", inversedBy="movies", cascade={"persist"})
     * @ORM\JoinTable(name="movie_genres",
     * joinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="genre_id", referencedColumnName="id")}
     * )
     */
    private $genres;


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
     * @return Movie
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
     * Set released
     *
     * @param \DateTime $released
     * @return Movie
     */
    public function setReleased($released)
    {
        $this->released = $released;

        return $this;
    }

    /**
     * Get released
     *
     * @return \DateTime
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * Add genres
     *
     * @param Acme\MovieBundle\Entity\Genre $genre
     */
    public function addGenre(\Acme\MovieBundle\Entity\Genre $genre)
    {
        $this->genres[] = $genre;
    }

    /**
     * Get genres
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getGenres()
    {
        return $this->genres;
    }
}
