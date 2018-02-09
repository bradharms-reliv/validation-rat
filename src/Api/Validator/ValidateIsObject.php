<?php

namespace Reliv\ValidationRat\Api\Validator;

use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultBasic;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsObject implements Validate
{
    const CODE_MUST_BE_OBJECT = 'must-be-object';
    const CODE_MUST_BE_OBJECT_OF_TYPE = 'must-be-object-of-type';

    const OPTION_OBJECT_TYPE = 'object-type';

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
        if (!is_object($value)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_OBJECT
            );
        }

        $objectType = Property::getString(
            $options,
            static::OPTION_OBJECT_TYPE
        );

        if (empty($objectType)) {
            return new ValidationResultBasic();
        }

        if (!is_a($value, $objectType)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_OBJECT_OF_TYPE,
                ['message' => 'Object: (' . get_class($value) . ') must be type of: (' . $objectType . ')']
            );
        }

        return new ValidationResultBasic();
    }
}
