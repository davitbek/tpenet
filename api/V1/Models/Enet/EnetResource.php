<?php

namespace Api\V1\Models\Enet;

/**
 * Class EnetResource
 *
 * @package Api\V1\Models\Enet
 * @property int $id
 * @property int $parsed_xml_id
 * @property string $resource
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResource query()
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResource whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResource whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResource whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResource whereParsedXmlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResource whereResource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EnetResource whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EnetResource extends BaseModel
{
    /**
     * @var string
     */
    protected $table = 'enet_resources';

    /**
     * @var array
     */
    public $fillable = [
        'parsed_xml_id',
        'resource',
        'data',
    ];

    /**
     * @var array
     */
    public $casts = [
        'data' => 'array'
    ];
}
