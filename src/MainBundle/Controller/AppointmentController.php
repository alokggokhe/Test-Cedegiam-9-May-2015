<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use MainBundle\Entity\Schedule;
use MainBundle\Entity\ScheduleStatus;

class AppointmentController extends Controller
{

	public function indexAction()
	{
		return $this->render('MainBundle:Appointment:index.html.twig');
	}
	
	public function statusChangeAction($action,$id)
	{
		if($id == '' && $action == '') {
			return $this->redirect($this->generateUrl('homepage'));
		}
		
		$doctrine  = $this->getDoctrine()->getManager();
		$schedule  = $doctrine->getRepository('MainBundle:Schedule')->find($id);

		if($schedule->getScheduleStatus()->getId() == 1 
			|| $schedule->getScheduleStatus()->getId() == 2) {

				if($action == 'decline'){
					// change status to 'Cancelled'
					$schedulestatus = $doctrine->getRepository('MainBundle:ScheduleStatus')->find(3);
					$schedule->setScheduleStatus($schedulestatus);
					$doctrine->persist($schedule);
					$doctrine->flush();
				}

				return $this->redirect($this->generateUrl('appointment'));		
		} else {
			return $this->redirect($this->generateUrl('homepage'));
		}
	}
}
