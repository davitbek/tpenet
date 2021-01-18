<?php

namespace LaraAreaAdmin\Validators;

use LaraAreaValidator\AreaValidator;

class AdminValidator extends AreaValidator
{
    protected function isCheckbox()
    {
        return 'in:0,1';
    }
}
