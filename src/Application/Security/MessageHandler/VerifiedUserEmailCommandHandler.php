<?php

declare(strict_types=1);

namespace App\Application\Security\MessageHandler;

use App\Application\Security\Message\VerifiedUserEmailCommand;
use App\Domain\Security\Interface\UserRepositoryInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\ExpiredTokenException;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\InvalidTokenException;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use DateTimeImmutable;

#[AsMessageHandler]
class VerifiedUserEmailCommandHandler
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function __invoke(VerifiedUserEmailCommand $command): void
    {
        $user = $this->repository->findOneByEmailVerifyToken($command->token);

        if (!$user) {
            throw new InvalidTokenException('Token jest nieprawidłowy');
        }

        if ($user->getEmailVerificationExpiresAt() < new DateTimeImmutable()) {
            throw new ExpiredTokenException('Token wygasł');
        }

        $user->verifyEmail();

        $this->repository->save($user);
    }
}
