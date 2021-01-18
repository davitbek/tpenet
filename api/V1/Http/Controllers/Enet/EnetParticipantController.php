<?php

namespace Api\V1\Http\Controllers\Enet;

use Api\V1\Services\Enet\EnetParticipantService;
use Api\V1\Transformers\Enet\EnetParticipantTransformer;
use Illuminate\Http\Request;

class EnetParticipantController  extends BaseController
{
    /**
     * @var EnetParticipantService
     */
    protected $service;

    /**
     * @var EnetParticipantTransformer
     */
    protected $transformer;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function teams(Request $request)
    {
        $result = $this->service->teams($request->all());
        return $this->sendSuccess($result, null, 'transformTeams');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function athletes(Request $request)
    {
        $result = $this->service->athletes($request->all());
        return $this->sendSuccess($result, null, 'transformAthletes');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userTeams(Request $request)
    {
        $result = $this->service->userTeams($request->all());
        return $this->sendSuccess($result, null, 'transformTeams');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function feedTeams(Request $request)
    {
        $result = $this->service->feedTeams($request->all());
        return $this->sendSuccess($result, null, 'transformTeams');
    }

    /**
     * @param Request $request
     * @param $type
     * @param $participant_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function showByType(Request $request, $type, $participant_id)
    {
        $data['where']['type'] = $type;
        $data['where']['id'] = $participant_id;
        $data['order_by']['name'] = 'asc';
        $data['all'] = true;
        $data['columns']= [
            'id',
            'country_id',
            'gender',
            'name',
            'first_name',
            'last_name',
            'type',
            'country_name',
        ];
        $data['with'] = [
            'teams' => [
                'columns' => [
                    'id',
                    'country_id',
                    'gender',
                    'name',
                    'first_name',
                    'last_name',
                    'type',
                    'country_name',
                ],
            ],
            'athletes' => [
                'columns' => [
                    'id',
                    'country_id',
                    'gender',
                    'name',
                    'first_name',
                    'last_name',
                    'type',
                    'country_name',
                ],
            ],
            'properties' => [
                'columns' => [
                    'id',
                    'participant_id',
                    'name',
                    'type',
                    'value',
                ],
            ]
        ];
        $request->merge($data);
        return parent::index($request); // TODO: Change the autogenerated stub
    }

    public function teamParticipants($teamId)
    {
        $items = $this->service->teamParticipants($teamId);
        $response = $this->transformer->transformTeamParticipants($items);
        return $this->response->success($response);
    }

    public function athleteTeams(Request $request, $participantId)
    {
        $items = $this->service->athleteTeams($participantId);
        $response = $this->transformer->transform($items, $request, 'transformAthleteTeams');
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $followingId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function favoriteUnFavorite(Request $request, $followingId)
    {
        $result = $this->service->favoriteUnFavorite($followingId);
        $response = $this->transformer->transform($result, $request);
        return $this->response->success($response);
    }

}
