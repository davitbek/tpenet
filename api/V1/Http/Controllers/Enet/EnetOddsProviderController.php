<?php

namespace Api\V1\Http\Controllers\Enet;

use Illuminate\Http\Request;

class EnetOddsProviderController  extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function index(Request $request)
    {
        $ids = get_auth_access_odds_provider_ids();
        $data['where'] = [
            ['parent_id', '=', null],
            ['brand', '!=', null],
        ];
        $data['where_in']['id'] = $ids;
        $data['order_by'] = ['position'];
        $data['with']['translations']['where']['lang'] = $this->getLanguage();
        $request->merge($data);
        return parent::index($request);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function show(Request $request, $id)
    {
        $countryId = $user->country_id ?? get_country_by_ip()->id;
        // TODO fix later
//        $data['where'][] = ['brand', '!=', null];
//        $data['where'][] = ['tipya_active', '=', \ConstYesNo::YES];
//        $data['where_has']['country_betting_offers']['where']['country_id'] = $countryId;
        $data['with']['translations']['where']['lang'] = $this->getLanguage();
        $data['with']['affiliates_media'] = function ($q) {
            $q->where([
                ['lang',  '=', get_auth_locale()],
                ['started_at', '<=', now()],
                ['expires_at',  '>=', now()],
                ['active',  '=', \ConstYesNo::YES],
            ]);

            if (!$q->exists()) {
                $q->orWhere([
                    ['lang',  '=', 'en'],
                    ['started_at', '<=', now()],
                    ['expires_at',  '>=', now()],
                    ['active',  '=', \ConstYesNo::YES],
                ]);
            }
        };
        $request->merge($data);
        return parent::show($request, $id);
    }
}
