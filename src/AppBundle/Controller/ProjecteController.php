<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Projecte;
use AppBundle\Events;
use AppBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller used to manage projecte contents in the public part of the site.
 * 
 * @Route("/projecte")
 */
class ProjecteController extends Controller
{
    /**
     * @Route("/", defaults={"page": "1", "_format"="html"}, name="projecte_index")
     * @Route("/rss.xml", defaults={"page": "1", "_format"="xml"}, name="projecte_rss")
     * @Route("/page/{page}", defaults={"_format"="html"}, requirements={"page": "[1-9]\d*"}, name="projecte_index_paginated")
     * @Method("GET")
     * @Cache(smaxage="10")
     *
     * NOTE: For standard formats, Symfony will also automatically choose the best
     * Content-Type header for the response.
     * See https://symfony.com/doc/current/quick_tour/the_controller.html#using-formats
     */
    public function indexAction($page, $_format)
    {
        $projs = $this->getDoctrine()->getRepository(Projecte::class)->findLatest($page); //  ->findAll();

        // Every template name also has two extensions that specify the format and
        // engine for that template.
        // See https://symfony.com/doc/current/templating.html#template-suffix
        return $this->render('projecte/index.'.$_format.'.twig', ['projs' => $projs]);
    }

    /**
     * @Route("/projecte/{id}", name="projecte_detall")
     * @Method("GET")
     *
     * NOTE: The $post controller argument is automatically injected by Symfony
     * after performing a database query looking for a Post with the 'slug'
     * value given in the route.
     * See https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/annotations/converters.html
     */
    public function projecteShowAction(Projecte $proj)
    {
        // Symfony provides a function called 'dump()' which is an improved version
        // of the 'var_dump()' function. It's useful to quickly debug the contents
        // of any variable, but it's not available in the 'prod' environment to
        // prevent any leak of sensitive information.
        // This function can be used both in PHP files and Twig templates. The only
        // requirement is to have enabled the DebugBundle.
        if ('dev' === $this->getParameter('kernel.environment')) {
            dump($proj, $this->get('security.token_storage')->getToken()->getUser(), new \DateTime());
        }
        return $this->render('projecte/proj_show.html.twig', ['proj' => $proj]);
    }
    
     /**
     * @Route("/categoria/{categoria}", requirements={"categoria": "[1-9]\d*"},  name="proj_filtrat")
     * @Method("GET")
     */    
    public function projFilter($categoria)
    {
      $projs = $this->getDoctrine()->getRepository(Projecte::class)->findBy(array('tipus'=>$categoria)); //

      return $this->render('projecte/index_filt.html.twig', ['projs' => $projs]);
    }
    
    /**
     * @Route("/anny/{anny}", requirements={"anny": "[1-9]\d*"},  name="proj_filtrat_any")
     * @Method("GET")
     */    
    public function projFilterAny($anny)
    {
      $projs = $this->getDoctrine()->getRepository(Projecte::class)->findBy(array('anny'=>$anny)); //

      return $this->render('projecte/index_filt.html.twig', ['projs' => $projs]);
    }
    
}
