<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Categoria;
use AppBundle\Form\CategoriaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/categoria")
 * @Security("has_role('ROLE_ADMIN')")
*/

class CategoriaController extends Controller
{
    /**
     * @Route("/", name="admin_cat_index")
     * @Route("/", name="admin_categ_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categ = $entityManager->getRepository(Categoria::class)->findAll();;

        return $this->render('admin/categoria/index.html.twig', ['categ' => $categ]);
    }

    /**
     * @Route("/new", name="admin_cat_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request)
    {
      $cat = new Categoria();
      
      $form = $this->createForm(CategoriaType::class, $cat)->add('saveAndCreateNew', SubmitType::class);
      $form->handleRequest($request);
      
      if($form->isSubmitted() && $form->isValid()){
        //$cat->setCategoria($this->get('slugger);
         $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($cat);
        $entityManager->flush();
        
        $this->addFlash('succes','categoria.created_successfully');
        
        if($form->get('saveAndCreateNew')->isClicked()){
          return $this->redirectToRoute('admin_cat_new');
        }
        
        return $this->redirectToRoute('admin_categ_index');
      }
      
      return $this->render('admin/categoria/new.html.twig',[
          'cat' => $cat,
          'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_cat_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Categoria $cat, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $form = $this->createForm(CategoriaType::class, $cat);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'cat.updated_successfully');

            return $this->redirectToRoute('admin_cat_edit', ['id' => $cat->getId()]);
        }

        return $this->render('admin/categoria/edit.html.twig', [
            'cat' => $cat,
            'form' => $form->createView(),
        ]);
    }

}
