<?php

declare(strict_types=1);

namespace App\Application\Security\Api;

use App\Application\Security\DTO\Api\TokenDTO;
use App\Application\Security\DTO\Api\UserDTO;
use App\Application\Security\Message\RegisterUserCommand;
use App\Application\Security\Message\VerifiedUserEmailCommand;
use App\Shared\Api\Controller\AbstractApiController;
use App\Shared\Messenger\CommandBus\CommandBus;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Uid\Uuid;

#[AsController]
class SecurityController extends AbstractApiController
{
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
                password: $dto->password,
                firstName: $dto->firstName,
                lastName: $dto->lastName,
            ));
        } catch (HandlerFailedException $exception) {
            return $this->successKnownIssueMessage($exception);
        }

        return $this->successData('Pomyślnie zarejestrowano użytkownika', [
            'id' => $id,
            'email' => $dto->email,
        ]);
    }

    #[Route('/api/user', name: 'api_get_user', methods: ['GET'])]
    public function getUser(#[CurrentUser] ?UserInterface $user): JsonResponse
    {
        if (!$user) {
            return $this->successKnownIssueMessage(new \Exception('asd'));
        }

        return $this->successData('Użytkownik jest zalogowany', [
            'id' => $user->getId(),
            'email' => $user->getUserIdentifier(),
        ]);
    }

    #[Route('/api/email/verify', name: 'api_post_email_verify', methods: [Request::METHOD_POST])]
    public function verify(
        #[MapRequestPayload] TokenDTO $dto,
        CommandBus $commandBus,
    ): JsonResponse {
        try {
            $commandBus->dispatch(new VerifiedUserEmailCommand($dto->token));
        } catch (HandlerFailedException $exception) {
            return $this->successKnownIssueMessage($exception);
        }

        return $this->successData('Zweryfikowano użytkownika', []);
    }
}
