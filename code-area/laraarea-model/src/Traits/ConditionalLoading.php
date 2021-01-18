<?php

namespace LaraAreaModel\Traits;

use Illuminate\Support\Str;

trait ConditionalLoading
{
    use ArrayToQueryTrait;

    /**
     * Load relation by condition
     *
     * @param $items
     * @param $relationName
     * @param $cases
     * @param null $valueColumn
     * @param null $idColumn
     */
    protected function loadConditional($items, $relationName, $cases, $valueColumn = null, $idColumn = null)
    {
        $valueColumn = $idColumn ?? Str::singular($relationName) . '_type';
        $idColumn = $idColumn ?? Str::singular($relationName) . '_id';

        foreach ($cases as $value => $classConfig) {
            $relatedItems = $items->where($valueColumn, $value);
            $relatedIds = $relatedItems->pluck($idColumn);

            $relations = $this->getRelations($classConfig, $relatedIds);
            $this->setRelations($relatedItems, $relations, $relationName, $idColumn);
        }
    }

    /**
     * Get relations by configs
     *
     * @param $classConfig
     * @param $relatedIds
     * @return mixed
     */
    protected function getRelations($classConfig, $relatedIds)
    {
        $class = $this->getClass($classConfig);
        $query = (new $class)->newQuery();
        if (is_array($classConfig)) {
            $data = $classConfig;
        } else {
            $data = [];
        }

        $data['where_in'][(new $class)->getKeyName()] = $relatedIds;
        $query = $this->getQueryByArray($data, $query);

        return $query->get();
    }

    /**
     * Helper function
     *
     * @param $classConfig
     * @return array|mixed
     */
    protected function getColumns($classConfig)
    {
        if (is_array($classConfig)) {
            return $classConfig['columns'];
        }

        return ['*'];
    }

    /**
     * Get class in array
     *
     * @param $classConfig
     * @return mixed
     */
    protected function getClass($classConfig)
    {
        if (is_array($classConfig)) {
            return $classConfig['class'];
        }

        return $classConfig;
    }

    /**
     * After getting relation set in relations attribute
     *
     * @param $items
     * @param $relations
     * @param $relationName
     * @param $idColumn
     */
    protected function setRelations($items, $relations, $relationName, $idColumn)
    {
        foreach ($relations as $relation) {
            foreach ($items->where($idColumn, $relation->getKey()) as $item) {
                $item->setRelation($relationName, $relation);
            }
        }
    }
}