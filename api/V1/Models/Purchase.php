<?php

namespace Api\V1\Models;

/**
 * Class Purchase
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int $user_id
 * @property string $purchase_date
 * @property string|null $end_date
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase query()
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase wherePurchaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Purchase whereUserId($value)
 * @mixin \Eloquent
 */
class Purchase extends BaseModel
{
    protected $table = 'purchases';

    protected $fillable = [
        'user_id',
        'purchase_date',
        'end_date',
        'type'
    ];

    public $selectableWith = [
        'index' => [
            'user',
        ],
        'show' => [
            'user',
        ],
    ];

    public $passableWith = [
        'create' => [
            'user',
        ],
        'update' => [
            'user',
        ],
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
