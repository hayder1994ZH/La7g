<?php

namespace App\Http\Controllers;

use App\Core\DAL\ImageRepository;
use App\Core\DAL\ProductRepository;
use App\Core\Helpers\Utilities;
use App\Core\Models\Image;
use App\Core\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductRepository $ProductRepository;
    private ImageRepository $ImageRepository;
    public function __construct()
    {
        $this->ProductRepository = new ProductRepository(new Product());
        $this->ImageRepository = new ImageRepository(new Image());
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
        $response = $this->ProductRepository->index($request->take, $request->skip);
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
            'title' => 'required|max:255',
            'details' => 'nullable',
            'subcategory_id' => 'required|integer|exists:sub_categories,id',
            'old_price' => 'nullable|max:255',
            'new_price' => 'nullable|max:255',
            'discount' => 'nullable|max:255',
            'lat' => 'nullable|max:255',
            'long' => 'nullable|max:255',
            'visable_date' => 'nullable|date|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        unset($data['images']);
        $data['merchant_id'] = 1;
        $product = $this->ProductRepository->createModel(new Product($data));
        $response = $this->ImageRepository->store($product['id'], $request->images);
        return Utilities::wrap($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->ProductRepository->show($id);
        return Utilities::wrap($response);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'details' => 'nullable',
            'subcategory_id' => 'required|integer|exists:sub_categories,id',
            'old_price' => 'nullable|max:255',
            'new_price' => 'nullable|max:255',
            'discount' => 'nullable|max:255',
            'lat' => 'nullable|max:255',
            'long' => 'nullable|max:255',
            'visable_date' => 'nullable|date|max:255',
        ]);
        $response = $this->ProductRepository->update($id, $data);
        return Utilities::wrap($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->ProductRepository->delete($id);
        return Utilities::wrap($response);
    }

    
    public function setStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => 'required|integer',
        ]);
        $response = $this->ProductRepository->update($id, $data);
        return Utilities::wrap($response);
    }
}
