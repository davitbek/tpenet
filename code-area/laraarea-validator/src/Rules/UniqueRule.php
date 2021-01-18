<?php

namespace LaraAreaValidator\Rules;

use Illuminate\Validation\Validator;

class UniqueRule extends CustomRule
{
    /**
     * @var string
     */
    protected $rule = 'uniq';

    /**
     * @param $attribute
     * @param $value
     * @param $parameters
     * @param Validator $validator
     * @return bool
     */
    public function validate($attribute, $value, $parameters, Validator $validator)
    {
        if (!isset($value)) {
            return true;
        }

        list($query, $primaryKey) = $this->getQueryAndKey($parameters);

        $data = $validator->getData();
        // set main uniqueness condition
        $query->where($attribute, '=', $value);
        // if primary key exists - set to NOT be equal (for updating case)
        if (!empty($data[$primaryKey])) {
            $query->where($primaryKey, '!=', $data[$primaryKey]);
        }

        // check conditional columns
        if (!empty($parameters)) {
            foreach ($parameters as $column) {
                if (isset($data[$column])) {
                    $query->where($column, '=', $data[$column]);
                }
            }
        }
        $count = $query->count();
        return ($count == 0) ? true : false;
    }

    /**
     * @param $parameters
     * @return array
     */
    protected function getQueryAndKey(&$parameters)
    {
        $modelParam = array_shift($parameters);
        if (empty($modelParam)) {
            throw new \InvalidArgumentException('Second parameter is required for unique validation');
        }

        if (class_exists($modelParam)) {
            $model = \App::make($modelParam);
            $primaryKey = $model->getKeyName();
            $query = $model->newQuery();
        } else {
            $primaryKey = 'id';
            $table = $modelParam;
            $query = \DB::table($table);
        }

        return [$query, $primaryKey];
    }

    /**
     * @return array|string|null
     */
    public function message()
    {
        return __('validation.unique');
    }

}
