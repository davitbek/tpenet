<?php

namespace LaraAreaAdmin\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use LaraAreaModel\AreaModel;
use Traits\Models\UploadableTrait;

/**
 * Class AdminModel
 * @package LaraAreaAdmin\Models
 */
class AdminModel extends AreaModel
{
    use UploadableTrait;

    protected $actions = [
        'edit',
        'show',
        'destroy'
    ];

    /**
     * @return array
     */
    public function processPaginateAble()
    {
        if (!empty($this->_paginateable)) {
            return $this->_paginateable;
        }

        $this->paginateable = $this->paginateable ?: array_merge(['id'], $this->getFillable());
        foreach ($this->paginateable as $attribute => $data) {
            if (is_numeric($attribute) && !is_array($data)) {
                $attribute = $data;
                if (in_array($attribute, $this->getUploadable())) {
                    $attr = str_replace('_path', '', $attribute);
                    $data = [
                        'is_html' => true,
                        'attribute' => $attr,
                        'label' => humanize($attr)
                    ];
                } else {
                    $data = [];
                }
            }

            if (empty($data['attribute'])) {
                $data['attribute'] = $attribute;
            }

            if (empty($data['column'])) {
                $data['column'] = $attribute;
            }

            if (empty($data['label'])) {
                $data['label'] = humanize($data['attribute']);
            }

            if (!key_exists('is_real_column', $data)) {
                $data['is_real_column'] = true;
            }

            if (!key_exists('is_show', $data)) {
                $data['is_show'] = true;
            }


            if (!key_exists('is_html', $data)) {
                $data['is_html'] = false;
            }

            if (key_exists('with_count', $data)) {
                $data['is_real_column'] = false;
                if (!key_exists('relation', $data)) {
                    $data['relation'] = Str::replaceLast('_count', '', $data['attribute']);
                }
            }

            if (!empty($data['search']) || !empty($data['searchDetails'])) {
                $data['searchDetails'] = $this->processSearchDetails($data);
            }
            $group = defined('self::PAGINATE_GROUP') ? self::PAGINATE_GROUP : 'index';
            $groups = Arr::pull($data, 'group', $group);
            $groups = (array)$groups;
            foreach ($groups as $group) {
                $this->_paginateable[$group][] = $data;
            }
        }

        return $this->_paginateable;
    }

    /**
     * @param $data
     * @return array
     */
    protected function processSearchDetails($data)
    {
        $details = [
            'formMethod' => $data['searchDetails']['formMethod'] ?? 'adText',
            'operation' => $data['searchDetails']['operation'] ?? 'like',
            'column' => $data['column'],
            'order' => $data['searchDetails']['order'] ?? 1,
            'options' => [
                'label' => $data['label']
            ],
        ];

        if (!empty($data['searchDetails']['composer'])) {
            $details['composer'] = $data['searchDetails']['composer'];
            $details['items'] = $data['searchDetails']['items'] ?? Str::camel(Str::plural(str_replace('_id', '', $data['column'])));
            $details['formMethod'] = $data['searchDetails']['formMethod'] ?? 'adSelect';
            $details['operation'] = $data['searchDetails']['operation'] ?? 'whereIn';
        }

        return $details;
    }
}
