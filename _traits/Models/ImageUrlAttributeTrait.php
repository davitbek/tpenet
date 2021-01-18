<?php

namespace Traits\Models;

trait ImageUrlAttributeTrait
{
    public function getImageUrlAttribute()
    {
        return $this->getUrlByAttribute('image_path');
    }
}
