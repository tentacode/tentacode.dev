<?php

namespace spec\App\Post;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContentSpec extends ObjectBehavior
{
    function let()
    {
        $markdown = <<<'EOD'
# Aujourd'hui, j'ai mangé des pâtes, VDM.

C'était des pâtes **arrabiata**.
EOD;

        $this->beConstructedWith($markdown);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('App\Post\Content');
    }

    function it_has_a_title()
    {
        $this->getTitle()->shouldReturn("Aujourd'hui, j'ai mangé des pâtes, VDM.");
    }

    function it_has_a_body()
    {
        $this->getBody()->shouldReturn("<p>C'était des pâtes <strong>arrabiata</strong>.</p>");
    }

    function it_can_get_a_text_exerpt()
    {
        $this->getExcerpt(15)->shouldReturn("C'était des…");
    }

    function it_renders_github_code_markdown()
    {
        $markdown = <<<'EOD'
```php
function print_and_stop($message) { die($message); }
```
EOD;

        $this->beConstructedWith($markdown);
        $this->getBody()->shouldReturn(
            "<pre><code class=\"language-php\">function print_and_stop(\$message) { die(\$message); }</code></pre>"
        );
    }

    function it_auto_add_anchor_to_titles()
    {
        $markdown = <<<'EOD'
# Aujourd'hui, j'ai mangé des pâtes, VDM.

## Le Marvelous Title
EOD;

        $this->beConstructedWith($markdown);
        $this->getBody()->shouldReturn(
            '<h2 id="lemarveloustitle">Le Marvelous Title</h2>'
        );
    }
}
