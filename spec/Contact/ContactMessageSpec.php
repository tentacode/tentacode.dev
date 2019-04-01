<?php

namespace spec\App\Contact;

use App\Contact\ContactMessage;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContactMessageSpec extends ObjectBehavior
{
    function let()
    {
        $this->setSenderEmail('johndoe@example.com');
        $this->setSenderName('John Doe');
        $this->setMessage('I WANT TO HIRE YOU SO BAD');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ContactMessage::class);
    }

    function it_has_a_sender_email()
    {
        $this->getSenderEmail()->shouldReturn('johndoe@example.com');
    }

    function is_has_a_sender_name()
    {
        $this->getSenderName()->shouldReturn('John Doe');
    }

    function it_has_a_message()
    {
        $this->getMessage()->shouldReturn('I WANT TO HIRE YOU SO BAD');
    }
}
