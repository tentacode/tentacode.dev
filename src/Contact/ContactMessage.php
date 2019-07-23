<?php declare(strict_types=1);

namespace App\Contact;

use Symfony\Component\Validator\Constraints as Assert;

class ContactMessage
{
    /**
     * @Assert\NotBlank
     * @Assert\Email
     */
    private $senderEmail;

    /**
     * @Assert\NotBlank
     */
    private $senderName;

    /**
     * @Assert\NotBlank
     */
    private $message;

    /**
     * @Assert\NotBlank
     * @Assert\EqualTo("tentacode")
     */
    public $areYouABot;

    public function setSenderEmail(string $senderEmail): void
    {
        $this->senderEmail = $senderEmail;
    }

    public function setSenderName(string $senderName): void
    {
        $this->senderName = $senderName;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getSenderEmail(): ?string
    {
        return $this->senderEmail;
    }

    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}
