<?php

namespace Acme\MovieBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Acme\MovieBundle\Entity\Genre;

class ClassAjaxController extends Controller
{
    public function genreAction(Request $request)
    {
        $value = $request->get('q');

        return $this->findObjectsByName($value, 'AcmeMovieBundle:Genre');
    }

    public function directorAction(Request $request)
    {
        $value = $request->get('q');

        return $this->findObjectsByName($value, 'AcmeMovieBundle:Director');
    }

    public function tagAction(Request $request)
    {
        $value = $request->get('q');

        return $this->findObjectsByName($value, 'AcmeMovieBundle:Tag');
    }

    public function linkAction(Request $request)
    {
        $value = $request->get('q');

        return $this->findObjectsByName($value, 'AcmeMovieBundle:link');
    }

    public function movieAction(Request $request)
    {
        // TODO
    }

    /**
     * Filter objects by name, re-used by all the actions in the ajax controller
     *
     * @param $query The query string to match with
     * @param $entityName The entities to search for
     */
    private function findObjectsByName($query, $entityName)
    {
        // Find all the genres with the name matching to the query (contains)
        $em = $this->getDoctrine()->getManager();
        $entityName = addcslashes($this->getDoctrine()->getConnection()->quote($entityName), "%_");
        $queryString = "SELECT g FROM $entityName g WHERE g.name LIKE :value";
        $q = $em->createQuery($queryString);
        $q->setParameter('value', '%'.$query.'%');

        $entities = $q->getResult();

        $json = array();
        foreach ($entities as $entity) {
            $json[] = array(
                'id' => $entity->getId(),
                'name' => $entity->getName()
            );
        }

        if (count($json) == 0)
        {
            $json[] = array(
                'id' => 0,
                'name' => 'Create: '. $query
            );
        }

        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
}