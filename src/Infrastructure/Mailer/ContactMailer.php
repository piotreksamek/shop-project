<?php

declare(strict_types=1);

namespace App\Infrastructure\Mailer;

use App\Application\Mailer\ContactMailerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactMailer implements ContactMailerInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
    ) {}

    public function send(Email $email): void
    {
        $this->mailer->send($email);
    }
}
