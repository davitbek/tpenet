<?php

namespace LaraAreaModel\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait ModelTrait
{
    use ResourceTrait, CacheableAttributes;

    /**
     * @var array
     */
    protected $_paginateable = [];

    /**
     * @var array
     */
    protected $paginateable = [];

    /**
     * decsriptive attribute
     * @var
     */
    protected $descriptiveAttribute;

    /**
     * Get Main attribute name best describe table
     *
     * @return mixed
     */
    public function getDescriptiveAttributeName()
    {
        return $this->descriptiveAttribute = $this->descriptiveAttribute ?? $this->getKeyName();
    }

    /**
     * Get Main attribute value best describe table
     *
     * @return mixed
     */
    public function getMainDescriptiveAttribute()
    {
        return $this->attributes[$this->descriptiveAttribute];
    }

    /**
     * Return permitted type actions and related configs
     *
     * @param $group
     * @return array
     */
    public function getActions($group = self::PAGINATE_GROUP)
    {
        return $this->actions ?  [
            'list' => $this->processActions(),
            'is_separate' => false,
            'label' => 'Actions'
        ]
            : [];
    }

    /**
     * @return array
     */
    protected function processActions()
    {
        $data = [];
        $config = config('laraarea-view.actions');
        foreach ($this->actions as $action => $actionData) {
            if (is_string($actionData)) {
                $action = $actionData;
                $actionData = [];
            }
            $actionData['action'] = $action;

            $actionConfig = $config[$actionData['action']] ?? [];
            if(empty($actionConfig['icon'])) {
                $actionData['label'] = $actionData['label'] ?? ucfirst($actionData['action']);
            } else {
                $actionData['icon'] = $actionConfig['icon'];
            }

            if(! empty($actionConfig['method'])) {
                $actionData['method'] = $actionConfig['method'];
            }

            $data[] = $actionData;
        }
        return $data;
    }

    /**
     * Make response well structured format
     *
     * @param bool $selectColumns
     * @param $filter
     * @return array|\Illuminate\Support\Collection
     */
    public function getPaginateAble($selectColumns = true, $filter = self::PAGINATE_GROUP)
    {
        $_paginateAble = $this->processPaginateAble();
        $paginateAble = $_paginateAble[$filter] ?? [];
        $paginateAble = collect($paginateAble);
        if ($selectColumns) {
            $columns = $paginateAble->where('is_real_column', true)->pluck('column')->all();
            if (! in_array($this->getKeyName(), $columns)) {
                array_unshift($columns, $this->getKeyName());
            }
            $withCount = $paginateAble->where('with_count', true)->pluck('relation')->all();
            $with = $paginateAble->where('with', true)->pluck('with')->all();

            $orderBy = $paginateAble->where('order_by', '!=', '')->pluck('order_by', 'column')->all();
            return compact('columns', 'withCount', 'with', 'orderBy');
        }

        return $paginateAble->where('is_show', true);
    }

    /**
     * process model config data
     *
     * @return array
     */
    public function processPaginateAble()
    {
        if (! empty($this->_paginateable)) {
            return $this->_paginateable;
        }

        $this->paginateable = $this->paginateable ?: array_merge(['id'], $this->getFillable());
        foreach ($this->paginateable as $attribute => $data) {
            if (is_numeric($attribute) && ! is_array($data)) {
                $attribute = $data;
                $data = [];
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

            if (! key_exists('is_real_column', $data)) {
                $data['is_real_column'] = true;
            }

            if (! key_exists('is_show', $data)) {
                $data['is_show'] = true;
            }


            if (! key_exists('is_html', $data)) {
                $data['is_html'] = false;
            }

            if (key_exists('with_count', $data) ) {
                $data['is_real_column'] = false;
                if ( ! key_exists('relation', $data)) {
                    $data['relation'] = Str::replaceLast('_count', '', $data['attribute']);
                }
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
     * Get small image as html
     *
     * @param $attribute
     * @param string $width
     * @param string $height
     * @param string $error
     * @return string
     */
    public function getImageHtmlBy($attribute, $width = '50', $height = '50', $error = 'No Image')
    {
        $url = $this->getUrlByAttribute($attribute);
        if ($url) {
            return '<img height="' . $height . 'px" width="' . $width . 'px" src="' . $url . '">';
        }

        return $error;
    }
}
