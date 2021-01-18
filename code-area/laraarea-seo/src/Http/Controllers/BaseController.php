<?php

namespace LaraAreaSeo\Http\Controllers;

use LaraAreaAdmin\Http\Controllers\AdminController;

class BaseController extends AdminController
{
    /**
     *
     */
    protected function makeViewRoot()
    {
        $this->viewRoot = config('laraarea_seo.web.view.path');
    }
}
