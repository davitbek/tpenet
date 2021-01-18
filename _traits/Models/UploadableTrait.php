<?php

namespace Traits\Models;

trait UploadableTrait
{
    use \LaraAreaUpload\Traits\UploadableTrait;

    /**
     * @return string
     */
    public function getDefaultDisk()
    {
        return 's3';
    }

}