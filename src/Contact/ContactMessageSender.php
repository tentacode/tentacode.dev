<?php declare(strict_types=1);

namespace App\Contact;

class ContactMessageSender
{
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(ContactMessage $contactMessage): void
    {
        $message = new \Swift_Message(sprintf(
            '[tentacode.dev] message from %s',
            $contactMessage->getSenderName()
        ));

        $mySelf = [
            'contact@gabrielpillet.com' => 'Gabriel Pillet',
        ];

        $author = [
            $contactMessage->getSenderEmail() => $contactMessage->getSenderName()
        ];
            
        $message
            ->setFrom($author)
            ->setTo($mySelf)
            ->setBody($contactMessage->getMessage(), 'text/plain')
        ;

        $this->mailer->send($message);
    }
}
