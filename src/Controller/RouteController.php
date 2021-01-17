<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RouteController extends AbstractController
{

   /**
      *@Route("/login")
      */
   public  function homepage(){
   return new Response("Page d'acceuil");
   }

   /**
    *@Route("/",name="home")
    */
   public function Login(){
      return $this->render('login/login.html.twig',['compte'=>'Bonjour']);
   }

   /**
    *@Route("/sms2",name="sms2")
    */
   public function smsSender(){
   return $this->render('SmsSender/smssender.html.twig',['user'=>'Bonjour']);
   }

}


?>