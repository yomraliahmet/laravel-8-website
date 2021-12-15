<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PermissionGroupTranslation
 *
 * @property int $id
 * @property string $locale
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $permission_group_id
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupTranslation wherePermissionGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroupTranslation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PermissionGroupTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];
}
