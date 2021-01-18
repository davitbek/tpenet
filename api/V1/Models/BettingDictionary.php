<?php

namespace Api\V1\Models;

use Traits\Models\TranslationTrait;

/**
 * Class BettingDictionary
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $parent_id Set Null for global
 * @property string|null $lang Set Null when parent_id is null
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|BettingDictionary[] $betting_dictionaries
 * @property-read int|null $betting_dictionaries_count
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed|string $language
 * @property-read mixed $related_dictionaries
 * @property-read mixed $translation
 * @property-read mixed $url_by
 * @property-read BettingDictionary|null $main
 * @property-read \Illuminate\Database\Eloquent\Collection|BettingDictionary[] $self_betting_dictionaries
 * @property-read int|null $self_betting_dictionaries_count
 * @property-read \Illuminate\Database\Eloquent\Collection|BettingDictionary[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary query()
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary relateds()
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BettingDictionary whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BettingDictionary extends BaseModel
{
    use TranslationTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'lang',
        'name',
        'slug',
        'description',
    ];

    public function betting_dictionaries()
    {
        return $this->belongsToMany(self::class, 'betting_dictionary_betting_dictionary', 'betting_dictionary_id', 'related_betting_dictionary_id', 'id', 'id');
    }

    public function self_betting_dictionaries()
    {
        return $this->belongsToMany(self::class, 'betting_dictionary_betting_dictionary', 'related_betting_dictionary_id', 'betting_dictionary_id', 'id', 'id');
    }

    public function scopeRelateds($q)
    {
        return $q->with('self_betting_dictionaries', 'betting_dictionaries');
    }

    public function getRelatedDictionariesAttribute()
    {
        return $this->self_betting_dictionaries->merge($this->betting_dictionaries);
    }
}
