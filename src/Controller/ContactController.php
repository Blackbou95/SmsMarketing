<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Contact;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Contact::class);

        $contacts = $repo->findAll();

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contacts' => $contacts
        ]);
    }

    /**
         * @Route("/newcontact", name="newcontact")
         */
        public function create(Request $request, EntityManagerInterface $manager)
        {
            //dump($request);
            if($request->request->count() > 0){
             $contact = new Contact();
             $contact->setNom($request->request->get('nom'));
             $contact->setPrenom($request->request->get('prenom'));
             $contact->setPhonenumber($request->request->get('phone'));

              $manager->persist($contact);
              $manager->flush();

              return $this->redirectToRoute('contact');
            }

            return $this->render('contact/create.html.twig', [
                'controller_name' => 'ContactController',
            ]);
        }

}
