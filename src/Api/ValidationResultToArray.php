<?php

namespace Reliv\ValidationRat\Api;

use Reliv\ValidationRat\Model\ValidationResult;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidationResultToArray
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
    ): array;
}
