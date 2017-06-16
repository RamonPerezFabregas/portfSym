<?php

namespace AppBundle\Form\DataTransformer;

use AppBundle\Entity\Categoria;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;

class CategoriacatArrayToStringTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function transform($array)
    {
        return implode(',', $array);
    }

    public function reverseTransform($string)
    {
        if ('' === $string || null === $string) {
            return [];
        }

        $names = array_filter(array_unique(array_map('trim', explode(',', $string))));

        $cats = $this->manager->getRepository(Categeria::class)->findBy([
            'name' => $names,
        ]);
        $newNames = array_diff($names, $cats);
        foreach ($newNames as $name) {
            $cat = new Categeria();
            $cat->setName($name);
            $cats[] = $cat;
        }
        return $cats;
    }
}
