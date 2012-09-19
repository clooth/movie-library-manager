<?php

namespace Acme\MovieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Acme\MovieBundle\Entity\Link
 *
 * @ORM\Table(name="links")
 * @ORM\Entity(repositoryClass="Acme\MovieBundle\Entity\LinkRepository")
 */
class Link
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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $url
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @ORM\ManyToMany(targetEntity="Movie", mappedBy="links", cascade={"persist"})
     */
    private $movies;

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
     * Set title
     *
     * @param string $title
     * @return Link
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Link
     */
    public function setUrl($url)
    {
        $this->url = $url;
    
        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
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
