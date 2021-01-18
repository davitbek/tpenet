<?php

namespace Api\V1\Http\Controllers;

use Illuminate\Http\Request;

class AppVersionController extends BaseController
{
    /**
     * @param Request $request
     * @param $version
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $version)
    {
        $data['where']['version'] = $version;
        $data['first'] = true;

        $item = $this->service->findByArray($version, $data, 'version');
        if ($item) {
            $response = $this->transformer->transform($item, $request);
            return $this->response->success($response);
        } else {
            $message = __('mobile.general.app_version_not_found', ['version' => $version]);
            return $this->response->notFoundItem($request, \ConstErrorCodes::NOT_FOUND, $message);
        }
    }
}
