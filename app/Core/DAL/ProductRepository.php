<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Core\Models\Product;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository extends BaseRepository
{

    public function index($take, $skip)
    {
        $products = QueryBuilder::for(Product::class)
        ->allowedFilters('title', 'details', 'subcategory_id', 'status')
        ->allowedSorts('id', 'title', 'details', 'subcategory_id', 'status')
        ->allowedIncludes('subcategory', 'images', 'merchant')
        ->take($take)
        ->skip($skip)
        ->get();
        return [
            'items' => $products,
            'totalCount' => $products->count()
        ];    

    }

    public function show($id)
    {
        $product = QueryBuilder::for(Product::where('id', $id)->with('subcategory')->with('merchant')->with('images')->with('rating'))
        // ->allowedSorts('id', 'title', 'details', 'subcategory_id', 'status')
        // ->allowedIncludes('subcategory', 'images', 'merchant', 'rating')
        ->firstOrFail();
        return $product;
    }

}
