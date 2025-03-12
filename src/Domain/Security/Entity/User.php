<?php

declare(strict_types=1);

namespace App\Domain\Security\Entity;

use App\Domain\Security\Event\UserRegistered;
use App\Shared\Domain\Event\DomainEventTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use DateTimeImmutable;

#[Entity]
#[HasLifecycleCallbacks]
#[Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use DomainEventTrait;

    #[Column(type: Types::STRING)]
    private string $password;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private DateTimeImmutable $createdAt;

    #[Column(type: Types::BOOLEAN)]
    private bool $isVerified = false;

    #[Column(type: Types::STRING, length: 32, unique: true, nullable: true)]
    private ?string $emailVerificationToken = null;

    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $emailVerificationExpiresAt = null;

    /** @param array<int, string> $roles */
    public function __construct(
        #[Id]
        #[Column(type: UuidType::NAME, unique: true)]
        public Uuid $id,
        #[Column(type: Types::STRING, length: 180, unique: true)]
        private string $email,
        #[OneToOne(targetEntity: BaseInformation::class, cascade: ['PERSIST', 'REMOVE'])]
        private BaseInformation $baseInformation,
        #[Column(type: Types::JSON)]
        private array $roles = [],
    ) {
        $this->generateActivationToken();

        $this->apply(new UserRegistered($id, $email, $this->emailVerificationToken));
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /** @return array<int, string> */
    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void {}

    #[PrePersist]
    public function setCreatedAt(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function generateActivationToken(): void
    {
        $this->emailVerificationToken = Uuid::v4()->toBase32();
        $this->emailVerificationExpiresAt = new \DateTimeImmutable('+1 day');
    }

    public function getEmailVerificationExpiresAt(): ?\DateTimeImmutable
    {
        return $this->emailVerificationExpiresAt;
    }

    public function verifyEmail(): void
    {
        $this->isVerified = true;
        $this->emailVerificationToken = null;
        $this->emailVerificationExpiresAt = null;
    }

    public function setBaseInformation(BaseInformation $baseInformation): void
    {
        $this->baseInformation = $baseInformation;
    }

    public function getBaseInformation(): BaseInformation
    {
        return $this->baseInformation;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
