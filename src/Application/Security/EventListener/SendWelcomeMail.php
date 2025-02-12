<?php

declare(strict_types=1);

namespace App\Application\Security\EventListener;

use App\Application\Mailer\Builder\EmailBuilder;
use App\Application\Mailer\ContactMailerInterface;
use App\Application\Mailer\TemplateRendererInterface;
use App\Domain\Security\Event\UserRegistered;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendWelcomeMail
{
    public const EMAIL_TITLE = 'Witaj! Potwierdź swojego maila.';

    public function __construct(
        #[Autowire('%app.email_from%')]
        private string $from,
        #[Autowire('%app.frontend_url%')]
        private string $frontendUrl,
        private readonly ContactMailerInterface $contactMailer,
        private readonly LoggerInterface $logger,
        private readonly TemplateRendererInterface $templateRenderer,
    ) {
    }

    public function __invoke(UserRegistered $event)
    {

        $template = $this->templateRenderer->render(
            '/mail/welcome_new_user.html.twig',
            [
                'verification_link' => sprintf('%semail/verify/%s', $this->frontendUrl, $event->emailVerificationToken),
            ]
        );

        $email = EmailBuilder::create()
            ->from($this->from)
            ->to($event->email)
            ->withContent(self::EMAIL_TITLE, $template)
            ->build()
        ;

        try {
            $this->contactMailer->send($email);
        } catch (TransportExceptionInterface $exception) {
            $this->logger->info($exception->getMessage());
        }
    }
}
