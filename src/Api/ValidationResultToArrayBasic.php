<?php

namespace Reliv\ValidationRat\Api;

use Reliv\ValidationRat\Model\ValidationResult;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidationResultToArrayBasic implements ValidationResultToArray
{
    /**
     * @param ValidationResult $validationResult
     * @param array            $options
     *
     * @return array
     */
    public function __invoke(
        ValidationResult $validationResult,
        array $options = []
    ): array {
        $array = [];

        $array['valid'] = $validationResult->isValid();
        $array['code'] = $validationResult->getCode();
        $array['details'] = $validationResult->getDetails();

        return $array;
    }
}
