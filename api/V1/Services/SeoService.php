<?php

namespace Api\V1\Services;

use Illuminate\Support\Str;

/**
 * Class SeoService
 * @package ApiX\Services
 */
class SeoService extends BaseService
{
    /**
     * @param null $uri
     * @param null $seoUri
     * @param array $params
     * @return mixed|string
     */
    public function generateSeo($uri = null, $seoUri = null, $params = [])
    {
        $seoService = \App::make(\App\Services\Web\SeoService::class);

        if (Str::startsWith($uri, 'sports')){
            $paths = explode('/', $uri);
            if (count($paths) == 1 || count($paths) == 2) {
                $seoUri = $uri;
            } else {
                $seoUrlPaths = explode('/', $seoUri);
                $seoUrlPaths = array_slice($seoUrlPaths, 0, count($paths));
                $seoUri = implode('/', $seoUrlPaths);
            }
        }

       return $seoService->generateByUri($seoUri);
    }
}
