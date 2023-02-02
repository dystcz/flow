<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Http\Requests\ProcessRequest;
use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as ValidationValidator;

trait HandlesValidation
{
    public static function validateProcess(ProcessRequest $request)
    {
        static::validator($request)
            ->validate();
    }

    /**
     * Create a validator instance for process handling.
     *
     * @param ProcessRequest $request
     * @return ValidationValidator
     */
    public static function validator(ProcessRequest $request)
    {
        return Validator::make($request->all(), static::rules($request))
            ->setCustomMessages(static::messages($request))
            ->after(function ($validator) use ($request) {
                static::afterValidation($request, $validator);
            });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public static function rules(ProcessRequest $request): array
    {
        return Collection::make($request->getHandler()->fields())->mapWithKeys(
            fn ($field) => [$field->key => $field->getRules()]
        )->toArray();
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public static function messages(ProcessRequest $request): array
    {
        return Collection::make($request->getHandler()->fields())->mapWithKeys(
            fn ($field) => Collection::make($field->getMessages())->mapWithKeys(
                fn ($message, $rule) => ["{$field->key}.{$rule}" => $message]
            )->toArray()
        )->toArray();
    }

    /**
     * Handle after validation.
     *
     * @param ProcessRequest $request
     * @param ValidatorContract $validator
     * @return void
     */
    public static function afterValidation(ProcessRequest $request, ValidatorContract $validator): void
    {
    }
}
