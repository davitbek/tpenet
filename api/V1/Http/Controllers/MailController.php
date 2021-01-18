<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Services\MailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use LaraAreaApi\Http\Responses\BaseApiResponse;

class MailController extends BaseController
{
    /**
     * MailController constructor.
     * @param BaseApiResponse|null $apiResponse
     * @param null $apiTransformer
     * @param null $apiService
     * @param null $apiModel
     * @param null $apiValidator
     */
    public function __construct(?BaseApiResponse $apiResponse = null, $apiTransformer = null, $apiService = null, $apiModel = null, $apiValidator = null)
    {
        $this->service = App::make(MailService::class);
        $this->response = App::make(BaseApiResponse::class);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function sendContactMessage(Request $request)
    {
        $this->service->sendContactMessage($request->all());
        return $this->response->success('ok');
    }
}
