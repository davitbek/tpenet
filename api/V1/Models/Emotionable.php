<?php

namespace Api\V1\Models;

/**
 * Class Emotionable
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $emotion_id
 * @property int|null $user_id
 * @property int $emotionable_id
 * @property string $emotionable_type
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|Emotionable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Emotionable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Emotionable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Emotionable whereEmotionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotionable whereEmotionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotionable whereEmotionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotionable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Emotionable whereUserId($value)
 * @mixin \Eloquent
 */
class Emotionable extends BaseModel
{
    protected $table = 'emotionables';

    public $timestamps = false;

    public $primaryKey = 'id';

}
