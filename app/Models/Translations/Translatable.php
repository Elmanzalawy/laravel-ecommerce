<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translatable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translatable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Translatable query()
 *
 * @mixin \Eloquent
 */
abstract class Translatable extends Model
{
    protected static function booted(): void
    {
        $modelTranslationsArray = [];

        static::creating(function (Model $model) use (&$modelTranslationsArray) {
            $modelTranslationsArray = $model->getAttribute('translations');
            unset($model->translations);
        });
        static::created(function (Model $model) use (&$modelTranslationsArray) {
            foreach ($modelTranslationsArray as $translation) {
                $model->translations()->create($translation);
            }
        });
    }

    public function translations(): HasMany
    {
        return $this->hasMany(static::class);
    }
}
