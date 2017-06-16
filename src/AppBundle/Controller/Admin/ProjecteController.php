<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Projecte;
use AppBundle\Form\ProjecteType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/projecte")
 * @Security("has_role('ROLE_ADMIN')")
*/

class ProjecteController extends Controller
{
    /**
     * @Route("/", name="admin_p_index")
     * @Route("/", name="admin_proj_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $proj = $entityManager->getRepository(Projecte::class)->findAll();

        return $this->render('admin/projecte/index.html.twig', ['projs' => $proj]);
    }

    /**
      * @Route("/new", name="admin_proj_new")
      * @Method({"GET","POST"})
    */
    public function newAction(Request $request)
    {
      $proj = new Projecte();
      
      $form = $this->createForm(ProjecteType::class, $proj)->add('saveAndCreateNew', SubmitType::class);
      $form->handleRequest($request);
      
      if($form->isSubmitted() && $form->isValid()){
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($proj);
        $entityManager->flush();
        
        $this->addFlash('success','proj.created_successfully');
        
        if($form->get('saveAndCreateNew')->isClicked()){
          return $this->redirectToRoute('admin_proj_new');
        }
        return $this->redirectToRoute('admin_proj_index');
      }
      return $this->render('admin/projecte/new.html.twig', [
        'proj' => $proj,
        'form' => $form->createView(),
      ]);
    }
    
    /**
     * @Route("/{id}",requirements={"id": "\d+"}, name="admin_proj_show")
     * @Method({"GET","POST"})
     */
    public function showAction(Projecte $prj)
    {
      return $this->render('admin/projecte/show.html.twig', [
         'prj' => $prj,
        ]);
    }
    
    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_proj_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Projecte $prj, Request $request)
    {
      $entityManager = $this->getDoctrine()->getManager();
      $form = $this->createForm(ProjecteType::class, $prj);
      
      $form->handleRequest($request);
      
      if($form->isSubmitted() && $form->isValid()){
        $entityManager->flush();
        $this->addFlash('success','prj.updated_successfully');
        
        return $this->redirectToRoute('admin_proj_edit', ['id' => $prj->getId()]);
      }
      return $this->render('admin/projecte/edit.html.twig', [
        'prj' => $prj,
        'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/{id}/delete", name="admin_proj_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request, Projecte $prj)
    {
      
    }
}
