<?php

declare(strict_types=1);

namespace App\Application\Security\Api;

use App\Application\Security\DTO\Api\UserDTO;
use App\Application\Security\Message\RegisterUserCommand;
use App\Shared\Api\Controller\AbstractApiController;
use App\Shared\Messenger\CommandBus\CommandBus;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Uid\Uuid;

#[AsController]
class SecurityController extends AbstractApiController
{
    #[OA\Post(
        path: '/api/security/register',
    )]
    #[Route('/api/security/register', name: 'api_post_security_user', methods: [Request::METHOD_POST])]
    public function register(
        #[MapRequestPayload] UserDTO $dto,
        CommandBus $bus,
    ): JsonResponse {
        $id = Uuid::v7();

        try {
            $bus->dispatch(new RegisterUserCommand(
                id: $id,
                email: $dto->email,
                password: $dto->password
            ));
        } catch (HandlerFailedException $exception) {
            return $this->successKnownIssueMessage($exception);
        }

        return $this->successData('Pomyślnie zarejestrowano użytkownika', [
            'id' => $id,
            'email' => $dto->email,
        ]);
    }

    #[Route('/api/user', name: 'api_user', methods: ['GET'])]
    public function getUser(#[CurrentUser] ?UserInterface $user): JsonResponse
    {
        if (!$user) {
            return $this->successKnownIssueMessage(new UnauthorizedHttpException('asd'));
        }

        return $this->successData('Użytkownik jest zalogowany', [
            'id' => $user->getId(),
            'email' => $user->getUserIdentifier(),
        ]);
    }
}
