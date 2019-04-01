<?php

namespace spec\App\Contact;

use App\Contact\ContactMessageSender;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\Contact\ContactMessage;

class ContactMessageSenderSpec extends ObjectBehavior
{
    function let(\Swift_Mailer $mailer)
    {
        $this->beConstructedWith($mailer);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ContactMessageSender::class);
    }

    function it_can_send_a_message($mailer)
    {
        $swiftMessage = new \Swift_Message(
            '[tentacode.dev] message from John Doe'
        );

        $swiftMessage->setFrom(['johndoe@example.com' => 'John Doe']);
        $swiftMessage->setTo(['contact@gabrielpillet.com' => 'Gabriel Pillet']);
        $swiftMessage->setBody('I WANT TO HIRE YOU', 'text/plain');

        $mailer->send(Argument::that(function ($swiftMessage) {
            if ($swiftMessage instanceof \Switf_Message) {
                return false;
            }

            if ($swiftMessage->getFrom() !== [
                'johndoe@example.com' => 'John Doe'
            ]) {
                return false;
            }

            if ($swiftMessage->getTo() !== [
                'contact@gabrielpillet.com' => 'Gabriel Pillet'
            ]) {
                return false;
            }

            if ($swiftMessage->getBody() !== 'I WANT TO HIRE YOU') {
                return false;
            }

            return true;
        }))->shouldBeCalled();

        $contactMessage = new ContactMessage();
        $contactMessage->setSenderEmail('johndoe@example.com');
        $contactMessage->setSenderName('John Doe');
        $contactMessage->setMessage('I WANT TO HIRE YOU');

        $this->send($contactMessage);
    }
}
