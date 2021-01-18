<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetClientLanguage
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $object_type_id
 * @property int $object_id
 * @property int $language_type_id
 * @property int $groups_id
 * @property string $name
 * @property int $n
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereGroupsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereLanguageTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereObjectTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetClientLanguage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetClientLanguage extends BaseModel
{

    protected $table = 'enet_client_languages';

    public $fillable = [
        'id',
        'object_type_id',
        'object_id',
        'language_type_id',
        'groups_id',
        'name',
        'n',
        'is_deleted',
    ];

}
