<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Core\Models\Slider;
use Spatie\QueryBuilder\QueryBuilder;

class SliderRepository extends BaseRepository
{

    public function index($take, $skip)
    {
        $sliders = QueryBuilder::for(Slider::class)
        ->allowedFilters('title', 'redirect_to')
        ->allowedSorts('id')
        ->take($take)
        ->skip($skip)
        ->get();
        return [
            'items' => $sliders,
            'totalCount' => $sliders->count()
        ];    

    }

    public function store(array $data)
    {
        $data['image'] = Utilities::upload($data['image'], 'Sliders');
        return $this->createModel(new Slider($data));
    }



    public function edit($id, array $data)
    {
        if(array_key_exists('image', $data))
        {
            if(!is_null($data['image']))
            {
                $data['image'] = Utilities::upload($data['image'], 'Sliders');
            }
        }
        return $this->update($id, $data);
    }


    


}
