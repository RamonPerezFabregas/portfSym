<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Categoria;
use AppBundle\Form\DataTransformer\CategoriaArrayToStringTransformer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class CategoriaInputType extends AbstractType
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new CategoriaArrayToStringTransformer($this->manager), true)
        ;
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['cats'] = $this->manager->getRepository(Categoria::class)->findAll();
    }

    public function getParent()
    {
        return TextType::class;
    }
}