<?php

namespace Api\V1\Models;

use LaraAreaModel\Traits\TranslationTrait;

/**
 * Class TranslateableModel
 *
 * @package Api\V1\Models
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed|string $language
 * @property-read mixed $translation
 * @property-read mixed $url_by
 * @property-read TranslateableModel $main
 * @property-read \Illuminate\Database\Eloquent\Collection|TranslateableModel[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|TranslateableModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslateableModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TranslateableModel query()
 * @mixin \Eloquent
 */
class TranslateableModel extends BaseModel
{
    use  TranslationTrait;
}
