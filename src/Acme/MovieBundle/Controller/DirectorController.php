<?php

namespace Acme\MovieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\MovieBundle\Entity\Director;
use Acme\MovieBundle\Form\DirectorType;

/**
 * Director controller.
 *
 * @Route("/directors")
 */
class DirectorController extends Controller
{
    /**
     * Lists all Director entities.
     *
     * @Route("/", name="directors", options={"expose"=true})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('AcmeMovieBundle:Director')->findAll();

        $entity = new Director();
        $form   = $this->createForm(new DirectorType(), $entity);

        $director_id = $this->getRequest()->get('id');

        return array(
            'entities' => $entities,
            'entity' => $entity,
            'director_id' => $director_id,
            'form'   => $form->createView(),
        );
    }



    /**
     * Finds and displays a Director entity.
     *
     * @Route("/{id}/show", name="director_show", options={"expose"=true})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Director')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Director entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Director entity.
     *
     * @Route("/new", name="director_new", options={"expose"=true})
     * @Template()
     */
    public function newAction()
    {
        $entity = new Director();
        $form   = $this->createForm(new DirectorType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Director entity.
     *
     * @Route("/create", name="director_create", options={"expose"=true})
     * @Method("POST")
     * @Template("AcmeMovieBundle:Director:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Director();
        if ($request->isXmlHttpRequest()) {
            $form = $this->createForm(new DirectorType(), $entity,
                array('csrf_protection' => false));
        } else {
            $form = $this->createForm(new DirectorType(), $entity);
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

            return $this->redirect($this->generateUrl('directors', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Director entity.
     *
     * @Route("/{id}/edit", name="director_edit", options={"expose"=true})
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Director')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Director entity.');
        }

        $editForm = $this->createForm(new DirectorType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Director entity.
     *
     * @Route("/{id}/update", name="director_update", options={"expose"=true})
     * @Method("POST")
     * @Template("AcmeMovieBundle:Director:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Director')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Director entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new DirectorType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('director_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Director entity.
     *
     * @Route("/{id}/delete", name="director_delete", options={"expose"=true})
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeMovieBundle:Director')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Director entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('director'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
