<?php

namespace Reliv\ValidationRat\Api\Validator;

use Psr\Container\ContainerInterface;
use Reliv\ArrayProperties\Property;
use Reliv\ValidationRat\Exception\ValidateApiInvalid;
use Reliv\ValidationRat\Model\ValidationResult;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateByStrategy implements Validate
{
    const OPTION_VALIDATE_API = 'validator';
    const OPTION_VALIDATE_API_OPTIONS = 'options';

    protected $serviceContainer;

    /**
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        ContainerInterface $serviceContainer
    ) {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     * @throws ValidateApiInvalid
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $validateApiServiceName = Property::getRequired(
            $options,
            static::OPTION_VALIDATE_API
        );

        if (!$this->serviceContainer->has($validateApiServiceName)) {
            throw new ValidateApiInvalid(
                'Validation service not found: (' . $validateApiServiceName . ')'
            );
        }

        /** @var Validate $validateApi */
        $validateApi = $this->serviceContainer->get($validateApiServiceName);

        if (!$validateApi instanceof Validate) {
            throw new ValidateApiInvalid(
                'Validation service must be instance of: (' . Validate::class . ')'
            );
        }

        $validateApiOptions = Property::getArray(
            $options,
            static::OPTION_VALIDATE_API_OPTIONS,
            []
        );

        return $validateApi->__invoke(
            $value,
            $validateApiOptions
        );
    }
}
