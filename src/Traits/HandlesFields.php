<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Contracts\MediaFieldContract;
use Dystcz\Process\Fields\Field;
use Dystcz\Process\Http\Requests\ProcessRequest;
use Illuminate\Support\Collection;
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
    public function setFieldValuesFromRequest(ProcessRequest $request): array
    {
        return array_map(
            fn ($field) => $field->setValue($request->get($field->key)),
            $this->fields()
        );
    }

    /**
     * Set field values from process.
     *
     * @param ProcessRequest $request
     * @return array
     * @throws BadRequestException
     */
    public function setFieldValuesFromProcess(ProcessRequest $request): array
    {
        // Merge fields with process data
        $data = Collection::make($this->fields())
            ->mapWithKeys(fn ($field) => [$field->key => $field])
            ->merge($this->getProcess()->data);

        // Find media and set value if uploaded
        $media = $data
            ->filter(fn ($field) => $field instanceof MediaFieldContract)
            ->map(function ($field) {
                /** @var Media|null $media */
                $media = $this->getProcess()->getFirstMedia($field->key);

                if (!$media) {
                    return $field->setValue(null);
                }

                $field->setValue([
                    'id' => $media->id,
                    'file_name' => $media->file_name,
                    'path' => "{$media->id}/{$media->file_name}",
                ]);
            });

        // Merge filled media with filled data
        return $data->merge($media)->all();
    }

    /**
     * Save field data.
     *
     * @param array $data
     * @return void
     */
    protected function saveFieldData(array $data): void
    {
        $this->saveFieldDataToAttributes(
            array_filter($data, fn (Field $field) => $field->saveToAttributes)
        );

        $this->saveMedia(
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
     * Save media.
     *
     * @param array<Field> $data
     * @return void
     * @throws BindingResolutionException
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     * @throws DiskDoesNotExist
     * @throws MassAssignmentException
     */
    protected function saveMedia(array $data): void
    {
        foreach ($data as $field) {
            $this->getProcess()->saveMedia($field);
        }
    }
}
