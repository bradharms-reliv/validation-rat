<?php

namespace Reliv\ValidationRat\Api\Validator;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsObjectOrNullFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateIsObjectOrNull
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateIsObjectOrNull();
    }
}
