<?php

namespace App\Models;

use Spatie\Permission\Models\Permission;

/**
 * App\Models\PermissionGroup
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\PermissionGroupTranslation|null $translation
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PermissionGroupTranslation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel listsTranslations(string $translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel notTranslatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orWhereTranslation(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orWhereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel orderByTranslation(string $translationField, string $sortMethod = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel translated()
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel translatedIn(?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel whereTranslation(string $translationField, $value, ?string $locale = null, string $method = 'whereHas', string $operator = '=')
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel whereTranslationLike(string $translationField, $value, ?string $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BaseModel withTranslation()
 * @mixin \Eloquent
 */
class PermissionGroup extends BaseModel
{
    public $translatedAttributes = ['name'];

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
