<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Contact\ContactMessage;
use App\Contact\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Contact\ContactMessageSender;
use App\Post\PostRepository;

final class LandingController extends AbstractController
{
    const POST_COUNT = 3;

    private $contactMessageSender;
    private $postRepository;

    public function __construct(
        ContactMessageSender $contactMessageSender,
        PostRepository $postRepository
    ) {
        $this->contactMessageSender = $contactMessageSender;
        $this->postRepository = $postRepository;
    }

    public function __invoke(Request $request): Response
    {
        $contactForm = $this->createForm(ContactType::class, new ContactMessage);

        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contactMessage = $contactForm->getData();

            // sending the email
            $this->contactMessageSender->send($contactMessage);

            // displaying a thank you message
            $this->addFlash('success_message_sender_name', $contactMessage->getSenderName());

            return $this->redirectToRoute('landing', ['_fragment' => 'top']);
        }

        $posts = $this->postRepository->getPosts();

        return $this->render('landing/landing.html.twig', [
            'contact_form' => $contactForm->createView(),
            'posts' => array_slice($posts, 0, self::POST_COUNT),
            'more_posts_count' => count($posts) - self::POST_COUNT,
        ]);
    }
}
