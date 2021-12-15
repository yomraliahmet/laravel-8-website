<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MenuTranslation
 *
 * @property int $id
 * @property string $locale
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $menu_id
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation newQuery()
 * @method static \Illuminate\Database\Query\Builder|MenuTranslation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MenuTranslation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|MenuTranslation withTrashed()
 * @method static \Illuminate\Database\Query\Builder|MenuTranslation withoutTrashed()
 * @mixin \Eloquent
 */
class MenuTranslation extends Model
{
    use HasFactory, SoftDeletes;

    use SoftDeletes;

    protected $fillable = [
        "name"
    ];
}
