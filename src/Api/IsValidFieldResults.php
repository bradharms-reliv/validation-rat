<?php

namespace Reliv\ValidationRat\Api;

use Reliv\ValidationRat\Model\ValidationResult;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class IsValidFieldResults
{
    /**
     * @param array $fieldResults
     * @param array $options
     *
     * @return bool
     */
    public static function invoke(
        array $fieldResults,
        array $options = []
    ): bool {
        /** @var ValidationResult $validationResult */
        foreach ($fieldResults as $validationResult) {
            if (!$validationResult->isValid()) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $fieldResults
     * @param array $options
     *
     * @return bool
     */
    public function __invoke(
        array $fieldResults,
        array $options = []
    ): bool {
        return self::invoke(
            $fieldResults,
            $options
        );
    }
}
