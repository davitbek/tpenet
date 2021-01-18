<?php

namespace Api\V1\Models\Enet;

use LaraAreaTranslation\Traits\TranslationTrait;

/**
 * Class TranslationModel
 *
 * @package Api\V1\Models\Enet
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @property-read \Illuminate\Database\Eloquent\Collection|TranslationModel[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslationModel query()
 * @mixin \Eloquent
 */
class TranslationModel extends BaseModel
{
    use TranslationTrait;
}
