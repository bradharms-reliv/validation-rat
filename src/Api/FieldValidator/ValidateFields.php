<?php

namespace Reliv\ValidationRat\Api\FieldValidator;

use Reliv\ValidationRat\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidateFields
{
    /**
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields;
}
