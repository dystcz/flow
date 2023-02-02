<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Contracts\MediaFieldContract;
use Dystcz\Process\Fields\Field;
use Dystcz\Process\Http\Requests\ProcessRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

trait HandlesFields
{
    /**
     * Define process field.
     *
     * @return array
     */
    public function fields(): array
    {
        return [];
    }

    /**
     * Set field values from request.
     *
     * @param ProcessRequest $request
     * @return array
     * @throws BadRequestException
     */
    public static function setFieldValuesFromRequest(ProcessRequest $request): array
    {
        return array_map(function ($field) use ($request) {
            return $field->setValue($request->get($field->key));
        }, static::newHandler()->fields());
    }

    /**
     * Set field values from process.
     *
     * @param ProcessRequest $request
     * @return array
     * @throws BadRequestException
     */
    public static function setFieldValuesFromProcess(ProcessRequest $request): array
    {
        $handler = static::newHandler();

        return array_map(function ($field) use ($request) {
            return $field->setValue($request->get($field->key));
        }, static::newHandler()->fields());
    }

    protected function saveFieldData(array $data): void
    {
        $this->saveFieldDataToAttributes(
            array_filter($data, fn (Field $field) => $field->saveToAttributes)
        );

        $this->uploadMedia(
            array_filter($data, fn (Field $field) => $field instanceof MediaFieldContract && $field->getValue())
        );
    }

    /**
     * Save field data.
     *
     * @param array<Field> $data
     * @return void
     */
    protected function saveFieldDataToAttributes(array $data): void
    {
        $this->getProcess()->update(['data' => $data]);
    }

    /**
     * Upload media.
     *
     * @param array $data
     * @return void
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws DiskDoesNotExist
     * @throws MassAssignmentException
     */
    protected function uploadMedia(array $data): void
    {
        foreach ($data as $field) {
            $this->getProcess()->addMedia($field->getValue())->toMediaCollection($field->collection);
        }
    }
}
