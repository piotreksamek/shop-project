<?php

declare(strict_types=1);

namespace App\Application\Mailer;

use Symfony\Component\Mime\Email;

interface ContactMailerInterface
{
    public function send(Email $email): void;
}
