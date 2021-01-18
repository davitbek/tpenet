<?php

namespace Api\V1\Models;

/**
 * Class AppVersion
 *
 * @package Api\V1\Models
 * @property int $id
 * @property int $is_active_ios
 * @property int $is_active_android
 * @property string $version
 * @property int $maintenance
 * @property string $name
 * @property string $description
 * @property string|null $maintenance_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $cacheable_timestamp
 * @property-read mixed $url_by
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion query()
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereIsActiveAndroid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereIsActiveIos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereMaintenance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereMaintenanceText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AppVersion whereVersion($value)
 * @mixin \Eloquent
 */
class AppVersion extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_active_ios',
        'is_active_android',
        'version',
        'name',
        'description',
        'maintenance',
        'maintenance_text'
    ];
}