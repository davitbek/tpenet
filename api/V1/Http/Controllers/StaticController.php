<?php

namespace Api\V1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class StaticController extends Controller
{
    /**
     * @return mixed
     */
    public function allLanguages(Request $request)
    {
        if ($request->flag) {
            $languages = languages_list();
            $response = [];
            foreach ($languages as $code => $language) {
                $path = sprintf('images/languages/%s.png', $code);
                $response[] = [
                    'code' => $code,
                    'language' => $language,
                    'flag' => file_exists(public_path($path)) ? url($path) : ''
                ];
            }

            return $response ;
        }
        return languages_list();
    }

    /**
     * @param $countryId
     * @return mixed
     */
    public function languagesByCountry($countryId)
    {
        $languages = languages_list();
        $country = get_country_by_id($countryId);
        $countryLanguages = $country->languages ?? [];
        $countryLanguages = array_unique(array_merge($countryLanguages, array_keys($languages)));
        uksort($languages, function($key1, $key2) use ($countryLanguages) {
            return ((array_search($key1, $countryLanguages) > array_search($key2, $countryLanguages)) ? 1 : -1);
        });

        return $languages;
    }

    /**
     * @return mixed
     */
    public function allTimezones()
    {
        return get_cached_timezones();
    }

    /**
     * @return mixed
     */
    public function timezonesByCountry($countryId)
    {
        $timeZones = $this->allTimezones();
        $country = get_country_by_id($countryId);
        $countryTimezones = $country->timezones ?? [];
        $countryTimezones = array_unique(array_merge($countryTimezones, $timeZones));
        return array_values($countryTimezones);
    }

    /**
     * @return mixed
     */
    public function oddTypes()
    {
        return [
            \ConstOddsType::DECIMALS => __('mobile.odds_types.decimal'),
            \ConstOddsType::FRACTIONAL => __('mobile.odds_types.fractional'),
        ];
    }
}
