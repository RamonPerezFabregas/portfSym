<?php

namespace AppBundle\Form;

use AppBundle\Entity\Projecte;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use AppBundle\Form\Type\CategoriaInputType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjecteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('foto', null, [
                'attr' => ['autofocus' => true],
                'label' => 'label.foto',
            ])
            ->add('titol', null, [
                'label' => 'label.titol',
            ])
            ->add('descripcio', null, [
                'attr' => ['rows' => 20],
                'label' => 'label.descripcio',
            ])
            ->add('anny', IntegerType::class, 
                [ 'attr' => array('min'=>2000,'max'=>3000),
                  'label' => 'label.anny',
            ])  //
            ->add('tipus', null,// CategoriaInputType::class,
            [
                'label' => 'label.tipus',
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projecte::class,
        ]);
    }
}