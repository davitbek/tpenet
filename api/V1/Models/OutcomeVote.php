<?php

namespace Api\V1\Models;

use Api\V1\Casts\PlacePrizeCast;
use Api\V1\Models\Enet\EnetSport;
use Api\V1\Models\Enet\EnetTournamentStage;
use App\Models\Enet\EnetOddsProvider;
use LaraAreaModel\Traits\CastsTrait;

/**
 * Class Competition
 * @package Api\V1\Models
 */
class OutcomeVote extends TranslateableModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'is_active',
        'outcome_type_id',
        'lang',
        'order',
        'question',
    ];

    /**
     * @var array
     */
    protected $translateable = [
        'question',
        'is_active',
    ];

    public function odds_providers()
    {
        return $this->belongsToMany(EnetOddsProvider::class, 'odds_provider_outcome_vote', 'outcome_vote_id', 'odds_provider_id');
    }
    public function sports()
    {
        return $this->belongsToMany(EnetSport::class, 'outcome_vote_sport', 'outcome_vote_id', 'sport_id');
    }
}
