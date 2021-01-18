<?php

namespace Api\V1\Observers;

use Api\V1\Models\Enet\EnetEvent;
use Api\V1\Models\UserFavoriteEnetEvent;
use Api\V1\Models\UserFavoriteEnetParticipant;

class UserFavoriteEnetParticipantObserver
{
    /**
     * Handle the userFavoriteEnetParticipant "created" event.
     *
     * @param  UserFavoriteEnetParticipant $userFavoriteEnetParticipant
     * @return void
     */
    public function creating(UserFavoriteEnetParticipant $userFavoriteEnetParticipant)
    {
        $day = config('api_config.team_events_as_favorite_within_days');
        $userId = $userFavoriteEnetParticipant->user_id;
        $participantId = $userFavoriteEnetParticipant->participant_id;

        $enetEventIds = EnetEvent
            ::where(function ($q) use ($participantId) {
                $q->where('first_participant_id', $participantId)
                    ->orWhere('second_participant_id', $participantId);
            })
            ->whereDate('start_date', '<=', now()->addDays($day)->format('Y-m-d'))
            ->whereDate('start_date', '>=', now()->format('Y-m-d'))
            ->pluck('id');

        $userFavoriteEnetEventIds = UserFavoriteEnetEvent
            ::where('user_id', $userId)
            ->whereIn('event_id', $enetEventIds)
            ->pluck('event_id');
        $newFavoriteEventIds = $enetEventIds->diff($userFavoriteEnetEventIds);

        $data = [];
        foreach ($newFavoriteEventIds as $enetEventId) {
            $data[] = [
                'user_id' => $userId,
                'event_id' => $enetEventId,
                'is_enabled' => 1,
                'created_at' => now()
            ];
        }
        UserFavoriteEnetEvent::insert($data);
    }

    /**
     * Handle the userFavoriteEnetParticipant "deleted" event.
     *
     * @param  UserFavoriteEnetParticipant  $userFavoriteEnetParticipant
     * @return void
     */
    public function deleting(UserFavoriteEnetParticipant $userFavoriteEnetParticipant)
    {
        $userId = $userFavoriteEnetParticipant->user_id;
        $participantId = $userFavoriteEnetParticipant->participant_id;
        $eventIds = EnetEvent::where('first_participant_id', $participantId)
            ->orWhere('second_participant_id', $participantId)->pluck('id');
        UserFavoriteEnetEvent::where('user_id', $userId)
            ->whereIn('event_id', $eventIds)->delete();
    }
}
