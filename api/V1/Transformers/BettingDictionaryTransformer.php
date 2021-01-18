<?php

namespace ApiX\Transformers;

namespace Api\V1\Transformers;

use Illuminate\Http\Request;

/**
 * Class BettingDictionaryTransformer
 * @package ApiX\Transformers
 */
class BettingDictionaryTransformer extends BaseTransformer
{
    public function transformAll($collection)
    {
        $result = [];

        foreach ($collection as $letter => $items) {
            $result[] = [
                'letter' => $letter,
                'items' => $this->transform($items)
            ];
        }

        return $result;
    }

    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $model->translate();

        $result = $model->toArray();

        $result['relatedDictionaries'] = $this->transform($model->related_dictionaries, $request, 'transformBasic');

        return $result;
    }

    /**
     * @param $item
     * @return mixed
     */
    public function transformBasic($item)
    {
        $item->translate();
        return $item->toArray();
    }
}
