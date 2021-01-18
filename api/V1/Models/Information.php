<?php

namespace Api\V1\Models;

use App\Models\TranslateAbleModel;

/**
 * Class Information
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $parent_id Set Null for global
 * @property string|null $lang Set Null when parent_id is null
 * @property string|null $uri
 * @property string|null $url
 * @property string|null $headline
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed|string $language
 * @property-read mixed $main_descriptive
 * @property-read mixed $translation
 * @property-read mixed $url_by
 * @property-read Information|null $main
 * @property-read \Illuminate\Database\Eloquent\Collection|Information[] $translations
 * @property-read int|null $translations_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Api\V1\Models\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Information newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Information newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Information query()
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereHeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereUri($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Information whereUrl($value)
 * @mixin \Eloquent
 */
class Information extends TranslateableModel
{
    /**
     * @var string
     */
    protected $descriptiveAttribute = 'headline';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'lang',
        'uri',
        'url',
        'headline',
        'content',
    ];

    /**
     * @var array
     */
    protected $paginateable = [
        'lang' => [
            'attribute' => 'language',
            'group' => \ConstIndexableGroup::TRANSLATIONS
        ],
        'headline' => [
            'group' => [
                \ConstIndexableGroup::TRANSLATIONS,
                \ConstIndexableGroup::INDEX,
            ]
        ],
        'uri',
        'url',
        'headline',
        'content',
    ];

    /**
     * @var array
     */
    protected $translateable = [
        'headline',
        'content',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_information');
    }
}