<?php

namespace Reliv\ValidationRat\Api\Validator;

use Reliv\ArrayProperties\Property;
use Reliv\ValidationRat\Api\BuildOptionCode;
use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsValue implements Validate
{
    const OPTION_CODES = BuildOptionCode::OPTION_CODES;
    const OPTION_REQUIRED_VALUE = 'required-value';

    const CODE_MUST_BE_REQUIRED_VALUE = 'must-be-required-value';

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     * @throws \Throwable
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $requiredValue = Property::getRequired(
            $options,
            static::OPTION_REQUIRED_VALUE
        );

        if ($value !== $requiredValue) {
            return new ValidationResultBasic(
                false,
                BuildOptionCode::invoke($options, static::CODE_MUST_BE_REQUIRED_VALUE),
                [
                    static::OPTION_REQUIRED_VALUE => $requiredValue,
                ]
            );
        }

        return new ValidationResultBasic();
    }
}
