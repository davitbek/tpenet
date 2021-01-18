<?php

namespace LaraAreaSupport;

class Constant {
    // @TODO

    /**
     *
     * @param bool $isFlip
     * @return mixed
     * @throws \ReflectionException
     */
    public static function constants($isFlip = true)
    {
        $reflection = new \ReflectionClass(static::class);
        $constants = $reflection->getConstants();

        if ($isFlip) {
            $constants = array_flip($constants);
        }

        return $constants;
    }
}