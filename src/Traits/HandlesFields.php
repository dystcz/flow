<?php

namespace Dystcz\Process\Traits;

use Dystcz\Process\Contracts\DataFieldContract;
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
            ->merge($this->process()->data);

        // Find media and set value if uploaded
        $media = $data
            ->filter(fn ($field) => $field instanceof MediaFieldContract)
            ->map(function ($field) {
                /** @var Media|null $media */
                $media = $this->process()->getFirstMedia($field->key);

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
    protected function saveFields(ProcessRequest $request): void
    {
        $this->saveDataFields($request);
        $this->saveMediaFields($request);
    }

    /**
     * Split fields into groups.
     *
     * @param array $data
     * @return Collection
     */
    protected function getFieldGroups(array $fields): Collection
    {
        $fields = $fields ?? $this->fields();

        return Collection::make($fields)
            ->groupBy(function (Field $field) {
                return match (true) {
                    $field instanceof DataFieldContract => 'data',
                    $field instanceof MediaFieldContract => 'media',
                    default => 'other',
                };
            });
    }

    /**
     * Get fields by group.
     *
     * @param ProcessRequest $request
     * @param string $group
     * @return Collection
     * @throws BadRequestException
     */
    protected function getFieldGroup(ProcessRequest $request, string $group): Collection
    {
        return $this->getFieldGroups($this->setFieldValuesFromRequest($request))->get($group) ?? new Collection();
    }
    /**
     * Get fields that are stored in process data.
     *
     * @param ProcessRequest $request
     * @return Collection
     * @throws BadRequestException
     */
    protected function getDataFields(ProcessRequest $request): Collection
    {
        return $this->getFieldGroup($request, 'data');
    }

    /**
     * Get fields that are stored as media.
     *
     * @param ProcessRequest $request
     * @return Collection
     * @throws BadRequestException
     */
    protected function getMediaFields(ProcessRequest $request): Collection
    {
        return $this->getFieldGroup($request, 'media');
    }

    /**
     * Save field data.
     *
     * @param ProcessRequest $request
     * @return void
     */
    protected function saveDataFields(ProcessRequest $request): void
    {
        $this->process()->update(['data' => $this->getDataFields($request)->all()]);
    }

    /**
     * Save media.
     *
     * @param ProcessRequest $request
     * @return void
     */
    protected function saveMediaFields(ProcessRequest $request): void
    {
        $this->getMediaFields($request)->each(function ($field) {
            if (!$field->getValue()) {
                return;
            }

            $this->process()->saveMedia($field);
        });
    }

    /**
     * Check if all fields are saved.
     *
     * @return bool
     */
    public function allFieldsSaved(): bool
    {
        $fieldGroups = $this->getFieldGroups($this->fields());

        return $this->allDataFieldsSaved($fieldGroups->get('data')?->all() ?? [])
            && $this->allMediaFieldsSaved($fieldGroups->get('media')?->all() ?? []);
    }

    /**
     * Determine if all data fields are saved.
     *
     * @param array $fields
     * @return bool
     */
    public function allDataFieldsSaved(ProcessRequest $request): bool
    {
        return array_reduce(
            $this->getDataFields($request)->all(),
            function ($carry, $field) {
                // If field is not required, skip
                if ($carry && !in_array('required', $field->getRules())) {
                    return $carry;
                }

                // Check if data is filled
                if ($this->process()->data->get($field->key)?->value === null) {
                    $carry = false;

                    return $carry;
                }

                return $carry;
            },
            true
        );
    }

    /**
     * Determine if all media fields are saved.
     *
     * @param array $fields
     * @return bool
     */
    public function allMediaFieldsSaved(ProcessRequest $request): bool
    {
        return array_reduce(
            $this->getMediaFields($request)->all(),
            function ($carry, $field) {
                // If field is not required, skip
                if ($carry && !in_array('required', $field->getRules())) {
                    return $carry;
                }

                // Check if data is filled
                if ($this->process()->getFirstMedia($field->getConfigValue('collection_name')) === null) {
                    $carry = false;

                    return $carry;
                }

                return $carry;
            },
            true
        );
    }
}
