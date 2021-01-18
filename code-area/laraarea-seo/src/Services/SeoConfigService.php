<?php

namespace LaraAreaSeo\Services;

use Illuminate\Support\Facades\DB;
use LaraAreaSeo\Cache\CachedSeo;
use LaraAreaSeo\Models\SeoConfig;
use Illuminate\Support\Facades\App;

class SeoConfigService extends BaseService
{
    /**
     * @param string[] $columns
     * @param array $with
     * @return \Illuminate\Database\Concerns\BuildsQueries|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|mixed|object|null
     */
    public function findSingle($columns = ['*'], $with = [])
    {
        return $this->modelQuery
            ->when($with, function ($q) use ($with){
                $q->with($with);
            })
            ->first($columns);
    }

    /**
     * @param $data
     * @return array|false
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Throwable
     */
    public function updateSingle($data)
    {
        $seoConfig = CachedSeo::seoConfig();
        $defaultSeo = CachedSeo::defaultSeo();

        if ($seoConfig) {
            $method = method_exists($this->validator, 'update') ? 'update' : 'create';
        } else {
            $method = 'create';
        }

        if (! $this->validate($data, $method)) {
            return false;
        }

        DB::beginTransaction();
        $seoConfig = $seoConfig ? $this->_update($seoConfig, $data) : $this->_create($data);
        CachedSeo::updateSeoConfig();
        $seoService = App::make(SeoService::class);

        $data['headline'] = SeoConfig::HEADLINE;
        $data['route_name'] = SeoConfig::ROUTE_NAME;
        $data['uri'] = SeoConfig::URI;
        $defaultSeo = $defaultSeo ? $seoService->_update($defaultSeo, $data) : $seoService->_create($data);
        CachedSeo::updateDefaultSeo();
        DB::commit();

        return [$seoConfig, $defaultSeo];
    }
}
