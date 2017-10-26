<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ImgPagare;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PagareController extends Controller
{

  /**
  *@Route("/pagare/nuevo", name="guardar_pagare")
  */
  public function insertImgPagare(Request $request ){
    $pagare= new ImgPagare();
    //$pagare->setImagen('C:/img/imagen_prueba');

    //$em = $this->getDoctrine()->getManager();
    //$em->persist($pagare);
    //$em->flush();
    //$id_n= $pagare->getId();

    $form = $this->createFormBuilder($pagare)
            ->add('imagen', FileType::class, array('label' => 'Brochure (PDF file)'))
            ->add('save', SubmitType::class, array('label' => 'Guardar Pagare'))
            ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
               // $form->getData() holds the submitted values
               // but, the original `$task` variable has also been updated
               $img=$form["imagen"]->getData();
               $ext=$img->guessExtension();
               $img_name= time().".".$ext;

               //$img->move("uploads",$img_name);
               $img->move($this->getParameter('uploads'),
                            $img_name
                          );
               $pagare->setImagen($img_name);


               $em = $this->getDoctrine()->getManager();
               $em->persist($pagare);
               $em->flush();
               // ... perform some action, such as saving the task to the database
               // for example, if Task is a Doctrine entity, save it!
               // $em = $this->getDoctrine()->getManager();
               // $em->persist($task);
               // $em->flush();

               //return $this->redirectToRoute('homepage');
               return new Response('imagenes'.$pagare->getId());
           }

    return $this->render('AppBundle:Pagare:nuevo.html.twig', array(
            'form' => $form->createView(),
        ));

  }

  /**
  *@Route("/get/p_img", name="get_img_pagare")
  */
  public function getImgPagare(){
    $em= $this->getDoctrine()->getManager();
    $repository = $em->getRepository('AppBundle:ImgPagare');

    $imgs = $repository->findAll();
    dump($imgs); //imprimir los valores
    return new Response('imagenes');


  }

  /**
   * @Route("/pagare/save", name="gua_pagare")
   */
  public function guardarPagare(Request $form){

      $img_pagare= new ImgPagare();

      $img=$form->request->get('image'); $form["image"]->getData();
      $ext=$img->guessExtension();
      $img_name= time()."".$ext;

      $img->move("uploads",$img_name);
      $img_pagare->setImagen($img_name);


      $em = $this->getDoctrine()->getManager();
      $em->persist($img_pagare);
      $em->flush();

      return new Response('hola q ase');
  }
}
