<?php

namespace spec\App\Contact;

use App\Contact\ContactType;
use Symfony\Component\Form\AbstractType;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContactTypeSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ContactType::class);
        $this->shouldHaveType(AbstractType::class);
    }
}
