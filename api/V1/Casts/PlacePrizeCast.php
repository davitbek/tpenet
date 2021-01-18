<?php

namespace Api\V1\Casts;

use LaraAreaModel\Interfaces\CastInterface;

class PlacePrizeCast implements CastInterface
{
    public function handle($value)
    {
        $value = json_decode($value, JSON_OBJECT_AS_ARRAY);

        $prizes = [];
        foreach ($value as $single) {
            $prize = $single['prize'];
            $position = $single['position'];

            if (str_contains($position, '-')) {
                $positions = explode('-', $position);
                for($i = $positions[0]; $i <= $positions[1]; $i ++) {
                    $prizes[] = [
                        'position' => (int)$i,
                        'prize' => (int)$prize,
                    ];
                }
            } else {
                $prizes[] = [
                    'position' => (int)$position,
                    'prize' => (int)$prize,
                ];
            }
        }

        return collect($prizes)->sortBy('position')->values()->all();
    }
}
