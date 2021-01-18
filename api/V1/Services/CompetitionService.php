<?php

namespace Api\V1\Services;

use Api\V1\Models\BettingDictionary;

class CompetitionService extends BaseService
{
    /**
     * @var BettingDictionary
     */
    protected $model;

    /**
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index($data)
    {
        $lang = get_auth_locale();

        $data['with']['translations'] = [
            'where' => ['lang' => $lang]
        ];
        $data['where']['parent_id'] = null;
        if (empty($data['all'])) {
            $data['paginate'] = true;
        }
        $result = $this->model->getByArray($data);
        return $result;
    }
}
