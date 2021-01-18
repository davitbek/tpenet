<?php

namespace Api\V1\Services;

use Api\V1\Models\BettingDictionary;

class BettingDictionaryService extends BaseService
{
    /**
     * @var BettingDictionary
     */
    protected $model;

    /**
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all()
    {
        $lang = get_auth_locale();

        $translationsData = [
            'columns' => [
                'name',
                'slug',
                'description',
                'parent_id',
            ],
            'where' => ['lang' => $lang]
        ];

        $items = $this->model->select('id', 'name', 'slug', 'description')
            ->where([
                ['parent_id',  '=', null]
            ])
            ->with(['translations' => function ($query) use ($translationsData) {
                $query->select($translationsData['columns'])
                    ->where($translationsData['where']);
            }])
            ->get();

        foreach ($items as $item) {
            $item->translate();
        }

        $items = $items->groupBy(function ($item, $key) {
            return strtoupper(substr($item['name_translated'], 0, 1));
        });
        $items = $items->sortKeys();
        return $items;
    }

    public function findBySlug($value, $columns = ['*'], $column = 'id', $with = [])
    {
        $lang = get_auth_locale();
        $translationsData = [
            'columns' => [
                'name',
                'slug',
                'description',
                'parent_id',
            ],
            'where' => ['lang' => $lang]
        ];

        return $this->model->relateds()->where('slug', $value) ->with(['translations' => function ($query) use ($translationsData) {
            $query->select($translationsData['columns'])
                ->where($translationsData['where']);
        }])->first($columns);
    }
}
