<?php

declare(strict_types=1);

namespace App\Application\Security\Validator;

use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\PropertyAccess\Exception\UninitializedPropertyException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class SameAsPasswordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$constraint instanceof SameAsPassword) {
            throw new UnexpectedTypeException($constraint, SameAsPassword::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $object = $this->context->getObject();

        if (!property_exists($object, 'password')) {
            throw new UninitializedPropertyException('Property "password" does not exist');
        }

        if (!property_exists($object, 'confirmPassword')) {
            throw new UninitializedPropertyException('Property "confirmPassword" does not exist');
        }

        if ($object->confirmPassword === $object->password) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->addViolation();
    }
}
