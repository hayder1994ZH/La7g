<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Core\Models\Category;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryRepository extends BaseRepository
{
    public function index($take, $skip)
    {
        $categories = QueryBuilder::for(Category::class)
        ->allowedFilters('name')
        ->allowedSorts('id', 'name')
        ->allowedIncludes('subCategories')
        ->take($take)
        ->skip($skip)
        ->get();
        return [
            'items' => $categories,
            'totalCount' => $categories->count()
        ];    

    }

    public function show($id)
    {
        $categories = QueryBuilder::for(Category::where('id', $id))
        ->allowedIncludes('subCategories')
        ->firstOrFail();
        return $categories;
    }
}
