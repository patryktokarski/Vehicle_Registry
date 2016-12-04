<?php

namespace VehicleBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use VehicleBundle\Validator\Constraints\StartGreaterThanDefault;

class RefuelType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date')
                ->add('liters', 'integer', ['required' => false])
                ->add('kilometerStart', 'integer', array(
                      'required' => false))
                ->add('kilometerEnd', 'integer', ['required' => false]) ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VehicleBundle\Entity\Refuel'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'vehiclebundle_refuel';
    }


}
