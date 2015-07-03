<?php
namespace Home\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class RegFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('name')
            ->add('status', 'choice', array(
                'choices' => array('student' => 'Student', 'couch' => 'Couch'),
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ))
            ->add('courses', 'entity' ,array(
                'class' => 'HomeTestBundle:Course',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true
            ))
            ->add('clusters', 'entity' ,array(
                'class' => 'HomeTestBundle:Cluster',
                'property' => 'room',
                'multiple' => true,
                'expanded' => true
            ))
        ;
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'home_test_registration';
    }
}