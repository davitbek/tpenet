<?php

namespace Api\V1\Models\Enet;

use App\Jobs\Notification\EventResultNotification;

/**
 * Class EnetResult
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $event_participants_id
 * @property int $result_type_id
 * @property string $result_code
 * @property string $value
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult whereEventParticipantsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult whereResultCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult whereResultTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResult whereValue($value)
 * @mixin \Eloquent
 */
class EnetResult extends BaseModel
{
    protected $table = 'enet_results';

    protected $fillable = [
        'id',
        'event_participants_id',
        'result_type_id',
        'result_code',
        'value',
        'n',
        'ut',
        'is_deleted',
    ];

    public static function boot()
    {
        parent::boot();

        self::saved(function ($item) {
            $keys = [
                'event_participants_id',
                'result_type_id',
                'result_code',
                'value',
            ];

            if (($item->wasRecentlyCreated || array_keys_exists($keys, $item->getChanges())) && 'runningscore' == $item->result_code) {
                dispatch(new EventResultNotification($item));
            }
        });
    }
}
