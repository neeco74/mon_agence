<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\Security;

class ContactNotification
{



    /**
     * @var Environment
     */
    private $renderer;

    /**
     *
     */
    private $security;

    public function __construct(Environment $renderer, MailerInterface $mailer, Security $security)
    {

        $this->renderer = $renderer;
        $this->security = $security;
        $this->mailer = $mailer;
    }

    public function notify(Contact $contact)
    {
        // // $message = (new \Swift_Message('Agence : ' . $contact->getBiens()->getTitre()))
        // //     ->setFrom('noreply@agence.fr')
        // //     ->setTo('contact@agence.fr')
        // //     ->setReplyTo($contact->getEmail())
        // //     ->setBody($this->renderer->render('emails/contact.html.twig', [
        // //         'contact' => $contact
        // //     ]), 'text/html');
        // // $this->mailer->send($message);
        // $email = (new Email())
        //     ->from('noreply@agence.fr')
        //     ->to('contact@agence.fr')
        //     //->cc('cc@example.com')
        //     //->bcc('bcc@example.com')
        //     ->replyTo($contact->getEmail())
        //     //->priority(Email::PRIORITY_HIGH)
        //     ->subject('Time for Symfony Mailer!')
        //     ->text('Sending emails is fun again!')
        //     ->html('<p>See Twig integration for better HTML integration!</p>');

        // $mailer->send($email);

        $currentUser = $this->security->getUser();  
        dump($currentUser);
        $email = new TemplatedEmail();

        if($currentUser) {
            $email->to(new Address($currentUser->getEmail(), $currentUser->getFirstName()));
        }
        else {
            $email->to(new Address($contact->getEmail(), $contact->getFirstname()));       
        }
        $email->from("noreply@agence.fr")
            ->subject('Agence : ' . $contact->getBiens()->getTitre())
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact

            ]);



        $this->mailer->send($email);
    }
}
