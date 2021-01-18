<?php

namespace Api\V1\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphPivot;

/**
 * Class EmotionablePivot
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $emotion_id
 * @property int|null $user_id
 * @property int $emotionable_id
 * @property string $emotionable_type
 * @method static \Illuminate\Database\Eloquent\Builder|EmotionablePivot newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmotionablePivot newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmotionablePivot query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmotionablePivot whereEmotionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmotionablePivot whereEmotionableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmotionablePivot whereEmotionableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmotionablePivot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmotionablePivot whereUserId($value)
 * @mixin \Eloquent
 */
class EmotionablePivot extends MorphPivot
{
    protected $table = 'emotionables';

    public $timestamps = false;

    public $primaryKey = 'id';

    public static function fromAttributes(Model $parent, $attributes, $table, $exists = false)
    {
        $instance = parent::fromAttributes($parent, $attributes, $table, $exists);
        $instance->fixTimestampsColumns($attributes);
        return $instance;
    }

    public static function fromRawAttributes(Model $parent, $attributes, $table, $exists = false)
    {
        $instance = parent::fromRawAttributes($parent, $attributes, $table, $exists);
        $instance->fixTimestampsColumns($attributes);
        return $instance;
    }

    protected function fixTimestampsColumns($attributes)
    {
        if ($this->timestamps) {
            if (! key_exists($this->getCreatedAtColumn(), $attributes)) {
                unset($this->attributes[$this->getCreatedAtColumn()]);
            }
            if (! key_exists($this->getUpdatedAtColumn(), $attributes)) {
                unset($this->attributes[$this->getUpdatedAtColumn()]);
            }
            $this->syncOriginal();
        }
    }
}
