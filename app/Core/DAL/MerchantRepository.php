<?php
namespace App\Core\DAL;

use App\Core\Helpers\Utilities;
use App\Core\Models\Merchant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\QueryBuilder\QueryBuilder;

use Tymon\JWTAuth\Facades\JWTAuth;

class MerchantRepository extends BaseRepository
{

    public function index($take, $skip)
    {
        $merchants = QueryBuilder::for(Merchant::class)
        ->allowedFilters('name', 'email', 'phone', 'address')
        ->allowedSorts('id', 'name', 'email', 'phone', 'address')
        ->allowedIncludes('orders')
        ->take($take)
        ->skip($skip)
        ->get();
        return [
            'items' => $merchants,
            'totalCount' => $merchants->count()
        ];    

    }

    public function show($id)
    {
        $categories = QueryBuilder::for(Merchant::where('id', $id))
        ->allowedIncludes('orders')
        ->firstOrFail();
        return $categories;
    }

    public function store(array $data)
    {
        $data['password'] = Utilities::hash($data['password']);
        if(array_key_exists('image', $data))
        {
            $data['image'] = Utilities::upload($data['image'], 'merchants');
        }
        return $this->createModel(new Merchant($data));
    }

    public function edit(array $data, $id)
    {
        if(array_key_exists('image', $data))
        {
            if(!is_null($data['image']))
            {
                $data['image'] = Utilities::upload($data['image'], 'merchants');
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

    public function login($data)
    {
            $merchant = Merchant::where('phone', $data['phone'])
                ->first();
            if(!$merchant)
            {
                return response()->json(["message" => "merchant not found"], 404);
            }
            if(! Hash::check($data['password'], $merchant->password)) {
                return response()->json(["message" => "wrong password"], 401);
            }

            if (!$token = JWTAuth::customClaims(['exp' => Carbon::now()->addMonths(6)->timestamp])->fromUser($merchant)) {
                return response()->json(["message" => "incorrect credentials"], 401);
            }

            return response()->json([
                'token' => $token,
                'merchant' => $merchant
            ]);
    }

    public function me($data)
    {
        $categories = QueryBuilder::for(Merchant::where('id', $data->id))
        ->allowedIncludes('products.orders', 'products.orders.user')
        ->firstOrFail();
        return $categories;
    }

}
