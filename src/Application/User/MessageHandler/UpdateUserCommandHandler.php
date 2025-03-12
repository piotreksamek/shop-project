<?php

declare(strict_types=1);

namespace App\Application\User\MessageHandler;

use App\Application\User\Factory\BaseInformationFactory;
use App\Application\User\Message\UpdateUserCommand;
use App\Domain\Security\Entity\User;
use App\Domain\Security\Interface\UserRepositoryInterface;
use App\Infrastructure\Security\User\DoctrineUserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use InvalidArgumentException;

#[AsMessageHandler]
class UpdateUserCommandHandler
{
    /** @param DoctrineUserRepository $repository */
    public function __construct(private readonly UserRepositoryInterface $repository) {}

    public function __invoke(UpdateUserCommand $command): void
    {
        /** @var User|null $user */
        $user = $this->repository->find($command->userId->toRfc4122());

        if (!$user) {
            throw new InvalidArgumentException('Nie ma takiego usera');
        }

        $baseInformation = BaseInformationFactory::create($command);

        $user->setBaseInformation($baseInformation);

        $this->repository->save($user);
    }
}
