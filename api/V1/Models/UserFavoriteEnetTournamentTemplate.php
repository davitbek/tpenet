<?php

namespace Api\V1\Models;

use Api\V1\Models\Enet\EnetTournamentStage;

/**
 * Class UserFavoriteEnetTournamentTemplate
 * @package Api\V1\Models
 */
class UserFavoriteEnetTournamentTemplate extends BaseModel
{
    public $timestamps = false;

    protected $table = 'user_favorite_enet_tournament_template';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'tournament_template_id',
        'created_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tournament_stage()
    {
        return $this->belongsTo(EnetTournamentStage::class, 'tournament_stage_id', 'id');
    }
}
