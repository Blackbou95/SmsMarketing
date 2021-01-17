<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Sms;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;



class SmsController extends AbstractController
{
    /**
     * @Route("/sms", name="sms")
     */
    public function index(Request $request,EntityManagerInterface $manager): Response
    {
       $sms = new Sms();

        if($request->request->count() > 0){
          $sms = new Sms();

          //Tableau de tout les contacts
          $repo = $this->getDoctrine()->getRepository(Contact::class);
          $contacts = $repo->findAll();

          $sms->setContact($contacts[0]->getPhonenumber());

          $message = $request->request->get('smsAsend');
          $AllSMS = $this->sendMsg($message,$contacts,$manager);
          $message = $this->changeMessage($message,$contacts[0]);
          $sms->setMessage($message);

          return $this->render('sms/Allsmssend.html.twig', [
                      'controller_name' => 'SmsController',
                      'Allsms' => $AllSMS
           ]);

        }

        return $this->render('sms/smssender.html.twig', [
            'controller_name' => 'SmsController',
            'sms' => $sms
        ]);
    }
    public function changeMessage($msg,$contact){
     $msg= str_replace("%nom%", $contact->getNom(), $msg);
     $msg= str_replace("%prenom%", $contact->getPrenom(), $msg);
     return $msg;
    }
    public function sendMsg($msg,$contacts,$manager){ //recois un message et une liste de contact
      $saveMsg=$msg;
      $AllSms= array();
      for($i=0 ; $i < count($contacts); $i++){
        $sms = new Sms();
        $msg = $saveMsg;
        $sms->setContact($contacts[$i]->getPhonenumber());
        $msg = $this->changeMessage($msg,$contacts[$i]);
        $sms->setMessage($msg);
        array_push($AllSms,$sms);
        $manager->persist($sms);
      }
      $manager->flush();
      return $AllSms;

    }


}
