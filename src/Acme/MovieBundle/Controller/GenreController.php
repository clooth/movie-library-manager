<?php

namespace Acme\MovieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\MovieBundle\Entity\Genre;
use Acme\MovieBundle\Form\GenreType;

/**
 * Genre controller.
 *
 * @Route("/genres")
 */
class GenreController extends Controller
{
    /**
     * Lists all Genre entities.
     *
     * @Route("/", name="genres", options={"expose"=true})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeMovieBundle:Genre')->findAll();

        $entity = new Genre();
        $form   = $this->createForm(new GenreType(), $entity);

        $genre_id = $this->getRequest()->get('id');

        return array(
            'entities' => $entities,
            'entity' => $entity,
            'genre_id' => $genre_id,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Genre entity.
     *
     * @Route("/{id}/show", name="genre_show", options={"expose"=true})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Genre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Genre entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Genre entity.
     *
     * @Route("/new", name="genre_new", options={"expose"=true})
     * @Template()
     */
    public function newAction()
    {
        $entity = new Genre();
        $form   = $this->createForm(new GenreType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Genre entity.
     *
     * @Route("/create", name="genre_create", options={"expose"=true})
     * @Method("POST")
     * @Template("AcmeMovieBundle:Genre:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Genre();
        if ($request->isXmlHttpRequest()) {
            $form = $this->createForm(new GenreType(), $entity,
                array('csrf_protection' => false));
        } else {
            $form = $this->createForm(new GenreType(), $entity);
        }

        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            if ($request->isXmlHttpRequest()) {
                $response = new Response();
                $response->setContent(json_encode(array(
                    'id' => $entity->getId(),
                    'name' => $entity->getName()
                )));
                return $response;
            }

            return $this->redirect($this->generateUrl('genres', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Genre entity.
     *
     * @Route("/{id}/edit", name="genre_edit", options={"expose"=true})
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Genre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Genre entity.');
        }

        $editForm = $this->createForm(new GenreType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Genre entity.
     *
     * @Route("/{id}/update", name="genre_update", options={"expose"=true})
     * @Method("POST")
     * @Template("AcmeMovieBundle:Genre:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Genre')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Genre entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new GenreType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('genre_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Genre entity.
     *
     * @Route("/{id}/delete", name="genre_delete", options={"expose"=true})
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeMovieBundle:Genre')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Genre entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('genre'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
