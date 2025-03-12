<?php

declare(strict_types=1);

namespace App\Application\User\Api;

use App\Application\User\DTO\Api\AddressDTO;
use App\Application\User\DTO\Api\BaseInformationDTO;
use App\Application\User\DTO\Api\UserDTO;
use App\Application\User\Message\UpdateUserAddressCommand;
use App\Application\User\Message\UpdateUserCommand;
use App\Shared\Api\Controller\AbstractApiController;
use App\Shared\Messenger\CommandBus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsController]
#[Route('/api/user')]
class UserController extends AbstractApiController
{
    #[Route('/data', name: 'api_get_user_data', methods: [Request::METHOD_GET])]
    public function getUserData(
        #[CurrentUser] UserInterface $user
    ): JsonResponse {
        return $this->successData(
            'User data', [
                'user' => UserDTO::from($user),
            ],
        );
    }

    #[Route('/update/address', name: 'api_post_user_address_update', methods: [Request::METHOD_POST])]
    public function updateAddress(
        #[CurrentUser] UserInterface $user,
        #[MapRequestPayload] AddressDTO $dto,
        CommandBus $commandBus,
    ): JsonResponse {
        try {
            $commandBus->dispatch(new UpdateUserAddressCommand(
                userId: $user->getId(),
                street: $dto->street,
                number: $dto->number,
                apartmentNumber: $dto->apartmentNumber,
                city: $dto->city,
                postalCode: $dto->postalCode,
                province: $dto->province,
            ));
        } catch (HandlerFailedException $exception) {
            return $this->successKnownIssueMessage($exception);
        }

        return $this->successData(
            'Zaktualizowano dane użytkownika', [
            ]
        );
    }

    #[Route('/update', name: 'api_post_user_update', methods: [Request::METHOD_POST])]
    public function updateUser(
        #[CurrentUser] UserInterface $user,
        #[MapRequestPayload] BaseInformationDTO $dto,
        CommandBus $commandBus
    ): JsonResponse {
        $addressDTO = $dto->address;

        try {
            $commandBus->dispatch(new UpdateUserCommand(
                userId: $user->getId(),
                firstName: $dto->firstName,
                lastName: $dto->lastName,
                street: $addressDTO?->street,
                number: $addressDTO?->number,
                apartmentNumber: $addressDTO?->apartmentNumber,
                city: $addressDTO?->city,
                postalCode: $addressDTO?->postalCode,
                province: $addressDTO?->province,
            ));
        } catch (HandlerFailedException $exception) {
            return $this->successKnownIssueMessage($exception);
        }

        return $this->successData(
            'Zaktualizowano dane użytkownika.',
            $dto,
        );
    }
}
