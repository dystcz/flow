<?php

namespace Dystcz\Flow\Domain\Flows\Traits;

use Dystcz\Flow\Domain\Flows\Http\Requests\FlowRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
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
            fn ($field) => [$field->key => array_filter($field->getRules(), fn ($rule) => ! in_array($rule, ['optional']))]
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
