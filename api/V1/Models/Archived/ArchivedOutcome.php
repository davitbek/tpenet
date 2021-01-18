<?php

namespace Api\V1\Models\Archived;

use Api\V1\Models\BaseModel;
use Traits\Models\OutcomeRelatedTrait;

/**
 * Class ArchivedOutcome
 * @package Api\V1\Models\Archived
 */
class ArchivedOutcome extends BaseModel
{
    use OutcomeRelatedTrait;

    protected $table = 'archived_outcomes';

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
