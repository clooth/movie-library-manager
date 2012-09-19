<?php

namespace Acme\MovieBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

use Acme\MovieBundle\Form\DataTransformer\EntitiesToIdsTransformer;
use Acme\MovieBundle\Form\DataTransformer\EntitiesToTokenInputTransformer;

class MovieType extends AbstractType
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('released', 'date', array(
                'years' => range(1900, date("Y", time())),
                'empty_value' => array('year' => 'Year', 'month' => 'Month', 'day' => 'Day')
            ));

        $genreRepository = $this->em->getRepository('AcmeMovieBundle:Genre');
        $genreTransformer = new EntitiesToTokenInputTransformer($genreRepository, $this->em);

        $builder->add(
            $builder->create('genres', 'text', array(
                'required' => false
            ))->addModelTransformer($genreTransformer)
        );

        $directorRepository = $this->em->getRepository('AcmeMovieBundle:Director');
        $directorTransformer = new EntitiesToTokenInputTransformer($directorRepository, $this->em);

        $builder->add(
            $builder->create('directors', 'text', array(
                'required' => false
            ))->addModelTransformer($directorTransformer)
        );

        $tagRepository = $this->em->getRepository('AcmeMovieBundle:Tag');
        $tagTransformer = new EntitiesToTokenInputTransformer($tagRepository, $this->em);

        $builder->add(
            $builder->create('tags', 'text', array(
                'required' => false
            ))->addModelTransformer($tagTransformer)
        );

        $linkRepository = $this->em->getRepository('AcmeMovieBundle:Link');
        $builder->add('links', 'collection', array(
            'type' => new LinkType(),
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'prototype' => true
        ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\MovieBundle\Entity\Movie'
        ));
    }

    public function getName()
    {
        return 'movie';
    }
}
