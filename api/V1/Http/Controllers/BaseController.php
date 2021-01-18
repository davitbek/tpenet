<?php

namespace Api\V1\Http\Controllers;

use Illuminate\Support\Str;
use \LaraAreaApi\Http\Controllers\BaseController as ApiBaseController;

class BaseController extends ApiBaseController
{
    /**
     * @return string
     */
    public function getLanguage()
    {
        $user = $this->getAuth();
        return $user->lang ?? \App::getLocale();
    }

    public function _show($request, $id)
    {
        // TODO
        if ($request->has('download') || $request->has('d')) {
            return $this->downloadResponse($request, $item);
        }
    }

    /**
     * @param $request
     * @param $result
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    protected function downloadResponse($request, $data)
    {
        // TODO
        $path = storage_path(Str::random());
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
        $savePath = str_replace($request->root(), '', $request->fullUrl());
        $savePath = str_replace('/', '_', $savePath);
        $savePath = str_replace('\\', '_', $savePath);
        $savePath = str_replace(PHP_EOL, '_', $savePath);
        return response()->download($path, time() . $savePath . '.txt')->deleteFileAfterSend(true);;
    }
}
