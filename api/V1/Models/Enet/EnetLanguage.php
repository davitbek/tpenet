<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetLanguage
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property string|null $object
 * @property int $object_id
 * @property int $language_type_id
 * @property string $name
 * @property int $is_used
 * @property int $n
 * @property string $locked
 * @property int $is_deleted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Api\V1\Models\Enet\EnetParticipant $participant
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereIsDeleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereIsUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereLanguageTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereN($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereObjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetLanguage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetLanguage extends BaseModel
{

    protected $table = 'enet_languages';

    public $fillable = [
        'id',
        'object',
        'object_id',
        'language_type_id',
        'name',
        'n',
        'ut',
        'locked',
        'is_used',
        'is_deleted',
        'locked',
    ];

    public function participant()
    {
        return $this->belongsTo(EnetParticipant::class, 'object_id');
    }

}
