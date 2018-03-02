<?php

namespace Reliv\ValidationRat\Api;

use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRat\Model\ValidationResultFieldsBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class AddValidationResult
{
    const DEFAULT_INVALID_CODE = BuildCode::DEFAULT_INVALID_CODE;

    /**
     * @param ValidationResultFields $validationResultFields
     * @param ValidationResult       $validationResult
     * @param string                 $fieldName
     * @param string                 $invalidCode
     *
     * @return ValidationResultFields
     * @throws \Exception
     */
    public static function invoke(
        ValidationResultFields $validationResultFields,
        ValidationResult $validationResult,
        string $fieldName,
        string $invalidCode = self::DEFAULT_INVALID_CODE
    ): ValidationResultFields {
        $isValid = ($validationResultFields->isValid() && $validationResult->isValid());

        $code = ($isValid ? '' : $invalidCode);

        $fieldResults = $validationResultFields->getFieldResults();

        $fieldResults[$fieldName] = $validationResult;

        return new ValidationResultFieldsBasic(
            $isValid,
            $code,
            $validationResultFields->getDetails(),
            $fieldResults
        );
    }
}
