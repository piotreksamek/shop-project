<?php

declare(strict_types=1);

namespace App\Application\User\Api;

use App\Application\User\DTO\Api\UpdateUserDTO;
use App\Application\User\Message\UpdateUserCommand;
use App\Shared\Api\Controller\AbstractApiController;
use App\Shared\Messenger\CommandBus\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Attributes as OA;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[AsController]
class UserController extends AbstractApiController
{
    #[OA\Post(
        path: '/api/security/register',
    )]
    #[Route('/api/update/user', name: 'api_post_update_user', methods: [Request::METHOD_POST])]
    public function updateUser(
        #[CurrentUser] UserInterface $user,
        #[MapRequestPayload] UpdateUserDTO $dto,
        CommandBus $bus
    ): JsonResponse {
        $addressDTO = $dto->address;

        try {
            $bus->dispatch(new UpdateUserCommand(
                userId: $user->getId(),
                firstName: $dto->firstName,
                lastName: $dto->lastName,
                street: $addressDTO?->street,
                number: $addressDTO?->number,
                apartmentNumber: $addressDTO?->apartmentNumber,
                city: $addressDTO?->city,
                postalCode: $addressDTO?->postalCode,
                province: $addressDTO?->province,
                country: $addressDTO?->country,
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
