<?php

declare(strict_types=1);

namespace App\Application\User\MessageHandler;

use App\Application\User\Factory\AddressFactory;
use App\Application\User\Message\UpdateUserAddressCommand;
use App\Domain\Security\Entity\User;
use App\Domain\Security\Interface\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateUserAddressCommandHandler
{
    public function __construct(private readonly UserRepositoryInterface $repository)
    {
    }

    public function __invoke(UpdateUserAddressCommand $command)
    {
        /** @var User $user */
        $user = $this->repository->find($command->userId);

        $user->getBaseInformation()->setAddress(
            AddressFactory::createAddress($command)
        );

        $this->repository->save($user);
    }
}
