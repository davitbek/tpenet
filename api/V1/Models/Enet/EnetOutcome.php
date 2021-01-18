<?php

namespace Api\V1\Models\Enet;

use Traits\Models\OutcomeRelatedTrait;

/**
 * Class EnetOutcome
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $object
 * @property int $object_id
 * @property int $outcome_type_id
 * @property int $outcome_scope_id
 * @property int $outcome_subtype_id
 * @property int $event_participant_number To be deprecated
 * @property int $iparam
 * @property int $iparam2
 * @property float $dparam
 * @property float $dparam2
 * @property string $sparam
 * @property int $is_deleted
 * @property int $n
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\Enet\EnetBettingOffer[] $betting_offers
 * @property-read int|null $betting_offers_count
 * @property-read \Api\V1\Models\Enet\EnetEvent $event
 * @property-read mixed $cacheable_timestamp
 * @property-read array|string|null $odds_name
 * @property-read array|string|null $outcome_sub_type_full_name
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereDparam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereDparam2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereEventParticipantNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereIparam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereIparam2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereOutcomeScopeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereOutcomeSubtypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereOutcomeTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereSparam($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetOutcome whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetOutcome extends BaseModel
{
    use OutcomeRelatedTrait;

    protected $table = 'enet_outcomes';

    public $fillable = [
        'id',
        'object',
        'object_id',
        'outcome_type_id',
        'outcome_scope_id',
        'outcome_subtype_id',
        'event_participant_number',
        'iparam',
        'iparam2',
        'dparam',
        'dparam2',
        'sparam',
        'is_deleted',
        'n',
    ];

    public function betting_offers()
    {
        return $this->hasMany(EnetBettingOffer::class, 'outcome_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(EnetEvent::class, 'object_id');
    }
}
