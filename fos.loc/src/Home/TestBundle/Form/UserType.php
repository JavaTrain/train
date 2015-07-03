<?php

namespace Home\TestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('status', 'choice', array(
                'choices' => array('student' => 'Student', 'couch' => 'Couch'),
                'multiple' => false,
                'expanded' => true,
                'required' => true,
            ))
            ->add('email')
            ->add('courses', 'entity' ,array(
                'class' => 'HomeTestBundle:Course',
                'property' => 'name',
                'multiple' => true,
                'expanded' => true
            ))
            ->add('Clusters', 'entity' ,array(
                'class' => 'HomeTestBundle:Cluster',
                'property' => 'room',
                'multiple' => true,
                'expanded' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Home\TestBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'home_testbundle_user';
    }
}
