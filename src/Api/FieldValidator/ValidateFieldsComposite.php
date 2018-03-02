<?php

namespace Reliv\ValidationRat\Api\FieldValidator;

use Reliv\ValidationRat\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsComposite implements ValidateFields
{
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        // @todo This will allow us to run multiple ValidateFields on the same data
    }
}
