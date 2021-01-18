<?php

namespace Api\V1\Transformers;

use Api\V1\Models\Competition;
use Api\V1\Models\CompetitionRank;
use Api\V1\Models\UserTip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionTransformer extends BaseTransformer
{
    protected $iteration;

    /**
     * @param $model
     * @param Request|null $request
     * @return mixed
     */
    public function toArray($model, ? Request $request = null)
    {
        $sports = $model->sports->pluck('name')->implode(', ');
        $sports = $sports ? $sports : __mobile('all_sports');
        $leagues = $model->tournament_stages->pluck('name')->implode(', ');
        $leagues = $leagues ? $leagues : __mobile('all_leagues');

        if ($this->iteration) {
            $iteration = $this->iteration;
        } else {
            $iterationVal = $request->iteration ?? $model->iteration;
            $iteration = $model->is_recurring ? $model->competition_iterations()->where('iteration', $iterationVal)->first() : null;
        }

        $model->translate(true, get_auth_locale());
        return [
            'id' => (int) $model->id,
            'picture_url' => (string) $model->picture_url,
            'sponsor_image_url' => (string) $model->sponsor_image_url,
            'prizepool' => (int) $model->prizepool,
            'currency' => (string) $model->currency,
            'place_prizes' => (array) $model->place_prizes,
            'headline' => (string) $model->headline_translated,
            'slug' => (string) $model->slug_translated,
            'sponsor' => (string) $model->sponsor_translated,
            'sponsor_url' => (string) $model->sponsor_url_translated,
            'text' => (string) $model->text_translated,
            'start_date' => $iteration->start_date ?? $model->start_date,
            'end_date' => $iteration->end_date ?? $model->end_date,
            'is_recurring' => $model->is_recurring,
            'iteration' => $model->iteration,
            'sports' => $sports,
            'leagues' => $leagues,
        ];
    }

    /**
     * @param Competition $model
     * @param Request|null $request
     * @return mixed
     */
    public function transformSingle($model, ? Request $request = null)
    {
        $iterationVal = $request->iteration ?? $model->iteration;
        $iteration = $model->is_recurring ? $model->competition_iterations()->where('iteration', $iterationVal)->first() : null;
        $this->iteration = $iteration;
        $response = $this->toArray($model, $request);
        $ranks = $model->competition_ranks()
            ->when($model->is_recurring, function ($q) use ($iterationVal) {
                $q->where('iteration', $iterationVal);
            })
            ->with('user:id,name,profile_disk,profile_path')
            ->select('competition_id', 'user_id', 'position', 'profit', 'prize', 'tips_count')
            ->orderBy('position')
            ->get();

        $userId  = Auth::guard('api')->id();
        if ($userId && ! $ranks->contains('user_id', $userId)) {
            $startDate = $iteration->start_date ?? $model->start_date;
            $endDate = $iteration->end_date ?? $model->end_date;
            $sports = $model->sports->pluck('id')->all();
            $tournamentStages = $model->tournament_stages->pluck('id')->all();

            $userTip = UserTip::when($sports || $tournamentStages,
                function ($q) use ($sports, $tournamentStages) {
                    $q->whereHas('event', function ($q) use ($sports, $tournamentStages) {
                        $q->when($sports, function ($q) use ($sports) {
                            $q->whereIn('sport_id', $sports);
                        })->when($tournamentStages, function ($q) use ($tournamentStages) {
                            $q->whereIn('tournament_stage_id', $tournamentStages);
                        });
                    });
                })
                ->where('result_validation', \ConstUserTipResultValidationStatus::VALIDATED)
                ->whereDate('validated_at', '>=', $startDate)
                ->whereDate('validated_at', '<=', $endDate)
                ->select('user_id')->selectRaw('SUM(point) as profit, count(*) as tips_count')
                ->where('user_id', $userId)
                ->groupBy('user_id')
                ->orderByDesc('profit')
                ->first();

            $rank = new CompetitionRank();
            $rank->setRelation('user', Auth::guard('api')->user());
            $rank->user_id = $userId;
            $rank->profit = $userTip->profit ?? '-';
            $rank->tips_count = $userTip->tips_count ?? 0;
            $rank->position = $ranks->count() . '+';
            $ranks->push($rank);
        }

        $response['ranks'] = $this->transform($ranks, $request, 'transformRank');

        return $response;
    }

    public function transformRank($rank, Request $request)
    {
        $user = $rank->user;
        return [
            'id' => $user->id ?? null,
            'name' => $user->name ?? '',
            'profile_url' => $user->profile_url ?? '',
            'profit' => is_numeric($rank->profit) ? number_format($rank->profit ?? 0) : $rank->profit,
            'prize' => !empty($rank->prize) ? $rank->prize : '-',
            'placed_tip_count' => $rank->tips_count,
            'position' => $rank->position,
        ];
    }
}
