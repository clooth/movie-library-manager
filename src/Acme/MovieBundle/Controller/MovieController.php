<?php

namespace Acme\MovieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\MovieBundle\Entity\Movie;
use Acme\MovieBundle\Form\MovieType;

/**
 * Movie controller
 *
 *
 * @Route("/movies")
 */
class MovieController extends Controller
{
    /**
     * Lists all Movie entities.
     *
     * @Route("/", name="movies", options={"expose"=true})
     * @Template()
     */
    public function indexAction()
    {
        // Check the _GET for any filter parameters
        // and build an array from them.
        $query   = $this->getRequest()->query;
        $filters = array(
            'genre' => $query->get('genre') ?: null,
            'tags'  => $query->get('tags') ?: null,
            'director' => $query->get('director') ?: null
        );

        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeMovieBundle:Movie')->findAll();

        $entity = new Movie();
        $form   = $this->createForm(new MovieType($this->getDoctrine()->getEntityManager()), $entity);

        return array(
            'entities' => $entities,
            'entity' => $entity,
            'form' => $form->createView()
        );
    }

    /**
     * Finds and displays a Movie entity.
     *
     * @Route("/{id}/show", name="movie_show", options={"expose"=true})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AcmeMovieBundle:Movie');
        $entity = $repo->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movie entity.');
        }

        // Find similar movies
        $similarMovies = $repo->getSimilarMovies($entity);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'         => $entity,
            'similar_movies' => $similarMovies,
            'delete_form'    => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Movie entity.
     *
     * @Route("/new", name="movie_new", options={"expose"=true})
     * @Template()
     */
    public function newAction()
    {
        $entity = new Movie();
        $form   = $this->createForm(new MovieType($this->getDoctrine()->getEntityManager()), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Movie entity.
     *
     * @Route("/create", name="movie_create", options={"expose"=true})
     * @Method("POST")
     * @Template("AcmeMovieBundle:Movie:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Movie();
        $form = $this->createForm(new MovieType($this->getDoctrine()->getEntityManager()), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('movie_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Movie entity.
     *
     * @Route("/{id}/edit", name="movie_edit", options={"expose"=true})
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Movie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movie entity.');
        }

        $editForm = $this->createForm(new MovieType($this->getDoctrine()->getEntityManager()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Movie entity.
     *
     * @Route("/{id}/update", name="movie_update", options={"expose"=true})
     * @Method("POST")
     * @Template("AcmeMovieBundle:Movie:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Movie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MovieType($this->getDoctrine()->getEntityManager()), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('movie_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Movie entity.
     *
     * @Route("/{id}/delete", name="movie_delete", options={"expose"=true})
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeMovieBundle:Movie')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Movie entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('movie'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
