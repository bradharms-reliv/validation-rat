<?php

namespace Reliv\ValidationRat\Api\FieldValidator;

use Psr\Container\ContainerInterface;
use Reliv\ValidationRat\Api\BuildCode;
use Reliv\ValidationRat\Api\BuildFieldNotRecognizedResult;
use Reliv\ValidationRat\Api\IsValidFieldResults;
use Reliv\ValidationRat\Api\Validator\Validate;
use Reliv\ValidationRat\Api\Validator\ValidateByStrategy;
use Reliv\ValidationRat\Exception\ValidateApiInvalid;
use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRat\Model\ValidationResultFieldsBasic;
use Reliv\ArrayProperties\Property;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsByStrategy implements ValidateFields
{
    const CODE_UNRECOGNIZED_FIELD = 'unrecognized-field';

    const OPTION_FIELD_VALIDATORS = 'field-validators';
    const OPTION_INVALID_CODE = 'code-invalid';

    const DEFAULT_INVALID_CODE = 'invalid';

    protected $serviceContainer;
    protected $validate;
    protected $defaultInvalidCode;

    /**
     * @param ContainerInterface $serviceContainer
     * @param ValidateByStrategy $validate
     * @param string             $defaultInvalidCode
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        ValidateByStrategy $validate,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->validate = $validate;
        $this->defaultInvalidCode = $defaultInvalidCode;
    }

    /**
     * Validation Config Example
     * [
     *  '{field-name}' => [
     *   'validator' => '{Validate or ValidateFields}',
     *   'options' => [],
     *  ]
     * ]
     *
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Reliv\ValidationRat\Exception\ValidateApiInvalid
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        Property::assertNotEmpty(
            $options,
            static::OPTION_FIELD_VALIDATORS
        );

        $fieldValidatorConfig = Property::getArray(
            $options,
            static::OPTION_FIELD_VALIDATORS
        );

        $fieldResults = $this->getFieldValidationResults(
            $fields,
            $fieldValidatorConfig
        );

        $valid = IsValidFieldResults::invoke(
            $fieldResults,
            $options
        );

        $code = BuildCode::invoke(
            $valid,
            $options,
            $this->defaultInvalidCode
        );

        return new ValidationResultFieldsBasic(
            $valid,
            $code,
            [],
            $fieldResults
        );
    }

    /**
     * @param array $fields
     * @param array $fieldValidatorConfig
     * @param array $fieldResults
     *
     * @return array
     * @throws ValidateApiInvalid
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    protected function getFieldValidationResults(
        array $fields,
        array $fieldValidatorConfig = [],
        array $fieldResults = []
    ): array {
        foreach ($fields as $fieldName => $value) {
            $fieldResults[$fieldName] = $this->validate(
                $fieldName,
                $value,
                $fieldValidatorConfig
            );
        }

        return $fieldResults;
    }

    /**
     * @param string $validateApiServiceName
     *
     * @return mixed|Validate|ValidateFields
     * @throws ValidateApiInvalid
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getValidateApi(
        string $validateApiServiceName
    ) {
        if (!$this->serviceContainer->has($validateApiServiceName)) {
            throw new ValidateApiInvalid(
                'Validation service not found: (' . $validateApiServiceName . ')'
            );
        }

        /** @var Validate|ValidateFields $validateApi */
        $validateApi = $this->serviceContainer->get($validateApiServiceName);

        if (!$validateApi instanceof Validate && !$validateApi instanceof ValidateFields) {
            throw new ValidateApiInvalid(
                'Validation service must be instance of: (' . Validate::class . ')'
                . ' or instance of: (' . ValidateFields::class . ')'
                . ' got: (' . get_class($validateApi) . ')'
            );
        }

        return $validateApi;
    }

    /**
     * @param string $fieldName
     * @param mixed  $value
     * @param array  $fieldValidatorConfig
     *
     * @return ValidationResult
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Reliv\ValidationRat\Exception\ValidateApiInvalid
     * @throws \Reliv\ArrayProperties\Exception\ArrayPropertyException
     */
    protected function validate(
        string $fieldName,
        $value,
        array $fieldValidatorConfig
    ): ValidationResult {
        if (!array_key_exists($fieldName, $fieldValidatorConfig)) {
            return BuildFieldNotRecognizedResult::invoke(
                $fieldName
            );
        }

        $validatorConfig = Property::getArray(
            $fieldValidatorConfig,
            $fieldName,
            []
        );

        $validateApiServiceName = Property::getRequired(
            $validatorConfig,
            ValidateByStrategy::OPTION_VALIDATE_API
        );

        $validateApiOptions = Property::getRequired(
            $validatorConfig,
            ValidateByStrategy::OPTION_VALIDATE_API_OPTIONS
        );

        $validateApi = $this->getValidateApi(
            $validateApiServiceName
        );

        return $validateApi->__invoke(
            $value,
            $validateApiOptions
        );
    }
}
