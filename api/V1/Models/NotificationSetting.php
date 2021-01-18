<?php

namespace Api\V1\Models;

use LaraAreaUpload\Traits\UploadableTrait;

/**
 * Class NotificationSetting
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int|null $parent_id
 * @property int $is_active
 * @property int|null $position
 * @property int $is_notification_setting
 * @property string|null $lang
 * @property string|null $column
 * @property string $label
 * @property string $group
 * @property string|null $sub_group
 * @property string|null $icon_disk
 * @property string|null $icon_path
 * @property string|null $description
 * @property string|null $content
 * @property string|null $tags_map
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $icon_url
 * @property-read mixed|string $language
 * @property-read mixed $translation
 * @property-read mixed $url_by
 * @property-read NotificationSetting|null $main
 * @property-read \Illuminate\Database\Eloquent\Collection|NotificationSetting[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereIconDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereIconPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereIsNotificationSetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereSubGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereTagsMap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationSetting whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class NotificationSetting extends TranslateableModel
{
    use UploadableTrait;

    /**
     * @var string
     */
    protected $descriptiveAttribute = 'label';

    /**
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'position',
        'is_active',
        'is_notification_setting',
        'lang',
        'group',
        'sub_group',
        'column',
        'label',
        'description',
        'content',
        'tags_map',
        'icon_path',
        'icon_disk'
    ];

    /**
     * @var array
     */
    protected $translateable = [
        'group',
        'sub_group',
        'label',
        'description',
        'content',
    ];

    /**
     * @return mixed
     */
    public function getIconUrlAttribute()
    {
        return $this->getUrlByAttribute('icon_path');
    }

    /**
     * @return string|null
     */
    public function getDefaultUpload()
    {
        return 'default.png';
    }

    /**
     * Get default uploaded disks
     *
     * @return string
     */
    public function getDefaultDisk()
    {
        return 's3';
    }
}
