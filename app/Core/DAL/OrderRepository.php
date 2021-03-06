<?php
namespace App\Core\DAL;

use GuzzleHttp\Client;
use App\Core\Models\Order;
use App\Core\Helpers\Utilities;
use Spatie\QueryBuilder\QueryBuilder;

class OrderRepository extends BaseRepository
{

    public function index($take, $skip)
    {
        $categories = QueryBuilder::for(Order::class)
        ->allowedFilters('id', 'user_id', 'product_id')
        ->allowedSorts('id')
        ->allowedIncludes('user', 'product')
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
        $categories = QueryBuilder::for(Order::where('id', $id))
        ->allowedIncludes('user', 'product')
        ->firstOrFail();
        return $categories;
    }

    public function myOrders($take, $skip)
    {
        $user_id = auth()->user()->id;
        $orders = QueryBuilder::for(Order::where('user_id', $user_id))
        ->allowedFilters('user_id', 'product_id', 'status')
        ->allowedSorts('id', 'user_id', 'product_id', 'status')
        ->allowedIncludes('user', 'product')
        ->take($take)
        ->skip($skip)
        ->get();
        return [
            'items' => $orders,
            'totalCount' => $orders->count()
        ];    

    }

    // <----------------------------------------Delivery System ------------------------------------------------>
        //Add Orders Repo
        public function insertOrder($request)
        {

            //Prossecing
            $client = new Client();
            $response = $client->post("https://api-delivery.enjaz.dev/api/v1/system/orders/create", [
                'headers' => [
                    'API-Key' => "mGcmNTt0DvNZN2yZRupQ0HVEOUBaQkoS",
                    'Content-Type' => 'application/json'
                ],
                'json' => [

                    "uid" => $request["uid"],
                    "items" =>  $request["items"],
                    "provider" => $request["provider"],
                    "customer" => $request["customer"]
                ]
            ]);

            //Response
             return $conditions = json_decode($response->getBody() , true);
    
        }

        //Add Orders Repo
        public function getListOrder($request)
        {
            //Prossecing
            $client = new Client();
            $response = $client->post("https://api-delivery.enjaz.dev/api/v1/system/orders/getList", [
                'headers' => [
                    'API-Key' => "mGcmNTt0DvNZN2yZRupQ0HVEOUBaQkoS",
                    'Content-Type' => 'application/json'
                ],
                'json' => [
                    "skip" =>  $request["skip"],
                    "take" =>  $request["take"]
                ]
            ]);
            
            //Response
             return $conditions = json_decode($response->getBody() , true);
        }
}
