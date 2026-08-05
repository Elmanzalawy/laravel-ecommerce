<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\TranslatableContract;
use App\Models\Translations\ProductCategoryTranslation;
use App\Models\Translations\Translatable;
use Database\Factories\ProductCategoryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int|null $parent_id
 * @property string $slug
 * @property int $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Collection<int, ProductCategory> $children
 * @property-read int|null $children_count
 * @property-read string|null $name
 * @property-read ProductCategory|null $parent
 * @property-read Collection<int, ProductCategoryTranslation> $translations
 * @property-read int|null $translations_count
 * @method static \Database\Factories\ProductCategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategory withoutTrashed()
 * @mixin \Eloquent
 */
class ProductCategory extends Translatable implements TranslatableContract
{
    /** @use HasFactory<ProductCategoryFactory> */
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function getNameAttribute(): ?string
    {
        return $this->translations()->where('locale', app()->getLocale())->value('name');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(ProductCategoryTranslation::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }
}
