<?php

namespace App\Models\Translations;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $product_category_id
 * @property string $locale
 * @property string|null $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read ProductCategory|null $productCategory
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategoryTranslation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategoryTranslation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategoryTranslation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategoryTranslation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategoryTranslation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategoryTranslation whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategoryTranslation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategoryTranslation whereProductCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ProductCategoryTranslation whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class ProductCategoryTranslation extends Model
{
    protected $guarded = [];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
