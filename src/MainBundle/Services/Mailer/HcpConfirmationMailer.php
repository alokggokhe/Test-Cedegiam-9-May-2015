<?php

namespace MainBundle\Services\Mailer;


use Doctrine\ORM\EntityManager;
use MainBundle\Entity\Schedule;
use Cegedim\Bundle\OwaCasBundle\Security\User\OwaUser;

class HcpConfirmationMailer
{


	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $em;

	protected $templating;

	protected $mailer;

	public function __construct(EntityManager $em, $templating, $mailer) {
		$this->em = $em;
		$this->templating = $templating;
		$this->mailer = $mailer;
	}

	/**
	 * @param Schedule $schedule MainBundle/Entity/Schedule
	 * @param OwaUser $schedule Cegedim\Bundle\OwaCasBundle\Security\User\OwaUser
	 * @param ucb_patient_action $ucb_patient_action Dandelion Patient URL
	 * @param file_path $file_path ICS file path
	 * @return \Doctrine\Common\Collections\Collection
	 */
	public function sendMail(Schedule $schedule, OwaUser $owauser, $ucb_patient_action, $file_path)
	{
		$message = \Swift_Message::newInstance()
			->setSubject('UpComing Patient Education Session - '. $schedule->getTitle())
			//->setFrom('no-reply@dandelion.com')
			// ->setTo($owauser->getEmail())
			->setFrom('alokggokhe@ymail.com')
			//->setTo('nirajtest1@gmail.com')
			->setTo('alokggokhe@gmail.com')
			->setBody($this->templating->render('MainBundle:Mail:hcp_confirmation.html.twig', array(
				'firstname'                 => $schedule->getFirstname(),
				'lastname'                  => $schedule->getLastname(),
				'title'                     => $schedule->getTitle(),
				'idetailling_patient_url'   => $ucb_patient_action,
				'idetailling_hcp_url'       => $ucb_patient_action,
				'hcp_phone'                 => $schedule->getPhone(),
				'hcp_firstname'             => $owauser->getFirstname(),
				'hcp_name'                  => $owauser->getUsername(),
				'date'                      => $schedule->getScheduledatetime()->format('Y/m/d'),
				'time'                      => $schedule->getScheduledatetime()->format('h:i A'),
			)),'text/html')
			->attach(\Swift_Attachment::fromPath($file_path));

		$this->mailer->send($message);

		return true;
	}
}
