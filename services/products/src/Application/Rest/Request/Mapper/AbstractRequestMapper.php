<?php
/*
 * (c) Tzvetelin Tzvetkov <tzvetelin.tzvetkov@gmail.com>
 */

declare(strict_types=1);

namespace MT\Application\Rest\Request\Mapper;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class AbstractRequestMapper
{
    /**
     * @var ConstraintViolationListInterface
     */
    protected ConstraintViolationListInterface $errors;

    public function __construct()
    {
        $this->errors = new ConstraintViolationList();
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return $this->errors->count() > 0;
    }

    /**
     * @return array|null
     */
    public function getFirstError(): ?array
    {
        if ($this->hasErrors()) {
            $error = $this->errors->get(0);

            return [$error->getPropertyPath() => $error->getMessage()];
        }

        return null;
    }
}
