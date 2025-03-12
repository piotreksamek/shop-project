<?php

declare(strict_types=1);

namespace App\Application\Common\Validator;

use App\Domain\Security\Embeddable\PostalCode as PostalCodeVO;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PostalCodeValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PostalCode) {
            throw new UnexpectedTypeException($constraint, PostalCode::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        try {
            PostalCodeVO::validate($value);
        } catch (\InvalidArgumentException) {
            $this->context->buildViolation($constraint->message);
        }
    }
}
