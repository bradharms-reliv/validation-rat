<?php

namespace Reliv\ValidationRat\Api\Validator;

use Reliv\ArrayProperties\Property;
use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultBasic;

/**
 * If any validator fails - all fail
 *
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateCompositeByStrategy implements Validate
{
    const OPTION_VALIDATORS = 'validators';

    protected $validateByStrategy;

    /**
     * @param ValidateByStrategy $validateByStrategy
     */
    public function __construct(
        ValidateByStrategy $validateByStrategy
    ) {
        $this->validateByStrategy = $validateByStrategy;
    }

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Reliv\ValidationRat\Exception\ValidateApiInvalid
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $valid = true;
        $code = '';
        $validationResults = [];

        Property::assertNotEmpty(
            $options,
            static::OPTION_VALIDATORS
        );

        $validateApiList = Property::getArray(
            $options,
            static::OPTION_VALIDATORS
        );

        /** @var string $validateApiServiceName */
        foreach ($validateApiList as $validationConfig) {
            $validationResult = $this->validateByStrategy->__invoke(
                $value,
                $validationConfig
            );

            // Use the first code we get
            if (!$validationResult->isValid() && $valid) {
                $valid = false;

                $code = $validationResult->getCode();
            }

            $validationResults[] = [
                'validator' => Property::getString(
                    $options,
                    ValidateByStrategy::OPTION_VALIDATE_API
                ),
                'valid' => $validationResult->isValid(),
                'code' => $validationResult->getCode(),
                'details' => $validationResult->getDetails(),
            ];
        };

        return new ValidationResultBasic(
            $valid,
            $code,
            [
                'validation-results' => $validationResults
            ]
        );
    }
}
