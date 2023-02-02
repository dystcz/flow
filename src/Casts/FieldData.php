<?php

namespace Dystcz\Process\Casts;

use Dystcz\Process\Contracts\FieldContract;
use Dystcz\Process\Exceptions\FieldTypeException;
use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Collection;

class FieldData implements Castable
{
    /**
     * Get the caster class to use when casting from / to this cast target.
     *
     * @param  array  $arguments
     * @return object|string
     */
    public static function castUsing(array $arguments)
    {
        return new class() implements CastsAttributes
        {
            public function get($model, $key, $value, $attributes)
            {
                if (!isset($attributes[$key])) {
                    return;
                }

                $data = json_decode($attributes[$key], true);

                $returnData = new Collection();

                foreach ($data as $key => $item) {
                    if (!class_exists($item['field_type'])) {
                        continue;
                    }
                    if (!in_array(FieldContract::class, class_implements($item['field_type']))) {
                        throw new FieldTypeException('This field type is not supported.');
                    }

                    $returnData->put(
                        $key,
                        new $item['field_type'](
                            key: $key,
                            name: $item['name'],
                            value: $item['value'],
                        )
                    );
                }

                return $returnData;
            }

            public function set($model, $key, $value, $attributes)
            {
                $data = [];

                foreach ($value ?? [] as $field) {
                    $data[$field->key] = [
                        'field_type' => get_class($field),
                        'name' => $field->name,
                        'value' => $field->getValue(),
                    ];
                }

                return [$key => json_encode($data)];
            }
        };
    }
}
