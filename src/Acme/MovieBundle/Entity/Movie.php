<?php

namespace Acme\MovieBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

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
     * @ORM\ManyToMany(targetEntity="Director", inversedBy="movies", cascade={"persist"})
     * @ORM\JoinTable(name="movie_directors",
     * joinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="director_id", referencedColumnName="id")}
     * )
     */
    private $directors;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", inversedBy="movies", cascade={"persist"})
     * @ORM\JoinTable(name="movie_tags",
     * joinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     * )
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity="Link", inversedBy="movies", cascade={"persist"})
     * @ORM\JoinTable(name="movie_links",
     * joinColumns={@ORM\JoinColumn(name="movie_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="link_id", referencedColumnName="id")}
     * )
     */
    private $links;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->links = new ArrayCollection();
        $this->directors = new ArrayCollection();
        $this->tags = new ArrayCollection();
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

    public function getSlug()
    {
        return $this->slug;
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

    public function setGenres($genres)
    {
        $this->genres = $genres;
    }

    /**
     * Remove a genre
     *
     * @param Acme\MovieBundle\Entity\Genre $genre
     */
    public function removeGenre(\Acme\MovieBundle\Entity\Genre $genre)
    {
        if (!$genre) {
            throw $this->createNotFoundException('No genre found');
        }

        $this->genres->removeElement($genre);

        return $this->genres;
    }

    /**
     * Add tags
     *
     * @param Acme\MovieBundle\Entity\Tag $tag
     */
    public function addTag(\Acme\MovieBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;
    }

    /**
     * Get tags
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * Remove a tag
     *
     * @param Acme\MovieBundle\Entity\Tag $tag
     */
    public function removeTag(\Acme\MovieBundle\Entity\Genre $tag)
    {
        if (!$tag) {
            throw $this->createNotFoundException('No tag found');
        }

        $this->tags->removeElement($tag);

        return $this->tags;
    }

    /**
     * Add directors
     *
     * @param Acme\MovieBundle\Entity\Director $director
     */
    public function addDirector(\Acme\MovieBundle\Entity\Director $director)
    {
        $this->directors[] = $director;
    }

    /**
     * Get directors
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getDirectors()
    {
        return $this->directors;
    }

    public function setDirectors($directors)
    {
        $this->directors = $directors;
    }

    /**
     * Remove a director
     *
     * @param Acme\MovieBundle\Entity\Director $genre
     */
    public function removeDirector(\Acme\MovieBundle\Entity\Director $director)
    {
        if (!$director) {
            throw $this->createNotFoundException('No director found');
        }

        $this->directors->removeElement($director);

        return $this->directors;
    }

    /**
     * Add links
     *
     * @param Acme\MovieBundle\Entity\Link $link
     */
    public function addLink(\Acme\MovieBundle\Entity\Link $link)
    {
        $this->links[] = $link;
    }

    /**
     * Get links
     *
     * @return Doctrine\Common\Collections\Collection
     */
    public function getLinks()
    {
        return $this->links;
    }

    public function setLinks($links)
    {
        foreach ($links as $link) {
            $link->addMovie($this);
        }
        $this->links = $links;
    }

    /**
     * Remove a director
     *
     * @param Acme\MovieBundle\Entity\Link $genre
     */
    public function removeLink(\Acme\MovieBundle\Entity\Link $link)
    {
        if (!$link) {
            throw $this->createNotFoundException('No link found');
        }

        $this->links->removeElement($link);

        return $this->links;
    }
}
