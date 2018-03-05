<?php

namespace Reliv\ValidationRat\Api\Validator;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsStringOrNullFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateIsStringOrNull
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateIsStringOrNull();
    }
}
