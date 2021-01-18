<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetLanguageType
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
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguageType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetLanguageType extends BaseModel
{

    protected $table = 'enet_language_types';

    public $fillable = [
        'id',
        'name',
        'description',
        'n',
        'ut',
        'is_deleted',
    ];

}
