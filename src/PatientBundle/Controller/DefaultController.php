<?php

namespace PatientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{

    /**
     * @Route("/index", name="index")
     */
    public function indexAction()
    {
        return $this->render('PatientBundle:Default:index.html.twig');
    }

    /**
     * @Route("/patient/list", name="listOfProducts")
     */
    public function listAction()
    {
        if(isset($_GET['busqueda']))
        {
            $busqueda = $_GET['busqueda'];
            $repository = $this->getDoctrine()
                ->getRepository('PatientBundle:Patient');

            $query = $repository->createQueryBuilder('p')
                ->where('p.name LIKE :nombre')
                ->setParameter('nombre', '%'.$busqueda.'%')
                ->orderBy('p.name', 'ASC')
                ->getQuery();
            $patients = $query->getResult();
        }else
        {
            $patients = $this->getDoctrine()
                ->getRepository('PatientBundle:Patient')
                ->findAll();
        }
        return $this->render('PatientBundle:Default:index.html.twig' ,['patients'=> $patients]);
    }
}
