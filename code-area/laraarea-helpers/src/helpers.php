<?php

use Illuminate\Support\Arr;

if (! function_exists('dd_if')) {
    /**
     * Dump the passed variables and end the script based last condition argument.
     *
     * @param  mixed
     * @return void
     */
    function dd_if(...$args)
    {
        $condition = array_pop($args);
        if ($condition) {
            dd(...$args);
        };
    }
}

if (! function_exists('if_dd')) {
    /**
     * Dump the passed variables and end the script based first condition argument.
     *
     * @param  mixed
     * @return void
     */
    function if_dd(...$args)
    {
        $condition = array_shift($args);
        if ($condition) {
            dd(...$args);
        };
    }
}

if (! function_exists('dd_json')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function dd_json(...$args)
    {
        dd(...$args);
    }
}

if (! function_exists('dd_pluck')) {
    /**
     * @param \Illuminate\Support\Collection | array $collection
     * @param $key
     * @param bool $toArray
     */
    function dd_pluck($collection, $key, $toArray = true)
    {
        if (is_array($collection)) {
            $collection = collect($collection);
        }
        $collection = $collection->pluck($key);
        $result = $toArray ? $collection->toArray() : $collection;
        dd($result);
    }
}

if (! function_exists('dd_prev')) {
    /**
     *
     */
    function dd_prev()
    {
        $info = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1];
        $object = $info['object'];
        $function = $info['function'];
        $args = $info['args'];
        dd($object->{$function}(...$args)); // @TODO
    }
}

if (! function_exists('dd_keys')) {
    /**
     * @param $data
     */
    function dd_keys($data)
    {
        if (is_array($data)) {
            dd(array_keys($data));
        }
        dd($data);
    }
}

if (! function_exists('if_dump')) {
    /**
     * Dump the passed variables and end the script based first condition argument.
     *
     * @param  mixed
     * @return void
     */
    function if_dump(...$args)
    {
        $condition = array_shift($args);
        if ($condition) {
            dump(...$args);
        };
    }
}

if (! function_exists('dump_if')) {
    /**
     * Dump the passed variables and end the script based last condition argument.
     *
     * @param  mixed
     * @return void
     */
    function dump_if(...$args)
    {
        $condition = array_pop($args);
        if ($condition) {
            dump(...$args);
        };
    }
}

if (! function_exists('show_bcrypt')) {
    /**
     * @param $password
     */
    function show_bcrypt($password)
    {
        dd(bcrypt($password));
    }
}

if (! function_exists('show_class_methods')) {
    /**
     * @param $class
     */
    function show_class_methods($class)
    {
        $methods = get_class_methods($class);
        sort($methods);
        dd($methods);
    }
}

if (! function_exists('show_class')) {
    /**
     * @param $object
     */
    function show_class($object)
    {
        dd(get_class($object));
    }
}

if (! function_exists('show_query')) {
    /**
     * @param bool $isDie
     */
    function show_query($isDie = false)
    {
        $data = DB::getQueryLog();
        foreach ($data as $datum) {
            $bindings = $datum['bindings'];
            array_walk($bindings, function (&$value) {
                $value  = is_string($value) ? '"' . $value . '"' : $value;
            });
            echo 'query: ' . sprintf(str_replace('?', '%s', $datum['query']), ...$bindings);
            echo '<br>';
            echo 'time: ' . ($datum['time'] / 1000) . ' sec';
            echo '<hr>';
        }
        if ($isDie) {
            die();
        }
    }
}

if (! function_exists('show_object_methods')) {
    /**
     * @param $object
     */
    function show_object_methods($object)
    {
        show_class_methods($object);
    }
}

if (! function_exists('show_object_vars')) {
    /**
     * @param $obj
     */
    function show_object_vars($obj)
    {
        $vars = get_object_vars($obj);
        ksort($vars);
        dd($vars);
    }
}

if (! function_exists('show_object_nested_vars')) {
    /**
     * @param $obj
     * @param bool $isDoted
     */
    function show_object_nested_vars($obj, $isDoted = true)
    {
        $vars = get_object_vars_recursive($obj, $isDoted);
        dd($vars);
    }
}

if (! function_exists('show_object_vars_methods')) {
    /**
     * @param $object
     * @param bool $showObj
     */
    function show_object_vars_methods($object, $showObj = false)
    {
        $vars = get_object_vars($object);
        ksort($vars);

        $methods = get_class_methods($object);
        sort($methods);

        if ($showObj) {
            $print = compact('object', 'vars', 'methods');
        } else {
            $print = compact('vars', 'methods');

        }
        dd($print);
    }
}

if (! function_exists('get_object_vars_recursive')) {
    /**
     * @param $object
     * @param bool $isDoted
     * @return array
     */
    function get_object_vars_recursive($object, $isDoted = true)
    {
        $result = _get_object_vars_recursive($object);
        return $isDoted ? Arr::dot($result) : $result;
    }
}


if (! function_exists('_get_object_vars_recursive')) {
    /**
     * @param $object
     * @return array
     */
    function _get_object_vars_recursive($object)
    {
        $result = [];
        $vars = get_object_vars($object);
        foreach ($vars as $var => $value) {
            if (is_object($value)) {
                $result[$var] = _get_object_vars_recursive($value); // @TODO
                continue;
            }

            if(! is_array($value)) {
                $result[$var] = $value;
                continue;
            }

            foreach ($value as $_value) {
                if (is_object($_value)) {
                    $result[$var][] = _get_object_vars_recursive($_value); // @TODO
                } else {
                    $result[$var] = $value;
                }
            }
        }

        return $result;
    }
}
