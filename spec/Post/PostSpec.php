<?php

namespace spec\App\Post;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use App\Post\Content;
use DateTime;

class PostSpec extends ObjectBehavior
{
    function let(DateTime $date)
    {
        $content = new Content('# Salut');

        $this->beConstructedWith(
            $content,
            'something-something',
            $date
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('App\Post\Post');
    }

    function it_has_a_content()
    {
        $this->getContent()->shouldBeLike(new Content('# Salut'));
    }

    function it_has_a_date($date)
    {
        $this->getDate()->shouldReturn($date);
    }

    function it_has_a_slug()
    {
        $this->getSlug()->shouldReturn('something-something');
    }
}
