<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Core\Models\Image;
use Spatie\QueryBuilder\QueryBuilder;

class ImageRepository extends BaseRepository
{
    public function store($id, array $data)
    {
        $images = [];
        foreach ($data as $key => $image) {
            $images = [
                'url' => Utilities::upload($image, 'Products'),
                'product_id' => $id
            ];
            $this->createModel(new Image($images));
        }
    }
}
