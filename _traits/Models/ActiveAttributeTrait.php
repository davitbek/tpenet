<?php

namespace Traits\Models;

trait ActiveAttributeTrait
{
    public function getActiveAttribute()
    {
        return $this->is_active = 1 ? 'Yes' : 'No';
    }

}
