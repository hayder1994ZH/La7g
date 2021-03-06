<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id', 'id');
    }

    public function rating()
    {
        return $this->hasMany(Rating::class)->selectRaw('ratings.product_id,avg(ratings.rate) as total')->groupBy('ratings.product_id');
    }
    
    
    public function orders()
    {
        return $this->hasMany(Order::class, 'product_id', 'id');
    }

        
    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
    

}
