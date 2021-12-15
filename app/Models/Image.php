<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention;
use Ramsey\Uuid\Uuid;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $name
 * @property string $width
 * @property string $height
 * @property string|null $key
 * @property int $order
 * @property string|null $original_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $imageable_type
 * @property int $imageable_id
 * @property-read mixed $url
 * @property-read Model|\Eloquent $imageable
 * @property-write mixed $image
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Query\Builder|Image onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereImageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereOriginalUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Image whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|Image withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Image withoutTrashed()
 * @mixin \Eloquent
 */
class Image extends Model
{
    use SoftDeletes;

    public $resizeQuality = 90;

    protected $fillable = [
        'image',
        'key',
        'order',
    ];

    protected $hidden = [
        'id',
        'name',
        'key',
        'order',
        'original_url',
        'created_at',
        'updated_at',
        'deleted_at',
        'imageable_id',
        'imageable_type',
    ];

    protected $appends = [
        'url',
    ];

    public function getUrlAttribute()
    {
        return Storage::disk('images')->url($this->name);
    }

    public function setImageAttribute($value)
    {
        if ($value instanceof \Intervention\Image\Image) {
            $this->attributes['image'] = $value;
        } elseif ($value instanceof UploadedFile) {
            $this->attributes['image'] = Intervention::make($value->getRealPath());
        } elseif (is_string($value)) {
            $value = preg_replace('#^data:image/[^;]+;base64,#', '', $value);
            try {
                $this->attributes['image'] = Intervention::make(base64_decode($value));
            } catch (\Exception $e) {
                //
            }
        } else {
            throw new \Exception('Invalid Image');
        }
    }

    public function imageable()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (self $model) {
            $image = $model->attributes['image'];

            if ($image instanceof \Intervention\Image\Image) {

                if ($model->imageable_type != Image::class) {
                    $image = $model->createImage($image, $model);
                }

                $extension = $model->getExtension($image);

                // Save
                $filename = Uuid::uuid4()->toString() . '.' . $extension;
                $model->attributes['name'] = $filename;
                $model->attributes['width'] = $image->width();
                $model->attributes['height'] = $image->height();
                unset($model->attributes['image']);

                Storage::disk('images')->getDriver()->put(
                    $filename,
                    $image->encode($extension)->__toString(),
                    [
                        'visibility'   => Filesystem::VISIBILITY_PUBLIC,
                        'Expires'      => Carbon::now()->addYear()->toRfc1123String(),
                        'CacheControl' => 'max-age=31536000',
                    ]
                );

                return true;
            }

            return false;
        });

        static::saved(function (self $model) {
            if ($model->imageable_type == Image::class) {
                return;
            }
        });

        static::deleted(function (self $model) {
        });
    }

    /**
     * @param Intervention\Image\Image $image
     * @param $imagable
     * @param null $key
     * @return Intervention\Image\Image
     * @internal param array $dimensionArray
     */
    private function createImage(Intervention\Image\Image $image, $model)
    {
        if ($model->imageable instanceof ImageResizeInterface) {

            $width = $image->width();
            $height = $image->height();

            $maxWidth = $model->imageable->getMaxWidth($model->key);
            $maxHeight = $model->imageable->getMaxHeight($model->key);

            $widthRatio = $width / $maxWidth;
            $heightRatio = $height / $maxHeight;

            $ratio = max($widthRatio, $heightRatio);

            if ($ratio > 1) {
                $width = floor($width / $ratio);
                $height = floor($height / $ratio);
            }

            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        return $image;
    }

    private function getExtension($image)
    {
        $mime = $image->mime();  //edited due to updated to 2.x
        if ($mime == 'image/jpeg') {
            $extension = 'jpg';
        } elseif ($mime == 'image/png') {
            $extension = 'png';
        } elseif ($mime == 'image/gif') {
            $extension = 'gif';
        } else {
            $extension = 'jpg';
        }

        return $extension;
    }
}
