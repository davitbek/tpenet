<?php

namespace Api\V1\Http\Controllers\Enet;

use Api\V1\Http\Controllers\BaseController as MainBaseController;

class BaseController extends MainBaseController
{
    protected $mainFolderInDeep = 2;

    /**
     * @return string
     */
    public function getLanguage()
    {
        $user = $this->getAuth();
        return $user->lang ?? \App::getLocale();
    }
}
