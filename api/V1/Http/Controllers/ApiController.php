<?php

namespace Api\V1\Http\Controllers;

use Api\V1\Services\InformationService;
use Api\V1\Transformers\InformationTransformer;
use LaraAreaApi\Http\Responses\BaseApiResponse;
use Illuminate\Http\Request;
use LaraAreaTransformer\Transformer;

class ApiController
{
    /**
     * @var Transformer
     */
    protected $transformer;

    /**
     * @var BaseApiResponse
     */
    protected $response;

    /**
     * ApiController constructor.
     * @param BaseApiResponse $apiResponse
     * @param Transformer $apiTransformer
     */
    public function __construct(BaseApiResponse $apiResponse, Transformer $apiTransformer)
    {
        $this->transformer = $apiTransformer;
        $this->response = $apiResponse;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function main(Request $request)
    {
        $informationService = \App::make(InformationService::class);
        $informationTransformer = \App::make(InformationTransformer::class);
        $information = $informationService->get($request->uri);

        $result = [
            'locale' => $this->getLocale(),
            'profileWhiteUrl' => get_profile_white_url(),
            'appStoreImageUrls' => $this->getAppStoreImageUrls(),
            'information' => $informationTransformer->transform($information, $request, 'index'),
        ];

        $response = $this->transformer->transform($result, $request);
        return $this->response->success($response);
    }

    /**
     * @return mixed|string
     */
    public function getLocale()
    {
        return get_auth_locale();
    }

    /**
     * @return array
     */
    public function getAppStoreImageUrls()
    {
        return [
            'googlePng' => get_appstore_image_url('google', 'png'),
            'googleWebP' => get_appstore_image_url('google', 'webp'),
            'appleBlack' => get_appstore_image_url('apple_black', 'svg'),
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function getTranslations()
    {
        $translations = [];

        $langPath = resource_path('lang' . DIRECTORY_SEPARATOR . 'en');

        foreach (glob($langPath . DIRECTORY_SEPARATOR . '*.php') as $filename) {
            $filename = basename($filename);
            $filename = str_replace('.php', '', $filename);
            $translations[$filename] = __($filename, [], \App::getLocale());
        }

        return $translations;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateOdds(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = \Auth::id();
        $data['created_at'] = now();
        $data['updated_at'] = now();
        \Illuminate\Support\Facades\DB::table('odds_chance_assessment')->insert($data);
        return response()->json('ok');
    }
}
