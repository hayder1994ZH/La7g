<?php

namespace App\Http\Controllers;

use App\Core\DAL\MerchantRepository;
use App\Core\Helpers\Utilities;
use App\Core\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    private MerchantRepository $MerchantRepository;
    public function __construct()
    {
        $this->MerchantRepository = new MerchantRepository(new Merchant());
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
        $response = $this->MerchantRepository->index($request->take, $request->skip);
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
            'name' => 'required|max:255',
            'email' => 'required|email|unique:merchants,email',
            'phone' => 'required|string|unique:merchants,phone',
            'password' => 'required|max:255',
            'address' => 'nullable',
            'image' => 'nullable|mimes:jpg,bmp,png',
        ]);
        $response = $this->MerchantRepository->store($data);
        return Utilities::wrap($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->MerchantRepository->show($id);
        return Utilities::wrap($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'password' => 'nullable|max:255',
            'address' => 'nullable',
            'image' => 'nullable|mimes:jpg,bmp,png',
        ]);
        $response = $this->MerchantRepository->edit($data, $id);
        return Utilities::wrap($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\merchant  $merchant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->MerchantRepository->delete($id);
        return Utilities::wrap($response);
    }



    public function login(Request $request)
    {
        $data = $request->validate([
            'phone' => 'required|max:255',
            'password' => 'required|max:255',
        ]);
        $response = $this->MerchantRepository->login($data);
        return $response;
    }


    public function me()
    {
        $data = auth('merchants')->user();
        $response = $this->MerchantRepository->me($data);
        return $response;
        return response()->json(auth('merchants')->user());
    }

}
