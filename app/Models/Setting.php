<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @property-read \App\Models\Image|null $image
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Setting query()
 * @mixin \Eloquent
 */
class Setting extends Model
{
    use HasFactory;

    const CURRENCIES_TRY = "TRY";
    const CURRENCIES_USD = "USD";

    const CURRENCIES = [
        self::CURRENCIES_TRY => self::CURRENCIES_TRY,
        self::CURRENCIES_USD => self::CURRENCIES_USD,
    ];

    protected $fillable = [
        'currency'
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
