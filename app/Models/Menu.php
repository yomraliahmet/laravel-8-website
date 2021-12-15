<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Menu
 *
 * @property int $id
 * @property int|null $menu_id
 * @property string|null $route
 * @property string|null $url
 * @property string $target
 * @property string|null $icon
 * @property string|null $permission
 * @property int|null $order
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Menu|null $menu
 * @property-read \Illuminate\Database\Eloquent\Collection|Menu[] $menus
 * @property-read int|null $menus_count
 * @property-read \App\Models\MenuTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Menu active()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Query\Builder|Menu onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel translated()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu wherePermission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTarget($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withTranslation()
 * @method static \Illuminate\Database\Query\Builder|Menu withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Menu withoutTrashed()
 * @mixin \Eloquent
 */
class Menu extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'menu_id',
        'permission',
        'route',
        'url',
        'icon',
        'target'
    ];

    public $translatedAttributes = [
        'name',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function childrenMenus()
    {
        return $this->hasMany(Menu::class)->with(['menus' => function($query){
            $query->withTranslation()->orderBy("order","asc");
        }])->withTranslation()->orderBy("order","asc");
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
