<?php

namespace App\Http\Controllers;

use App\Core\DAL\ImageRepository;
use App\Core\Helpers\Utilities;
use App\Core\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    private ImageRepository $ImageRepository;
    public function __construct()
    {
        $this->ImageRepository = new ImageRepository(new Image());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->ImageRepository->delete($id);
        return Utilities::wrap($response);
    }
}
