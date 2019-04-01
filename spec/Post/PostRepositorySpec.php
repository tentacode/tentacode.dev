<?php

namespace spec\App\Post;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PostRepositorySpec extends ObjectBehavior
{
    function let()
    {
        // giving the actual post directory
        $this->beConstructedWith(str_replace(
            'spec/Post',
            'resources/posts',
            __DIR__
        ));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('App\Post\PostRepository');
    }

    function it_gets_posts()
    {
        $this->getPosts()->shouldBeArray();
    }
}
