<?php

namespace Domain\Catalog\Models;

use App\Models\Product;
use Domain\Catalog\Collection\CategoryCollection;
use Domain\Catalog\QueryBuilders\CategoryQueryBuilder;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Support\Traits\Models\HasSlug;
/**
 * @method static Category| CategoryQueryBuilder query()
 */
class Category extends Model
{
    use HasFactory;
    use HasSlug;

    protected $fillable = [
        'slug',
        'title',
        'on_home_page',
        'sorting'
    ];

    public function newEloquentBuilder($query)
    {
        return new CategoryQueryBuilder($query);
    }

    public  function newCollection(array $models = [])
    {
        return new CategoryCollection($models);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
}
