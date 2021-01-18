<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetParticipantSuggestion
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $participant_id
 * @property int $country_id
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipantSuggestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipantSuggestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipantSuggestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipantSuggestion whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipantSuggestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetParticipantSuggestion whereParticipantId($value)
 * @mixin \Eloquent
 */
class EnetParticipantSuggestion extends BaseModel
{
    public $timestamps = false;

    protected $table = 'enet_participant_suggestions';

    protected $fillable = [
        'participant_id',
        'country_id'
    ];
}
