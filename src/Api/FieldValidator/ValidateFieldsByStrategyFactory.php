<?php

namespace Reliv\ValidationRat\Api\FieldValidator;

use Psr\Container\ContainerInterface;
use Reliv\ValidationRat\Api\Validator\ValidateByStrategy;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsByStrategyFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateFieldsByStrategy
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateFieldsByStrategy(
            $serviceContainer,
            $serviceContainer->get(ValidateByStrategy::class),
            ValidateFieldsByStrategy::DEFAULT_INVALID_CODE
        );
    }
}
