<?php

namespace Acme\MovieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Acme\MovieBundle\Entity\Movie;
use Acme\MovieBundle\Form\MovieType;

class MovieController extends Controller
{
    // Movies index
    public function indexAction($filters=array())
    {
        // Doctrine
        $doctrine = $this->getDoctrine();

        // Adding new movies
        $newMovie = new Movie();
        $form = $this->createForm(new MovieType(), $newMovie);

        // Recent movies
        $movieRepository = $doctrine->getRepository('AcmeMovieBundle:Movie');

        // Top directors
        $directorRepository = $doctrine->getRepository('AcmeMovieBundle:Director');

        // Top genres
        $directorRepository = $doctrine->getRepository('AcmeMovieBundle:Genre');

        return $this->render(
            'AcmeMovieBundle:Movie:index.html.twig',
            array(
                'movies' => array()
            )
        );
    }

    // Movie creation
    public function newAction(Request $request)
    {
    	$movie = new Movie();
        $form = $this->createForm(new MovieType(), $movie);

        if ($request->getMethod() == 'POST') {
            $form->bind($request);

            if ($form->isValid()) {
                $movie->save();
            }
        }

        return $this->render(
            'AcmeMovieBundle:Movie:new.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    // Movie details
    public function detailAction()
    {

    }
}
