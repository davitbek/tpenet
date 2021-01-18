<?php

namespace Api\V1\Services;

use Api\V1\Models\Archived\ArchivedBettingOffer;
use Api\V1\Models\Archived\ArchivedOutcome;
use Api\V1\Models\Enet\EnetBettingOffer;
use Api\V1\Models\Enet\EnetEvent;
use Api\V1\Models\Enet\EnetOutcome;
use Api\V1\Models\UserTip;
use App\Jobs\UserTip\SentTipCreated;
use LaraAreaApi\Exceptions\ApiException;
use Traits\Services\Api\UserTipServiceTrait;

class UserTipService extends BaseService
{
    use UserTipServiceTrait;

    /**
     * @param $data
     * @return UserTip|\Illuminate\Database\Eloquent\Model
     * @throws ApiException
     * @throws \LaraAreaValidator\Exceptions\ValidationException
     */
    public function storeEnetTips($data)
    {
        $this->validate($data, [
            'event_id' => 'required|numeric',
            'outcome_id' => 'required|numeric',
            'odds_id' => 'required|numeric',
            'odds_value' => 'required|numeric',
            'amount' => 'required|numeric|max:1000|min:10',
        ]);

        $eventId = $data['event_id'];
        $outcomeId = $data['outcome_id'];
        $oddsId = $data['odds_id'];
        $odd = $data['odds_value'];
        $provider = \ConstProviders::ENETPULSE;
        $event = EnetEvent::find($eventId);

        if (empty($event)) {
            throw new ApiException(\ConstErrorCodes::INVALID_ODD_PRICE, mobile_validation('invalid_event'));
        }

        if ($event->status_type == \ConstEnetStatusType::Finished) {
            // TODO uncomment
            throw new ApiException(\ConstErrorCodes::INVALID_ODD_PRICE, mobile_validation('event_finished'));
        }

        if ($event->start_date < now()) {
            throw new ApiException(\ConstErrorCodes::INVALID_ODD_PRICE, mobile_validation('event_started'));
        }

        if ($this->getAuth()->user_tips()->where('event_id', $event->id)->count() >= 3) {
            throw new ApiException(\ConstErrorCodes::ALREADY_PLACED_3_TIPS, mobile_validation('already_placed_3_tips'));
        }

        $bettingOffer = EnetBettingOffer::find($oddsId);

        if (empty($bettingOffer)) {
            throw new ApiException(\ConstErrorCodes::INVALID_ODD, mobile_validation('invalid_or_suspended_odds', ['odd_id' => $oddsId]));
        }

        if ($bettingOffer->outcome_id != $outcomeId) {
            throw new ApiException(\ConstErrorCodes::INVALID_ODD_PRICE, mobile_validation('invalid_outcome'));
        }

        $outcome = $bettingOffer->outcome;
        if (empty($outcome)) {
            throw new ApiException(\ConstErrorCodes::INVALID_ODD_PRICE, mobile_validation('invalid_outcome'));
        }

        if (empty($bettingOffer->is_active)) {
            throw new ApiException(\ConstErrorCodes::INVALID_ODD, mobile_validation('invalid_betting_offer_is_not_active'));
        }

        if ($bettingOffer->betting_offer_status_id != \ConstBettingOfferStatus::Active) {
            $statusLabel = __('mobile.betting_offer_status.' . $bettingOffer->betting_offer_status_id);
            throw new ApiException(
                \ConstErrorCodes::INVALID_ODD,
                mobile_validation('invalid_betting_offer_status', ['status' => $statusLabel])
            );
        }

        if ($bettingOffer->odds != $odd) {
            throw new ApiException(\ConstErrorCodes::INVALID_ODD_PRICE, mobile_validation('odds_value_changed', ['odd_price' => $bettingOffer->odds]));
        }

        if ($outcome->object != \ConstEnetObjectType::EVENT || $outcome->object_id != $eventId) {
            throw new ApiException(\ConstErrorCodes::INVALID_ODD, mobile_validation('invalid_or_suspended_odds', ['odd_id' => $oddsId]));
        }

        // @TODO validate all data

        $isHasTip = UserTip::where([
            'user_id' => $this->getAuthUserId(),
            'event_id' => $eventId,
            'odds_id' => $oddsId,
            'odds_type_id' => $outcomeId,
            'provider' => $provider,
            'odds_provider_id' => $bettingOffer->odds_provider_id
        ])->exists();

        if ($isHasTip) {
            throw new ApiException(\ConstErrorCodes::USER_TIP_EXISTS, mobile_validation('already_created_tip'));
        }

        ArchivedOutcome::updateOrCreate(['id' => $outcome->id], $outcome->toArray());
        ArchivedBettingOffer::updateOrCreate(['id' => $bettingOffer->id], $bettingOffer->toArray());
        return $this->createTipByEnet($data, $outcome, $event, $bettingOffer->odds_provider_id);
    }

    /**
     * @param $data
     * @param EnetOutcome $outcome
     * @param $event
     * @param $oddsProviderId
     * @return UserTip|\Illuminate\Database\Eloquent\Model
     * @throws ApiException
     */
    public function createTipByEnet($data, EnetOutcome $outcome, $event, $oddsProviderId)
    {
        \DB::beginTransaction();
        $amount = $data['amount'];
        $homeName = $event->home_name;
        $awayName = $event->away_name;
        $userTipData = [
            'odds_provider_id' => $oddsProviderId,
            'user_id' =>  $this->getAuthUserId(),
            'event_id' => $data['event_id'],
            'sport_id' => $event->sport_id,
            'odds_type_id' => $data['outcome_id'],
            'odds_id' => $data['odds_id'],
            'odds' => $data['odds_value'],
            'tip_amount' => $amount,
            'point' => 0, // @TODO correct
            'score' => 0, // @TODO correct this is game score
            'result_status' => \ConstUserTipResultStatus::UNKNOWN,
            'result_validation' => \ConstUserTipResultValidationStatus::NOT_VALIDATED,
            'provider' => \ConstProviders::ENETPULSE,
            'sport_readable_id' => $event->sport->readable_id ?? 'football',
            'league_name' => $event->tournament_stage_name ?? $event->tournament_stage->name ?? 'TODO',
            'odds_type_name' => $outcome->outcome_sub_type_full_name,
            'odds_name' => $outcome->odds_name,
            'home_name' => $homeName,
            'away_name' => $awayName,
            'event_started_at' => $event->start_date,
            'home_id' => $event->first_participant_id,
            'away_id' => $event->second_participant_id,
        ];
        $userTip = UserTip::create($userTipData);
        if (! empty($data['comment'])) {
            $comment = $userTip->comments()->create([
                'comment' => $data['comment'],
                'user_id' => $this->getAuthUserId()
            ]);
        }

        $user = $this->getAuth();

        $user->update([
            'tip_amount' =>  $user->tip_amount + $amount,
            'balance' =>  $user->balance - $amount,
            'tip_count' =>  $user->tip_count + 1,
        ]);

        dispatch(new SentTipCreated($user, $userTip));
        $userStatistic = $this->fixStatistics($user, $amount);
        if ($userTip) {
            \DB::commit();
            return $userTip;
        }

        \DB::rollBack();
        throw new ApiException(\ConstErrorCodes::UN_CATEGORIZED, mobile_validation('unknown_error'));
    }
}
