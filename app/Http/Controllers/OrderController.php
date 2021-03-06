<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Core\Models\Order;
use Illuminate\Http\Request;
use App\Core\Helpers\Utilities;
use App\Core\DAL\OrderRepository;

class OrderController extends Controller
{
    private OrderRepository $OrderRepository;
    private $user_id;
    public function __construct()
    {
        $this->OrderRepository = new OrderRepository(new Order());
        // $this->user_id = auth()->user()->id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'skip' => 'Integer',
            'take' => 'required|Integer',
        ]);
        $response = $this->OrderRepository->index($request->take, $request->skip);
        return Utilities::wrap($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'notes' => 'nullable',
        ]);
        $data['user_id'] = $this->user_id;
        $response = $this->OrderRepository->createModel(new Order($data));
        return Utilities::wrap($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->OrderRepository->show($id);
        return Utilities::wrap($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'notes' => 'nullable',
        ]);
        $response = $this->OrderRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->OrderRepository->delete($id);
        return Utilities::wrap($response);
    }

    public function setStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|integer',
        ]);
        $response = $this->OrderRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    public function myOrders(Request $request)
    {
        $request->validate([
            'skip' => 'Integer',
            'take' => 'required|Integer',
        ]);
        $response = $this->OrderRepository->myOrders($request->take, $request->skip);
        return Utilities::wrap($response);
    }

    //<---------------------------------------Send order to delivery system------------------------------------->

    //Add Orders
    public function AddOrder(Request $request)
    {
        //Validation
        $orderData =  $request->validate([
            'uid' => 'required|string',
            'items' => 'required|string',
            'provider' => 'required|string',
            'customer' => 'required|string',
        ]);
        
        //Prossecing
        $response = $this->OrderRepository->insertOrder($orderData);
         
        //Response
        return Utilities::wrap($response);

    }

    //Add Orders
    public function getAll(Request $request)
    {
        //Validation
        $getData =  $request->validate([
            'skip' => 'string',
            'take' => 'required|string'
        ]);

        //Prossecing
        $response = $this->OrderRepository->getListOrder($getData);
         
        //Response
        return Utilities::wrap($response);

    }

}
