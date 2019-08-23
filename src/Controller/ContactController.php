<?php
namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact")
     */
    public function contact(Request $request, \Swift_Mailer $mailer)
    {
        $contact = new Contact();//Le contact est crée
        dump($contact);

        $form = $this->createForm(ContactType::class, $contact);//crée le formulaire avec l'objet à hydrater

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            //Ajout du flashbag
            $this->addFlash('success','Votre mail a été envoyé : '.$contact->getEmail());//recupere le mail saisi dans le form.

            //Envoie du mail
            $message = (new \Swift_Message('Sujet du mail'))
            ->setFrom($contact->getEmail())
            ->setTo('pierre.hervo@laposte.net')
            ->setBody('Bonjour tout le monde')
            ;
            $mailer->send($message);

            //Redirection vers contact
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}