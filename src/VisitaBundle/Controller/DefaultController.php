<?php

namespace VisitaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/nueva/{num}", name="nueva_visita", requirements={"slpcode":"\d+"})
     * @Method({"GET"})
     */
    public function indexAction($num=1)
    {
      //http://127.0.0.1:8000/visita/nueva/3
        return $this->render('VisitaBundle:Default:index.html.twig',
                              array(
                                'slpcode' => $num
                              ));
    }

    /**
     * @Route("/", name="todas_visitas")
     * @Method({"GET"})
     */
    public function listVisitas(Request $request)
    {
      //http://127.0.0.1:8000/visita/?nro=40
        return new Response(
          '<html><body>'.'Nro vendedor para traer visitas'.$request->get('nro').'</body></html>'
        );
    }

    /**
     * @Route("/crear", name="crear_visita")
     * @Method({"POST"})
     */
    public function crearVisita(Request $request)
    {
      //http://127.0.0.1:8000/visita/crear    EN postman con parametros en form-data
        return new Response(
          json_encode($request->request->all())
        );
    }
}
