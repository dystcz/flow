<?php

declare(strict_types=1);

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Fields\Fields\Field;
use Dystcz\Flow\Domain\Flows\Enums\ValidationStrategy;
use Dystcz\Flow\Domain\Flows\Facades\Flow;
use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Validator as ValidationValidator;

trait HandlesValidation
{
    /**
     * Validate flow step handling.
     *
     * @throws ValidationException
     */
    public static function validateStep(FlowRequest $request): array
    {
        return static::validator($request)
            ->validate();
    }

    /**
     * Create a validator instance for flow step handling.
     *
     * @return ValidationValidator
     */
    public static function validator(FlowRequest $request)
    {
        return Validator::make($request->all(), static::rules($request))
            ->setCustomMessages(static::messages($request))
            ->after(function ($validator) use ($request) {
                static::afterValidation($request, $validator);
            });
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public static function rules(FlowRequest $request): array
    {
        if (Config::get('flow.testing')) {
            return [];
        }

        return Collection::make(static::newHandler($request->step)->combineFields())->mapWithKeys(
            fn (Field $field) => [
                $field->key => array_filter(
                    $rules = $field->getRules(),
                    function (string $rule) use ($rules) {
                        $strict = ValidationStrategy::STRICT;
                        $loose = ValidationStrategy::LOOSE;

                        // Filter out strict and loose rules
                        if (in_array($rule, [$strict->value, $loose->value])) {
                            return false;
                        }

                        // Override strict validation strategy for field
                        // Strict rule has priority over loose rule
                        if (in_array($strict->value, $rules)) {
                            return true;
                        }

                        // Loose validation strategy or loose override for field
                        if (Flow::validationStrategy() === $loose || in_array($loose->value, $rules)) {
                            // Filter out required* rules and loose rule
                            return ! Str::of($rule)->startsWith('required');
                        }

                        return true;
                    }
                ),
            ]
        )->toArray();
    }

    /**
     * Get custom messages for validator errors.
     */
    public static function messages(FlowRequest $request): array
    {
        return Collection::make(static::newHandler($request->step)->combineFields())->mapWithKeys(
            fn ($field) => Collection::make($field->getMessages())->mapWithKeys(
                fn ($message, $rule) => ["{$field->key}.{$rule}" => $message]
            )->toArray()
        )->toArray();
    }

    /**
     * Handle after validation.
     */
    public static function afterValidation(FlowRequest $request, ValidatorContract $validator): void
    {
    }
}
