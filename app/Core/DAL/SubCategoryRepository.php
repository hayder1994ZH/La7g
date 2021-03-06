<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Core\Models\SubCategory;
use Spatie\QueryBuilder\QueryBuilder;

class SubCategoryRepository extends BaseRepository
{

    public function index($take, $skip)
    {
        $categories = QueryBuilder::for(SubCategory::class)
        ->allowedFilters('name')
        ->allowedSorts('id', 'name')
        ->allowedIncludes('category')
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
        $categories = QueryBuilder::for(SubCategory::where('id', $id))
        ->allowedIncludes('category')
        ->firstOrFail();
        return $categories;
    }
}
