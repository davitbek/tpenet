<?php

namespace Api\V1\Services;

use Illuminate\Foundation\Bus\DispatchesJobs;
use LaraAreaApi\Services\ApiBaseAuthService;
use LaraAreaUpload\Traits\UploadProcessTrait;

class AuthUserService extends ApiBaseAuthService
{
    use DispatchesJobs, UploadProcessTrait;
}
