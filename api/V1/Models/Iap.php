<?php

namespace Api\V1\Models;

/**
 * Class Iap
 *
 * @package Api\V1\Models
 * @property int $id
 * @property string $text_color
 * @property string $border_color
 * @property string $bg_color
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Iap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Iap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Iap query()
 * @method static \Illuminate\Database\Eloquent\Builder|Iap whereBgColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iap whereBorderColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iap whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Iap whereTextColor($value)
 * @mixin \Eloquent
 */
class Iap extends BaseModel
{
    protected $table = 'app_configs';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function follow_user()
    {
        return true;// @TODO fix
    }
}
