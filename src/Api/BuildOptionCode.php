<?php

namespace Reliv\ValidationRat\Api;

use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildOptionCode
{
    const OPTION_CODES = 'codes';

    /**
     * @param array  $options
     * @param string $code
     *
     * @return string
     */
    public static function invoke(
        array $options,
        string $code
    ): string {
        $codes = Property::getArray(
            $options,
            self::OPTION_CODES,
            null
        );

        if (empty($codes)) {
            return $code;
        }

        return Property::getString(
            $codes,
            $code,
            $code
        );
    }

    /**
     * @param array  $options
     * @param string $codeKey
     *
     * @return string
     */
    public function __invoke(
        array $options,
        string $codeKey
    ): string {
        return static::invoke(
            $options,
            $codeKey
        );
    }
}
