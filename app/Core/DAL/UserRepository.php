<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Core\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository extends BaseRepository
{

    public function index($take, $skip)
    {
        $users = QueryBuilder::for(User::class)
        ->allowedFilters('name', 'email', 'phone', 'address')
        ->allowedSorts('id', 'name', 'email', 'phone', 'address')
        ->allowedIncludes('orders')
        ->take($take)
        ->skip($skip)
        ->get();
        return [
            'items' => $users,
            'totalCount' => $users->count()
        ];    

    }

    public function show($id)
    {
        $categories = QueryBuilder::for(User::where('id', $id))
        ->allowedIncludes('orders')
        ->firstOrFail();
        return $categories;
    }

    public function store(array $data)
    {
        $data['password'] = Utilities::hash($data['password']);
        if(array_key_exists('image', $data))
        {
            $data['image'] = Utilities::upload($data['image'], 'users');
        }
        return $this->createModel(new User($data));
    }

    public function edit(array $data, $id)
    {
        if(array_key_exists('image', $data))
        {
            if(!is_null($data['image']))
            {
                $data['image'] = Utilities::upload($data['image'], 'users');
            }
        }
        if(array_key_exists('password', $data))
        {
            if(!is_null($data['password']))
            {
                $data['password'] = Utilities::hash($data['password']);
            }
        }
        $data = array_filter($data);
        return $this->update($id, $data);
    }

    public function hash($password)
    {
        return $password = hash::make($password);
    }

}
