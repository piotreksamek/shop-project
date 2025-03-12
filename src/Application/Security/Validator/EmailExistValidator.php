<?php

declare(strict_types=1);

namespace App\Application\Security\Validator;

use App\Domain\Security\Interface\UserRepositoryInterface;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailExistValidator extends ConstraintValidator
{
    public function __construct(private readonly UserRepositoryInterface $userRepository) {}

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof EmailExist) {
            throw new UnexpectedTypeException($constraint, EmailExist::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        $emailIsExists = $this->userRepository->isEmailExist($value);

        if (!$emailIsExists) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation()
        ;
    }
}
