<?php

namespace App\Entity;


use Symfony\Component\Validator\ConstraintViolationList as CVL;


class ValidationException extends \Exception
{
    private $violations;

    public function __construct(CVL $violations)
    {
        $this->violations = $violations;
        parent::__construct('Validation failed.');
    }

    public function getMessages()
    {
        $messages = [];
        foreach ($this->violations as $paramName => $violationList) {
            foreach ($violationList as $violation) {
                $messages[$paramName][] = $violation->getMessage();
            }
        }
        return $messages;
    }

    public function getJoinedMessages()
    {
        $messages = [];
        foreach ($this->violations as $paramName => $violationList) {
            foreach ($violationList as $violation) {
                $messages[$paramName][] = $violation->getMessage();
            }
            $messages[$paramName] = implode(' ', $messages[$paramName]);
        }
        return $messages;
    }
}