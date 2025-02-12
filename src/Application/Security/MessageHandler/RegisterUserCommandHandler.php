<?php

declare(strict_types=1);

namespace App\Application\Security\MessageHandler;

use App\Application\Security\Factory\UserFactory;
use App\Application\Security\Message\RegisterUserCommand;
use App\Domain\Security\Interface\UserRepositoryInterface;
use App\Shared\Domain\Event\DomainEventBus;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RegisterUserCommandHandler
{
    public function __construct(
        private readonly UserFactory $userFactory,
        private readonly UserRepositoryInterface $userRepository,
        private readonly DomainEventBus $domainEventBus,
    ) {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $user = $this->userFactory->create($command);
        $userEventStream = $user->getUncommittedEvents();

        $this->userRepository->save($user);
        $this->domainEventBus->dispatchStream($userEventStream);
    }
}
