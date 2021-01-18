<?php

namespace Api\V1\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Api\V1\Models\CompetitionRank
 *
 * @property int $id
 * @property int $competition_id
 * @property int $user_id
 * @property int $tips_count
 * @property int $iteration
 * @property int $position
 * @property int|null $prize
 * @property string|null $period
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Api\V1\Models\Competition $competition
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank whereCompetitionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank whereIteration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank wherePrize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank whereTipsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompetitionRank whereUserId($value)
 * @mixin \Eloquent
 */
class CompetitionRank extends BaseModel
{
    public $fillable = [
        'competition_id',
        'user_id',
        'position',
        'profit',
        'prize',
        'tips_count',
        'iteration',
    ];

    /**
     * @return BelongsTo
     */
    public function competition()
    {
        return $this->belongsTo(Competition::class);
    }
    
    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
