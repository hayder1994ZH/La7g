<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Core\Models\Rating;
use Spatie\QueryBuilder\QueryBuilder;

class RatingRepository extends BaseRepository
{

    public function rate($data)
    {
        $check = Rating::where('product_id', $data['product_id'])
                        ->where('user_id', $data['user_id'])
                        ->first();
        if($check)
        {
            return $this->delete($check->id);
        }
        else
        {
            return $this->createModel(new Rating($data));
        }
    }

}
