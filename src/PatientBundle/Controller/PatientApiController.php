<?php

namespace PatientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use PatientBundle\Entity\Patient;

class PatientApiController extends Controller
{
	/**
     * @Route("patient/api/patient/list", name="patient_api_patient_list")
     */
    public function listAction()
    {
    	 $patients = $this->getDoctrine()
		    	 ->getRepository('PatientBundle:Patient')
		    	 ->findAll();

        $response= new Response();
        $response->headers->add([
                                    'Content-Type'=>'application/json'
                                ]);
        $response->setContent(json_encode($patients));
        return $response;
    }


    /**
     * Creates a new patient entity.
     *
     * @Route("patient/api/patient/new", name="patient_api_patient_new")
     * @Method("POST")
     */
    public function newAction(Request $r)
    {
        $patient = new Patient();
        $form = $this->createForm(
            'PatientBundle\Form\PatientType',
            $patient,
            [
                'csrf_protection' => false
            ]
        );
        $form->bind($r);
        $valid = $form->isValid();
        $response = new Response();
        if(false === $valid){
            $response->setStatusCode(400);
            $response->setContent(json_encode($this->getFormErrors($form)));
            return $response;
        }
        if (true === $valid) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();
            $response->setContent(json_encode($patient));
        }
        return $response;
    }

    public function getFormErrors($form){
        $errors = [];
        if (0 === $form->count()){
            return $errors;
        }
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = (string) $form[$child->getName()]->getErrors();
            }
        }
        return $errors;
    }
}
