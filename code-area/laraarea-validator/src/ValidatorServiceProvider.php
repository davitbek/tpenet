<?php

namespace LaraAreaValidator;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{

    /**
     * Register extended Rules
     *
     * @param array $extendedClasses
     */
    public function bootExtendedRules($extendedClasses = [])
    {
        foreach ($extendedClasses as $class) {
            $rule = (new $class);
            Validator::extend($rule->getRule(), $class, $rule->message());
        }
    }

    /**
     * Alias method for extend new rule
     *
     * @param $name
     * @param $callback
     */
    protected function extend($name, $callback)
    {
        Validator::extend($name, $callback);
    }
}
