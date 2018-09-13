<?php

namespace Reliv\ValidationRat\Api\Validator;

use Reliv\ValidationRat\Api\BuildOptionCode;
use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsAssociativeArrayOrNull implements Validate
{
    const OPTION_CODES = BuildOptionCode::OPTION_CODES;

    const CODE_MUST_BE_ARRAY_OR_NULL = ValidateIsArrayOrNull::CODE_MUST_BE_ARRAY_OR_NULL;
    const CODE_MUST_BE_ASSOCIATIVE_ARRAY_OR_NULL = 'must-be-associative-array-or-null';

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        if (!is_array($value) && $value !== null) {
            return new ValidationResultBasic(
                false,
                BuildOptionCode::invoke($options, static::CODE_MUST_BE_ARRAY_OR_NULL)
            );
        }

        if (!(array_keys($value) !== range(0, count($value) - 1))) {
            return new ValidationResultBasic(
                false,
                BuildOptionCode::invoke($options, static::CODE_MUST_BE_ASSOCIATIVE_ARRAY_OR_NULL)
            );
        }

        return new ValidationResultBasic();
    }
}
