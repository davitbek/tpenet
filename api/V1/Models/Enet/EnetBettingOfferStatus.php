<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetBettingOfferStatus
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $n
 * @property int $is_deleted
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetBettingOfferStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetBettingOfferStatus extends BaseModel
{
    protected $table = 'enet_betting_offer_statuses';

    protected $fillable = [
        'id',
        'n',
        'is_deleted',
        'name',
        'description',
        'ut',
    ];

}
