<?php

namespace Acme\MovieBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Acme\MovieBundle\Entity\Tag;
use Acme\MovieBundle\Form\TagType;

/**
 * Tag controller.
 *
 * @Route("/tags")
 */
class TagController extends Controller
{
    /**
     * Lists all Tag entities.
     *
     * @Route("/", name="tags", options={"expose"=true})
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AcmeMovieBundle:Tag')->findAll();

        $entity = new Tag();
        $form   = $this->createForm(new TagType(), $entity);

        return array(
            'entities' => $entities,
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Tag entity.
     *
     * @Route("/{id}/show", name="tag_show", options={"expose"=true})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Tag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Tag entity.
     *
     * @Route("/new", name="tag_new", options={"expose"=true})
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tag();
        $form   = $this->createForm(new TagType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Tag entity.
     *
     * @Route("/create", name="tag_create", options={"expose"=true})
     * @Method("POST")
     * @Template("AcmeMovieBundle:Tag:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Tag();
        if ($request->isXmlHttpRequest()) {
            $form = $this->createForm(new TagType(), $entity,
                array('csrf_protection' => false));
        } else {
            $form = $this->createForm(new TagType(), $entity);
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

            return $this->redirect($this->generateUrl('tag_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tag entity.
     *
     * @Route("/{id}/edit", name="tag_edit", options={"expose"=true})
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Tag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
        }

        $editForm = $this->createForm(new TagType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tag entity.
     *
     * @Route("/{id}/update", name="tag_update", options={"expose"=true})
     * @Method("POST")
     * @Template("AcmeMovieBundle:Tag:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AcmeMovieBundle:Tag')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tag entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new TagType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tag_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tag entity.
     *
     * @Route("/{id}/delete", name="tag_delete", options={"expose"=true})
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AcmeMovieBundle:Tag')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tag entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tag'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
