<?php

declare(strict_types=1);

namespace App\Application\Security\MessageHandler;

use App\Application\Security\Factory\UserFactory;
use App\Application\Security\Message\RegisterUserCommand;
use App\Domain\Security\Interface\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RegisterUserCommandHandler
{
    public function __construct(
        private readonly UserFactory $userFactory,
        private readonly UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $user = $this->userFactory->create($command);

        $this->userRepository->save($user);
    }
}
