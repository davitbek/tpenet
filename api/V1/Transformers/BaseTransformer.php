<?php

namespace Api\V1\Transformers;

use LaraAreaTransformer\Transformer;

class BaseTransformer extends Transformer
{
    /**
     * Filter the given data, removing any optional values.
     *
     * @param  array  $data
     * @return array
     */
    protected function filterByAttribute($data, $resource)
    {
        $data = array_intersect_key($resource->getAttributes(), $data); // @TODO
        $index = -1;

        foreach ($data as $key => $value) {
            $index++;

            if (is_array($value)) {
                $data[$key] = $this->filter($value);

                continue;
            }

            if (is_numeric($key) && $value instanceof MergeValue) {
                return $this->mergeData(
                    $data, $index, $this->filter($value->data),
                    array_values($value->data) === $value->data
                );
            }

            if ($value instanceof self && is_null($value->resource)) {
                $data[$key] = null;
            }
        }

        return $this->removeMissingValues($data);
    }


}
