<?php

namespace Api\V1\Models\Enet;

use App\Jobs\Notification\EventEndNotification;
use App\Jobs\Notification\EventFirstHalfEndNotification;
use App\Jobs\Notification\EventLineupNotification;
use App\Jobs\Notification\EventSecondHalfStartNotification;
use App\Jobs\Notification\EventStartNotification;

/**
 * Class EnetProperty
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string $object
 * @property int $object_id
 * @property string $type
 * @property string $name
 * @property string|null $value
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetProperty whereValue($value)
 * @mixin \Eloquent
 */
class EnetProperty extends BaseModel
{
    protected $table = 'enet_properties';

    protected $fillable = [
        'id',
        'object',
        'object_id',
        'type',
        'name',
        'value',
        'n',
        'ut',
        'is_deleted'
    ];

    public static function boot()
    {
        parent::boot();

        self::saved(function ($item) {
            $keys = [
                'object',
                'object_id',
                'name',
                'value',
            ];

            if ($item->wasRecentlyCreated || array_keys_exists($keys, $item->getChanges())) {
                if ('GameStarted' == $item->name) {
                    dispatch(new EventStartNotification($item));
                }

                if ('FirstHalfEnded' == $item->name) {
                    dispatch(new EventFirstHalfEndNotification($item));
                }

                if ('SecondHalfStarted' == $item->name) {
                    dispatch(new EventSecondHalfStartNotification($item));
                }

                if ('LineupConfirmed' == $item->name) {
                    dispatch(new EventLineupNotification($item));
                }

                if ('GameEnded' == $item->name) {
                    dispatch(new EventEndNotification($item));
                }
            }

        });
    }
}
