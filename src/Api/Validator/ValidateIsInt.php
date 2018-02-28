<?php

namespace Reliv\ValidationRat\Api\Validator;

use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsInt implements Validate
{
    const CODE_MUST_BE_INT = 'must-be-int';

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
        if (!is_int($value)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_INT
            );
        }

        return new ValidationResultBasic();
    }
}
