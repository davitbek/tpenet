<?php

namespace Api\V1\Http\Controllers\Enet;

use Api\V1\Services\Enet\EnetEventService;
use Api\V1\Transformers\Enet\EnetEventTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EnetEventController  extends BaseController
{
    /**
     * @var EnetEventService
     */
    public $service;

    /**
     * @var EnetEventTransformer
     */
    public $transformer;

    /**
     * @param Request $request
     * @param $sportId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function popularSportEvents(Request $request, $sportId)
    {
        $limit = $request->limit ?? 10;
        $result = $this->service->getPopularEvents($sportId, $limit);
        $response = $this->transformer->transform($result, $request, 'transformEventWith3WayOffers');
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function feedEvents(Request $request)
    {
        [$prev, $next] = $this->service->feedEvents();
        $response = [
            'prev' => $this->transformer->transform($prev, $request, 'transformFeedEvent'),
            'next' => $this->transformer->transform($next, $request, 'transformFeedEvent'),
        ];
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $sportId
     * @return \Illuminate\Http\JsonResponse
     */
    public function userFavoriteEvents(Request $request, $time)
    {
        $result = $this->service->userFavoriteEvents($time);
        $response = $this->transformer->transform($result, $request, 'transformUserFavoriteEvents');
        return $this->response->success($response);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function userFavoriteEventCount()
    {
        $result['today'] = $this->service->userFavoriteEventsCount('today');
        $result['next'] = $this->service->userFavoriteEventsCount('next');
        $result['prev'] = $this->service->userFavoriteEventsCount('prev');
        return $this->response->success($result);
    }

    /**
     * @param Request $request
     * @param $sportId
     * @param $year
     * @param $month
     * @param $day
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function eventsByDateSport(Request $request, $sportId, $date)
    {
        max_execution_time(300);
        $this->service->validate(['date' => $date], ['date' => 'nullable|date']);
        $date = Carbon::parse($date);
        $result = $this->service->getEventsByDate($sportId, $date);
        $response = $this->transformer->transformEventsGroupByLeague($result, $sportId);
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $sportId
     * @param $date
     * @return mixed
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function eventsByDateSportForWeb(Request $request, $sportId, $date)
    {
        $this->service->validate(['date' => $date], ['date' => 'nullable|date']);
        $cacheKey = 'eventsByDateSportForWeb_' . $sportId . '_' . $date . $this->getAuthId();
        foreach ($request->all() as $key => $value) {
            $cacheKey .= '_' . $key  . '_' . $value;
        }

        $cacheKey .= get_auth_locale() . get_auth_timezone();
        $date = Carbon::parse($date);

        if (today()->diffInDays($date, false) < -1) {
            $cacheTime = 24 * 60 * 60;
        } else {
            $cacheTime = 1;
        }

        $response = \Cache::remember($cacheKey, $cacheTime, function () use ($request, $sportId, $date) {
            max_execution_time(300);
            $this->service->validate(['date' => $date], ['date' => 'nullable|date']);
            $date = Carbon::parse($date);
            $result = $this->service->getEventsByDateForWeb($sportId, $date, $request->league_id);
            return $this->transformer->transformEventsGroupByLeagueWeb($result, $sportId);
        });
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $leagueId
     * @return \Illuminate\Http\JsonResponse
     */
    public function leagueEvents(Request $request, $leagueId)
    {
        $limit = $request->limit ?? 10;
        $result = $this->service->getLeagueEvents($leagueId, $limit);
        $response = $this->transformer->transformEventsGroupByDate($result);
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $leagueId
     * @param null $date
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function leagueEventsByDate(Request $request, $leagueId, $date = null)
    {
        $this->service->validate(['date' => $date], ['date' => 'nullable|date']);
        $date = Carbon::parse($date);
        $result = $this->service->getLeagueEventsByDate($leagueId, $date);
        $response = $this->transformer->transform($result, $request, 'transformEventWith3WayOffers');
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvent(Request $request, $eventId)
    {
        [$event, $state] = $this->service->getLiveEvent($eventId, $request->all());
        if (empty($event)) {
            return $this->response->success([]);
        }
        $response = $this->transformer->transform([$event, $state], $request, 'transformSingleEvent');
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function eventBookmakers($eventId)
    {
        $result = $this->service->eventBookmakers($eventId);
        $response = $this->transformer->transformEventBookmakers($result);
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @param $outcomeTypeId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function eventBookmakersByOutcomeType($eventId, $outcomeTypeId)
    {
        $result = $this->service->eventBookmakersByOutcomeType($eventId, $outcomeTypeId);
        $response = $this->transformer->transformEventBookmakersByOutcomeType($result, $outcomeTypeId);
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventOdds($eventId)
    {
        $result = $this->service->eventOdds($eventId);
        $response = $this->transformer->transformEventOdds($result);
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @param $outcomeTypeId
     * @return \Illuminate\Http\JsonResponse
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function eventOddsByOutcomeType($eventId, $outcomeTypeId)
    {
        $result = $this->service->eventOddsByOutcomeType($eventId, $outcomeTypeId);
        $response = $this->transformer->transformEventOddsByOutcomeType($result, $outcomeTypeId);
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventHeadToHead($eventId)
    {
        $result = $this->service->eventHeadToHead($eventId);
        $response = $this->transformer->transformEventHeadToHead($result);
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventHeadToHeadExtended($eventId)
    {
        $result = $this->service->eventHeadToHeadExtended($eventId);
        if (empty($result)) {
            return $this->response->success([]);
        }
        $response = $this->transformer->transformPaginator($result,  null, 'transformHeadToHead');
        return $this->response->success($response);
    }

    /**
     * @param $teamId
     * @return \Illuminate\Http\JsonResponse
     */
    public function teamLastEvents($teamId)
    {
        $result = $this->service->teamLastEvents($teamId);
        if (empty($result)) {
            return $this->response->success([]);
        }
        $response = $this->transformer->transformCollection($result,  null, 'transformHeadToHead');
        return $this->response->success($response);
    }

    /**
     * @param $teamId
     * @return \Illuminate\Http\JsonResponse
     */
    public function teamNextEvents($teamId)
    {
        $result = $this->service->teamNextEvents($teamId);
        if (empty($result)) {
            return $this->response->success([]);
        }
        $response = $this->transformer->transformCollection($result,  null, 'transformHeadToHead');
        return $this->response->success($response);
    }

    /**
     * @param $teamId
     * @return \Illuminate\Http\JsonResponse
     */
    public function athleteLastEvents($teamId)
    {
        $result = $this->service->athleteLastEvents($teamId);
        if (empty($result)) {
            return $this->response->success([]);
        }
        $response = $this->transformer->transformCollection($result,  null, 'transformHeadToHead');
        return $this->response->success($response);
    }

    /**
     * @param $teamId
     * @return \Illuminate\Http\JsonResponse
     */
    public function athleteNextEvents($teamId)
    {
        $result = $this->service->athleteNextEvents($teamId);
        if (empty($result)) {
            return $this->response->success([]);
        }
        $response = $this->transformer->transformCollection($result,  null, 'transformHeadToHead');
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventHomeTeamEvents($eventId)
    {
        $result = $this->service->eventHomeTeamEvents($eventId);
        if (empty($result['items'])) {
            return $this->response->success([]);
        }

        $response = $this->transformer->transformPaginator($result['items'],  null, 'transformHeadToHead');
        $response = array_merge(['team' => $result['team']], $response);
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventAwayTeamEvents($eventId)
    {
        $result = $this->service->eventAwayTeamEvents($eventId);
        if (empty($result['items'])) {
            return $this->response->success([]);
        }

        $response = $this->transformer->transformPaginator($result['items'],  null, 'transformHeadToHead');
        $response = array_merge(['team' => $result['team']], $response);
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventLineups($eventId)
    {
        $result = $this->service->eventLineups($eventId);
        if (empty($result['event'])) {
            return $this->response->success([]);
        }
        $response = $this->transformer->transformEventLineups(...array_values($result));
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventOverViews($eventId)
    {
        $result = $this->service->eventOverViews($eventId);
        if (empty($result['event'])) {
            return $this->response->success([]);
        }

        $response = $this->transformer->transformEventOverViews(...array_values($result));
        return $this->response->success($response);
    }

    /**
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function eventOverViewsExtended($eventId)
    {
        $result = $this->service->eventOverViewsExtended($eventId);
        if (empty($result['event'])) {
            return $this->response->success([]);
        }

        $response = $this->transformer->transformEventOverViewsExtended(...array_values($result));
        return $this->response->success($response);
    }

    /**
     * @param Request $request
     * @param $eventId
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function favoriteUnFavorite(Request $request, $eventId)
    {
        $response = $this->service->favoriteUnFavorite($eventId);
        return $this->response->success($response);
    }


    /**
     * @param Request $request
     * @param $followingId
     * @return \Illuminate\Http\JsonResponse
     * @throws \LaraAreaApi\Exceptions\ApiException
     */
    public function enableUnenableFavoriteEvent(Request $request, $eventId)
    {
        $response = $this->service->enableUnenableFavoriteEvent($eventId);
        return $this->response->success($response);
    }

    public function storeEventOutcomeVote(Request $request, $eventId, $outcomeVoteId, $type)
    {
        $response = $this->service->storeEventOutcomeVote($eventId, $outcomeVoteId, $type);

        return $this->response->success($response);
    }

}
