<?php

namespace Acme\MovieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Tag controller.
 *
 * @Route("/")
 */
class MainController extends Controller
{
    /**
     * Library dashboard
     *
     * @Route("/", name="dashboard", options={"expose"=true})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $latestMovies  = $em->getRepository('AcmeMovieBundle:Movie')->getLatest(10);
        $popularGenres = $em->getRepository('AcmeMovieBundle:Genre')->getPopular(10);
        $popularDirectors = $em->getRepository('AcmeMovieBundle:Director')->getPopular(10);

        return array(
            'latestMovies' => $latestMovies,
            'popularGenres' => $popularGenres,
            'popularDirectors' => $popularDirectors
        );
    }
}
