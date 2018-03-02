<?php

namespace Reliv\ValidationRat\Api;

use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRat\Model\ValidationResultFieldsBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class MergeValidationResultsFields
{
    /**
     * Second ValidationResultFields will over-ride the first
     *
     * @param ValidationResultFields $validationResultFields
     * @param ValidationResultFields $validationResultFieldsMore
     *
     * @return ValidationResultFields
     * @throws \Exception
     */
    public static function invoke(
        ValidationResultFields $validationResultFields,
        ValidationResultFields $validationResultFieldsMore
    ): ValidationResultFields {
        $code = '';

        if (!$validationResultFields->isValid()) {
            $code = $validationResultFields->getCode();
        }

        if (!$validationResultFieldsMore->isValid()) {
            $code = $validationResultFieldsMore->getCode();
        }

        $isValid = ($validationResultFields->isValid() && $validationResultFieldsMore->isValid());

        $details = array_merge(
            $validationResultFields->getDetails(),
            $validationResultFieldsMore->getDetails()
        );

        $mergedFieldResults = array_merge(
            $validationResultFields->getFieldResults(),
            $validationResultFieldsMore->getFieldResults()
        );

        return new ValidationResultFieldsBasic(
            $isValid,
            $code,
            $details,
            $mergedFieldResults
        );
    }

    /**
     * Second ValidationResultFields will over-ride the first
     *
     * @param ValidationResultFields $validationResultFields
     * @param ValidationResultFields $validationResultFieldsMore
     *
     * @return ValidationResultFields
     * @throws \Exception
     */
    public function __invoke(
        ValidationResultFields $validationResultFields,
        ValidationResultFields $validationResultFieldsMore
    ): ValidationResultFields {
        return static::invoke(
            $validationResultFields,
            $validationResultFieldsMore
        );
    }
}
