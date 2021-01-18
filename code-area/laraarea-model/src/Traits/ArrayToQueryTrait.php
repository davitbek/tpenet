<?php

namespace LaraAreaModel\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait ArrayToQueryTrait
{
    /**
     * @var array
     */
    protected $aliases = [];

    /**
     * @var array
     */
    protected $routeAliases = [];

    /**
     * @var array
     */
    protected $keepWrapVisible = [];

    /**
     * @var array
     */
    protected $wrap = [];

    /**
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|Builder|Builder[]|\Illuminate\Database\Eloquent\Collection|Model|int|mixed|object|null
     */
    public function getByArray($data)
    {
        $data = $this->fixAliasData($data);
        /**
         * @var $query Builder
         */
        $query = $this->getQueryByArray($data);
        if (!empty($data['first']) || (empty($data['all']) && !empty($data['limit']) && 1 == $data['limit'])) {
            return $query->first();
        }

        if (!empty($data['sum'])) {
            return $query->sum($data['sum']);
        }

        if (!empty($data['count'])) {
            return $query->count();
        }

        if (!empty($data['avg'])) {
            return $query->avg($data['avg']);
        }

        if (!empty($data['aggregate'])) {
            return $query->aggregate($data['aggregate']);
        }

        if (!empty($data['paginate'])) {
            $perPage = $data['per_page'] ?? 15;
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    /**
     * Get first item base array config data
     *
     * @param $id
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function firstByArray($id, $data)
    {
        $this->fixAliasData($data);
        $query = $this->getQueryByArray($data);
        return $query->find($id);
    }

    /**
     * Get all items base array config data
     * Also has possibility to get single item
     * limited items
     * Can pass all chainable methods as array
     *
     * @param $id
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model|null
     */
    public function findByArray($id, $data)
    {
        $this->fixAliasData($data);
        $query = $this->getQueryByArray($data);
        return $query->find($id);
    }

    /**
     * For make code more shorter or custom you can define aliases
     *
     * @param $data
     * @return array
     */
    public function fixAliasData($data)
    {
        if (!empty($data['alias'])) {
            $routeAlias = $this->routeAliases[$data['alias']];
            $data = array_merge($routeAlias, $data);
        }

        return $data;
    }

    /**
     * Get eloquent query by array
     *
     * @param $data
     * @param null $query
     * @return |null
     */
    public function getQueryByArray($data, $query = null)
    {
        $query = $query ?? $this->newQuery();
        $this->queryColumns($query, $data);
        $this->querySelectRaw($query, $data);
        $this->queryWhere($query, $data);
        $this->queryWhereDate($query, $data);
        $this->queryWhereHas($query, $data);
        $this->queryHas($query, $data);
        $this->queryWhereIn($query, $data);
        $this->queryLimit($query, $data);
        $this->queryLatest($query, $data);
        $this->queryOrderBy($query, $data);
        $this->queryGroupBy($query, $data);
        $this->queryWithCount($query, $data);
        $this->queryWith($query, $data);

        return $query;
    }

    /**
     * Set eloquent query where criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryWhere($query, $data)
    {
        // @TODO improve
        $where = $this->getDataBy($data, 'where');

        if ($where) {
            $query->where($where);
        }

        $whereNested = $this->getDataBy($data, 'where_nested');
        foreach ($whereNested as $callback) {
            $query->where($callback);
        }

        return $query;
    }

    /**
     * Set eloquent query whereDate criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryWhereDate($query, $data)
    {
        // @TODO improve
        $whereDate = $this->getDataBy($data, 'where_date');

        if ($whereDate) {
            foreach ($whereDate as $key => $value) {
                $query->whereDate($key, $value);
            }
        }

        return $query;
    }

    /**
     * Set eloquent query has criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryHas($query, $data)
    {
        // @TODO improve
        $whereHas = $this->getDataBy($data, 'has');

        if ($whereHas) {
            $whereHas = is_string($whereHas) ? [$whereHas] : $whereHas;
            foreach ($whereHas as $relation) {
                $query->has($relation);
            }
        }

        return $query;
    }

    /**
     * Set eloquent query whereHas criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryWhereHas($query, $data)
    {
        // @TODO improve
        $whereHas = $this->getDataBy($data, 'where_has');

        if ($whereHas) {
            foreach ($whereHas as $relation => $conditions) {
                $query->whereHas($relation, function ($q) use ($conditions){
                    $this->getQueryByArray($conditions, $q);
                });
            }
        }

        return $query;
    }

    /**
     * Set eloquent query whereIn criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryWhereIn($query, $data)
    {
        // @TODO improve
        $whereIn = $this->getDataBy($data, 'where_in');

        if ($whereIn) {
            foreach ($whereIn as $key => $values) {
                $values = is_string($values) ? [$values] : $values;
                $query->whereIn($key, $values);
            }
        }

        return $query;
    }

    /**
     * Set eloquent query orderBy criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryOrderBy($query, $data)
    {
        $orderByRaw =  $this->getDataBy($data, 'order_by_raw');
        foreach ($orderByRaw as $value) {
            $query->orderByRaw($value);
        }
        // @TODO improve
        $orderBy = $this->getDataBy($data, 'order_by');
        $orderBy = (array) $orderBy;
        if ($orderBy) {
            foreach ($orderBy as $key => $sort) {
                if (is_numeric($key)) {
                    $query->orderBy($sort);
                } else {
                    $query->orderBy($key, $sort);
                }
            }
        }

        return $query;
    }

    /**
     * Set eloquent query limit criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryLimit($query, $data)
    {
        // @TODO improve
        $limit = $this->getDataBy($data, 'limit');
        if ($limit) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Set eloquent query latest criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryLatest($query, $data)
    {
        // @TODO improve
        $latest = $this->getDataBy($data, 'latest');
        if ($latest) {
            $query->latest();
        }

        return $query;
    }

    /**
     * Set eloquent query groupBy criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryGroupBy($query, $data)
    {
        // @TODO improve
        $groupBy = $this->getDataBy($data, 'group_by');
        $groupBy = (array) $groupBy;
        if ($groupBy) {
            foreach ($groupBy as $key => $col) {
                $query->groupBy($col);
            }
        }

        return $query;
    }

    /**
     * Set eloquent query withCount criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryWithCount($query, $data)
    {
        // @TODO improve
        $withCount = $this->getDataBy($data, 'with_count');
        if ($withCount ) {
            $query->withCount($withCount);
        }
        return $query;
    }

    /**
     * Set eloquent query with criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function queryWith($query, $data)
    {
        // @TODO improve
        $_with = $this->getDataBy($data, 'with');
        if (empty($_with)) {
            return $query;
        }

        $_with = is_string($_with) ? [$_with] : $_with;

        $with = [];
        foreach ($_with as $relation => $options) {
            if (is_numeric($relation)) {
                $with[] = $options;
            } else {
                if (is_callable($options)) {
                    $with[$relation] = $options;
                    continue;
                }
                if (is_string($options)) {
                    $options = ['select' => $options];
                }

                $with[$relation] = function ($q) use ($options){
                    $this->getQueryByArray($options, $q);
                };
            }
        }
        $query->with($with);
        return $query;
    }

    /**
     * Set eloquent query select criteria by array
     *
     * @param $query
     * @param $data
     */
    public function queryColumns($query, $data)
    {
        $select = $this->getDataBy($data, 'select');
        $columns = $this->getDataBy($data, 'columns');
        $columns = parse_array($columns);
        $select = parse_array($select);
        $columns = array_merge($columns, $select);

        if (!empty($columns)) {
            $columns = (array) $columns;
            $wrapColumns = array_intersect_key($this->wrap, array_flip($columns));
            $this->wrapConfig = $wrapColumns;

            if (method_exists($this, 'getMutatedAttributes')) {
                $mutated = $this->getMutatedAttributes();
                $pruneMutated = array_diff($mutated, $this->getFillable());
                $columns = array_diff($columns, $pruneMutated, array_keys($wrapColumns));
            } else {
                $columns = array_diff($columns, array_keys($wrapColumns));
            }
            $wrapColumns  = Arr::flatten($wrapColumns);

            $columns = array_merge($columns, $wrapColumns);
            foreach ($columns as $i => $column) {
                $columns[$i] = $query->qualifyColumn($column);
            }
            array_unshift($columns, $query->qualifyColumn($query->getModel()->getKeyName()));
            $columns = array_unique($columns);
            $query->select($columns);
        }
    }

    /**
     * Set eloquent query selectRaw criteria by array
     *
     * @param $query
     * @param $data
     * @return mixed
     */
    public function querySelectRaw($query, $data)
    {
        // @TODO permission
        $selectRaw = $this->getDataBy($data, 'select_raw');
        if (empty($selectRaw)) {
           return $query;
        }
        $query->selectRaw($selectRaw);
        return $query;
    }

    /**
     * Helper function
     *
     * @param $data
     * @param $key
     * @return array
     */
    protected function getDataBy($data, $key)
    {
        return $data[$key] ?? $this->getDataByAlias($data, $key);
    }

    /**
     * Helper function
     *
     * @param $data
     * @param $key
     * @return array
     */
    protected function getDataByAlias($data, $key)
    {
        if (empty($this->aliases[$key])) {
            return [];
        }

        return $data[$this->aliases[$key]] ?? [];
    }

    /**
     * Change toArray if need make some virtual cols in include in response
     * or rename one attribute to other
     *
     * @return array
     */
    public function toArray()
    {
        if (empty($this->wrap)) {
            return parent::toArray(); // TODO: Change the autogenerated stub
        }

        $hidden = [];
        $append = [];
        $mutated = $this->getMutatedAttributes();
        foreach ($this->wrap as $wrap => $_hidden) {
            if (is_array($_hidden)) {
                if(empty(array_diff($_hidden, array_keys($this->attributes)))) {
                    $append[] = $wrap;
                    $hidden = array_merge($hidden, $_hidden) ;
                }
            } else {
                if (isset($this->attributes[$_hidden])) {
                    if (in_array($wrap, $mutated)) {
                        $append[] = $wrap;
                    } else {
                        $this->attributes[$wrap] = $this->attributes[$_hidden];
                    }
                    $hidden[] = $_hidden;
                }
            }
        }

        $hidden = array_diff($hidden, $this->keepWrapVisible);
        $this->makeHidden($hidden);
        $this->append($append);
        return parent::toArray(); // TODO: Change the autogenerated stub
    }

}